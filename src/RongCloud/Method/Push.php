<?php

namespace RongCloud\Method;

use RongCloud\Exception\RongCloudException;

class Push {

    private $SendRequest;
    private $format;

    public function __construct($SendRequest, $format) {
        $this->SendRequest = $SendRequest;
        $this->format = $format;
    }


    /**
     * 添加 Push 标签方法
     *
     * @param  userTag:用户标签。
     *
     * @return $json
     **/
    public function setUserPushTag($userTag) {
        try {
            if(empty($userTag))
                throw new RongCloudException('Paramer "userTag" is required');


            $params = json_decode($userTag, true);

            $ret = $this->SendRequest->curl('/user/tag/set.' . $this->format, $params, 'json', 'im', 'POST');
            if(empty($ret))
                throw new RongCloudException('bad request');
            return $ret;

        }catch(RongCloudException $e) {
            print_r($e->getMessage());
        }
    }

    /**
     * 广播消息方法（fromuserid 和 message为null即为不落地的push）
     *
     * @param  pushMessage:json数据
     *
     * @return $json
     **/
    public function broadcastPush($pushMessage) {
        try {
            if(empty($pushMessage))
                throw new RongCloudException('Paramer "pushMessage" is required');


            $params = json_decode($pushMessage, true);

            $ret = $this->SendRequest->curl('/push.' . $this->format, $params, 'json', 'im', 'POST');
            if(empty($ret))
                throw new RongCloudException('bad request');
            return $ret;

        }catch(RongCloudException $e) {
            print_r($e->getMessage());
        }
    }

}
