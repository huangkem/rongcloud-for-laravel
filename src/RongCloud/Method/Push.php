<?php

namespace RongCloud\Method;

use RongCloud\RongCloud;
use RongCloud\Exception\RongCloudException;

class Push extends RongCloud {

    public function __construct() {

    }

    /**
     * setUserPushTag [添加 Push 标签方法]
     *
     * @param string $userTag[用户标签。]
     *
     * @return int|mixed
     * @throws RongCloudException
     **/
    public function setUserPushTag($userTag) {
        try {
            if(empty($userTag)) {
                throw new RongCloudException('用户标签不能为空');
            }

            $params = json_decode($userTag, true);

            $ret = $this->curl('/user/tag/set', $params, 'json', 'im', 'POST');
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * broadcastPush [广播消息方法（fromuserid 和 message为null即为不落地的push）]
     *
     * @param string $pushMessage[json数据]
     *
     * @return int|mixed
     * @throws RongCloudException
     **/
    public function broadcastPush($pushMessage) {
        try {
            if(empty($pushMessage)) {
                throw new RongCloudException('推送数据不能为空');
            }

            $params = json_decode($pushMessage, true);

            $ret = $this->curl('/push', $params, 'json', 'im', 'POST');
            if(empty($ret)) {
                throw new RongCloudException('bad request');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

}
