<?php

namespace RongCloud;

use RongCloud\Method\Chatroom;
use RongCloud\Method\Group;
use RongCloud\Method\Message;
use RongCloud\Method\Push;
use RongCloud\Method\SMS;
use RongCloud\Method\User;
use RongCloud\Method\Wordfilter;
use RongCloud\Exception\RongCloudException;

use Illuminate\Config\Repository;

class RongCloud {
    const SERVERAPIURL = 'https://api.cn.ronghub.com';    //IM服务地址
    const SMSURL = 'http://api.sms.ronghub.com';          //短信服务地址

    private static $appKey;
    private static $appSecret;
    private static $format;

    /**
     * RongCloud constructor.
     *
     * @param Repository $config [获取配置文件]
     * @throws RongCloudException
     */
    public function __construct(Repository $config) {
        $appKey = $config->get('rongcloud.rongCloud_app_key'); // appkey
        $appSecret = $config->get('rongcloud.rongCloud_app_secret'); // appsecret
        $format = $config->get('rongcloud.rongCloud_format') ?? 'json'; // format

        if(empty($appKey) || empty($appSecret) || empty($format)) {
            throw new RongCloudException('融云配置填写有误');
        }

        self::$appKey = $appKey;
        self::$appSecret = $appSecret;
        self::$format = $format;
    }

    /**
     * createHttpHeader [创建http header参数]
     *
     * @return array
     */
    private function createHttpHeader() {
        $nonce = mt_rand();
        $timeStamp = time();
        $sign = sha1(self::$appSecret . $nonce . $timeStamp);
        return array(
            'RC-App-Key:' . self::$appKey,
            'RC-Nonce:' . $nonce,
            'RC-Timestamp:' . $timeStamp,
            'RC-Signature:' . $sign,
        );
    }

    /**
     * build_query [重写实现 http_build_query 提交实现(同名key)key=val1&key=val2]
     *
     * @param array  $formData      数据数组
     * @param string $numericPrefix 数字索引时附加的Key前缀
     * @param string $argSeparator  参数分隔符(默认为&)
     * @param string $prefixKey     Key 数组参数，实现同名方式调用接口
     * @return string
     */
    private function build_query($formData, $numericPrefix = '', $argSeparator = '&', $prefixKey = '') {
        $str = '';
        foreach($formData as $key => $val) {
            if(!is_array($val)) {
                $str .= $argSeparator;
                if($prefixKey === '') {
                    if(is_int($key)) {
                        $str .= $numericPrefix;
                    }
                    $str .= urlencode($key) . '=' . urlencode($val);
                }else {
                    $str .= urlencode($prefixKey) . '=' . urlencode($val);
                }
            }else {
                if($prefixKey == '') {
                    $prefixKey .= $key;
                }
                if(isset($val[0]) && is_array($val[0])) {
                    $arr = array();
                    $arr[$key] = $val[0];
                    $str .= $argSeparator . http_build_query($arr);
                }else {
                    $str .= $argSeparator . $this->build_query($val, $numericPrefix, $argSeparator, $prefixKey);
                }
                $prefixKey = '';
            }
        }
        return substr($str, strlen($argSeparator));
    }

    /**
     * curl [发起 server 请求]
     *
     * @param        $action
     * @param        $params
     * @param string $contentType
     * @param string $module
     * @param string $httpMethod
     * @return int|mixed
     */
    public function curl($action, $params, $contentType = 'urlencoded', $module = 'im', $httpMethod = 'POST') {
        switch($module) {
            case 'im':
                $action = self::SERVERAPIURL . $action . '.' . self::$format;
            break;
            case 'sms':
                $action = self::SMSURL . $action . '.' . self::$format;
            break;
            default:
                $action = self::SERVERAPIURL . $action . '.' . self::$format;
        }

        $httpHeader = $this->createHttpHeader();
        $ch = curl_init();
        if($httpMethod == 'POST' && $contentType == 'urlencoded') {
            $httpHeader[] = 'Content-Type:application/x-www-form-urlencoded';
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->build_query($params));
        }
        if($httpMethod == 'POST' && $contentType == 'json') {
            $httpHeader[] = 'Content-Type:Application/json';
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        }
        if($httpMethod == 'GET' && $contentType == 'urlencoded') {
            $action .= strpos($action, '?') === false ? '?' : '&';
            $action .= $this->build_query($params);
        }
        curl_setopt($ch, CURLOPT_URL, $action);
        curl_setopt($ch, CURLOPT_POST, $httpMethod == 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeader);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //处理http证书问题
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
//        curl_setopt($ch, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $ret = curl_exec($ch);
        if(false === $ret) {
            $ret = curl_errno($ch);
        }
        curl_close($ch);
        return $ret;
    }

    /**
     * @return \RongCloud\Method\Chatroom Chatroom
     * @throws RongCloudException
     */
    public function chatroom() {
        return new Chatroom();
    }

    /**
     * @return \RongCloud\Method\Group Group
     * @throws RongCloudException
     */
    public function group() {
        return new Group();
    }

    /**
     * @return \RongCloud\Method\Message Message
     * @throws RongCloudException
     */
    public function message() {
        return new Message();
    }

    /**
     * @return \RongCloud\Method\Push Push
     * @throws RongCloudException
     */
    public function push() {
        return new Push();
    }

    /**
     * @return \RongCloud\Method\SMS SMS
     * @throws RongCloudException
     */
    public function SMS() {
        return new SMS();
    }

    /**
     * @return \RongCloud\Method\User User
     * @throws RongCloudException
     */
    public function user() {
        return new User();
    }

    /**
     * @return \RongCloud\Method\WordFilter WordFilter
     * @throws RongCloudException
     */
    public function wordFilter() {
        return new WordFilter();
    }
}
