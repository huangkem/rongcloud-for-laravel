<?php

namespace RongCloud\Method;

use RongCloud\Exception\RongCloudException;

class Wordfilter {

    private $SendRequest;
    private $format;

    public function __construct($SendRequest, $format) {
        $this->SendRequest = $SendRequest;
        $this->format = $format;
    }


    /**
     * 添加敏感词方法（设置敏感词后，App 中用户不会收到含有敏感词的消息内容，默认最多设置 50 个敏感词。）
     *
     * @param  word:敏感词，最长不超过 32 个字符。（必传）
     *
     * @return $json
     **/
    public function add($word) {
        try {
            if(empty($word))
                throw new RongCloudException('Paramer "word" is required');


            $params = array(
                'word' => $word
            );

            $ret = $this->SendRequest->curl('/wordfilter/add.'.$this->format, $params, 'urlencoded', 'im', 'POST');
            if(empty($ret))
                throw new RongCloudException('bad request');
            return $ret;

        }catch(RongCloudException $e) {
            print_r($e->getMessage());
        }
    }

    /**
     * 查询敏感词列表方法
     *
     *
     * @return $json
     **/
    public function getList() {
        try {

            $params = array();

            $ret = $this->SendRequest->curl('/wordfilter/list.'.$this->format, $params, 'urlencoded', 'im', 'POST');
            if(empty($ret))
                throw new RongCloudException('bad request');
            return $ret;

        }catch(RongCloudException $e) {
            print_r($e->getMessage());
        }
    }

    /**
     * 移除敏感词方法（从敏感词列表中，移除某一敏感词。）
     *
     * @param  word:敏感词，最长不超过 32 个字符。（必传）
     *
     * @return $json
     **/
    public function delete($word) {
        try {
            if(empty($word))
                throw new RongCloudException('Paramer "word" is required');


            $params = array(
                'word' => $word
            );

            $ret = $this->SendRequest->curl('/wordfilter/delete.'.$this->format, $params, 'urlencoded', 'im', 'POST');
            if(empty($ret))
                throw new RongCloudException('bad request');
            return $ret;

        }catch(RongCloudException $e) {
            print_r($e->getMessage());
        }
    }

}