<?php

namespace RongCloud\Method;

use RongCloud\RongCloud;
use RongCloud\Exception\RongCloudException;

class Chatroom extends RongCloud {

    public function __construct() {

    }

    /**
     * create [创建聊天室方法]
     *
     * @param array $chatRoomInfo [id:要创建的聊天室的id；name:要创建的聊天室的name。（必传）]
     *
     * @return int|mixed
     * @throws RongCloudException
     **/
    public function create($chatRoomInfo) {
        try {
            if(empty($chatRoomInfo) || !is_array($chatRoomInfo)) {
                throw new RongCloudException('$chatRoomInfo参数有误');
            }

            $params = array();

            foreach($chatRoomInfo as $id => $name) {
                $params['chatroom[' . $id . ']'] = $name;
            }

            $ret = $this->curl('/chatroom/create', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * join [加入聊天室方法]
     *
     * @param string|array $userId     [要加入聊天室的用户 Id，可提交多个，最多不超过 50 个。（必传）]
     * @param string       $chatroomId [要加入的聊天室 Id。（必传）]
     *
     * @return int|mixed
     * @throws RongCloudException
     **/
    public function join($userId, $chatroomId) {
        try {
            if(empty($userId)) {
                throw new RongCloudException('要加入聊天室的用户 Id 不能为空');
            }
            if(is_array($userId) && count($userId) > 50) {
                throw new RongCloudException('要加入聊天室的用户最多不超过 50 个');
            }
            if(empty($chatroomId)) {
                throw new RongCloudException('要加入的聊天室 Id 不能为空');
            }

            $params = array(
                'userId'     => $userId,
                'chatroomId' => $chatroomId
            );

            $ret = $this->curl('/chatroom/join', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * query [查询聊天室信息方法]
     *
     * @param string $chatroomId [要查询的聊天室id（必传）]
     *
     * @return int|mixed
     * @throws RongCloudException
     **/
    public function query($chatroomId) {
        try {
            if(empty($chatroomId)) {
                throw new RongCloudException('要查询的聊天室 Id 不能为空');
            }

            $params = array(
                'chatroomId' => $chatroomId
            );

            $ret = $this->curl('/chatroom/query', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * queryUser [查询聊天室内用户方法]
     *
     * @param string $chatroomId [要查询的聊天室 ID。（必传）]
     * @param string $count      [要获取的聊天室成员数，上限为 500 ，超过 500 时最多返回 500 个成员。（必传）]
     * @param string $order      [加入聊天室的先后顺序， 1 为加入时间正序， 2 为加入时间倒序。（必传）]
     *
     * @return int|mixed
     * @throws RongCloudException
     **/
    public function queryUser($chatroomId, $count, $order) {
        try {
            if(empty($chatroomId)) {
                throw new RongCloudException('要查询的聊天室 Id 不能为空');
            }
            if(empty($count)) {
                throw new RongCloudException('要获取的聊天室成员数不能为空');
            }
            if(empty($order)) {
                throw new RongCloudException('加入聊天室的先后顺序不能为空');
            }

            $params = array(
                'chatroomId' => $chatroomId,
                'count'      => $count,
                'order'      => $order
            );

            $ret = $this->curl('/chatroom/user/query', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * existUser [查询用户是否在聊天室方法]
     *
     * @param string $chatroomId [要查询的聊天室 ID。（必传）]
     * @param string $userId     [要查询的用户 ID（必传）]
     *
     * @return int|mixed
     * @throws RongCloudException
     **/
    public function existUser($chatroomId, $userId) {
        try {
            if(empty($chatroomId)) {
                throw new RongCloudException('要查询的聊天室 Id 不能为空');
            }
            if(empty($userId)) {
                throw new RongCloudException('要查询的用户 Id 不能为空');
            }

            $params = array(
                'chatroomId' => $chatroomId,
                'userId'     => $userId,
            );

            $ret = $this->curl('/chatroom/user/exist', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * stopDistributionMessage [聊天室消息停止分发方法（可实现控制对聊天室中消息是否进行分发，停止分发后聊天室中用户发送的消息，融云服务端不会再将消息发送给聊天室中其他用户。）]
     *
     * @param string $chatroomId [聊天室 Id。（必传）]
     *
     * @return int|mixed
     * @throws RongCloudException
     **/
    public function stopDistributionMessage($chatroomId) {
        try {
            if(empty($chatroomId)) {
                throw new RongCloudException('聊天室 Id 不能为空');
            }

            $params = array(
                'chatroomId' => $chatroomId
            );

            $ret = $this->curl('/chatroom/message/stopDistribution', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * resumeDistributionMessage [聊天室消息恢复分发方法]
     *
     * @param string $chatroomId [聊天室 Id。（必传）]
     *
     * @return int|mixed
     * @throws RongCloudException
     **/
    public function resumeDistributionMessage($chatroomId) {
        try {
            if(empty($chatroomId)) {
                throw new RongCloudException('聊天室 Id 不能为空');
            }

            $params = array(
                'chatroomId' => $chatroomId
            );

            $ret = $this->curl('/chatroom/message/resumeDistribution', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * addGagUser [添加禁言聊天室成员方法（在 App 中如果不想让某一用户在聊天室中发言时，可将此用户在聊天室中禁言，被禁言用户可以接收查看聊天室中用户聊天信息，但不能发送消息.）]
     *
     * @param string $userId     [用户 Id。（必传）]
     * @param string $chatroomId [聊天室 Id。（必传）]
     * @param string $minute     [禁言时长，以分钟为单位，最大值为43200分钟。（必传）]
     *
     * @return int|mixed
     * @throws RongCloudException
     **/
    public function addGagUser($userId, $chatroomId, $minute) {
        try {
            if(empty($userId)) {
                throw new RongCloudException('用户 Id 不能为空');
            }
            if(empty($chatroomId)) {
                throw new RongCloudException('聊天室 Id 不能为空');
            }
            if(empty($minute)) {
                throw new RongCloudException('禁言时长不能为空');
            }

            $params = array(
                'userId'     => $userId,
                'chatroomId' => $chatroomId,
                'minute'     => $minute
            );

            $ret = $this->curl('/chatroom/user/gag/add', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * listGagUser [查询被禁言聊天室成员方法]
     *
     * @param string $chatroomId [聊天室 Id。（必传）]
     *
     * @return int|mixed
     * @throws RongCloudException
     **/
    public function listGagUser($chatroomId) {
        try {
            if(empty($chatroomId)) {
                throw new RongCloudException('聊天室 Id 不能为空');
            }

            $params = array(
                'chatroomId' => $chatroomId
            );

            $ret = $this->curl('/chatroom/user/gag/list', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * rollbackGagUser [移除禁言聊天室成员方法]
     *
     * @param string $userId     [用户 Id。（必传）]
     * @param string $chatroomId [聊天室Id。（必传）]
     *
     * @return int|mixed
     * @throws RongCloudException
     **/
    public function rollbackGagUser($userId, $chatroomId) {
        try {
            if(empty($userId)) {
                throw new RongCloudException('用户 Id 不能为空');
            }
            if(empty($chatroomId)) {
                throw new RongCloudException('聊天室 Id 不能为空');
            }

            $params = array(
                'userId'     => $userId,
                'chatroomId' => $chatroomId
            );

            $ret = $this->curl('/chatroom/user/gag/rollback', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * addBlockUser [添加封禁聊天室成员方法]
     *
     * @param string $userId     [用户 Id。（必传）]
     * @param string $chatroomId [聊天室 Id。（必传）]
     * @param string $minute     [封禁时长，以分钟为单位，最大值为43200分钟。（必传）]
     *
     * @return int|mixed
     * @throws RongCloudException
     **/
    public function addBlockUser($userId, $chatroomId, $minute) {
        try {
            if(empty($userId)) {
                throw new RongCloudException('用户 Id 不能为空');
            }
            if(empty($chatroomId)) {
                throw new RongCloudException('聊天室 Id 不能为空');
            }
            if(empty($minute)) {
                throw new RongCloudException('封禁时长不能为空');
            }

            $params = array(
                'userId'     => $userId,
                'chatroomId' => $chatroomId,
                'minute'     => $minute
            );

            $ret = $this->curl('/chatroom/user/block/add', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * getListBlockUser [查询被封禁聊天室成员方法]
     *
     * @param string $chatroomId [聊天室 Id。（必传）]
     *
     * @return int|mixed
     * @throws RongCloudException
     **/
    public function getListBlockUser($chatroomId) {
        try {
            if(empty($chatroomId)) {
                throw new RongCloudException('聊天室 Id 不能为空');
            }

            $params = array(
                'chatroomId' => $chatroomId
            );

            $ret = $this->curl('/chatroom/user/block/list', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * rollbackBlockUser [移除封禁聊天室成员方法]
     *
     * @param string $userId     [用户 Id。（必传）]
     * @param string $chatroomId [聊天室 Id。（必传）]
     *
     * @return int|mixed
     * @throws RongCloudException
     **/
    public function rollbackBlockUser($userId, $chatroomId) {
        try {
            if(empty($userId)) {
                throw new RongCloudException('用户 Id 不能为空');
            }
            if(empty($chatroomId)) {
                throw new RongCloudException('聊天室 Id 不能为空');
            }

            $params = array(
                'userId'     => $userId,
                'chatroomId' => $chatroomId
            );

            $ret = $this->curl('/chatroom/user/block/rollback', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * addPriority [添加聊天室消息优先级方法]
     *
     * @param string|array $objectName [低优先级的消息类型，每次最多提交 5 个，设置的消息类型最多不超过 20 个。（必传）]
     *
     * @return int|mixed
     * @throws RongCloudException
     **/
    public function addPriority($objectName) {
        try {
            if(empty($objectName)) {
                throw new RongCloudException('低优先级的消息类型不能为空');
            }

            if(is_array($objectName) && count($objectName) > 5) {
                throw new RongCloudException('低优先级的消息类型每次最多提交 5 个');
            }

            $params = array(
                'objectName' => $objectName
            );

            $ret = $this->curl('/chatroom/message/priority/add', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * removePriority [移除聊天室消息优先级方法]
     *
     * @param string|array $objectName [低优先级的消息类型，每次最多提交 5 个，设置的消息类型最多不超过 20 个。（必传）]
     *
     * @return int|mixed
     * @throws RongCloudException
     **/
    public function removePriority($objectName) {
        try {
            if(empty($objectName)) {
                throw new RongCloudException('低优先级的消息类型不能为空');
            }

            if(is_array($objectName) && count($objectName) > 5) {
                throw new RongCloudException('低优先级的消息类型每次最多提交 5 个');
            }

            $params = array(
                'objectName' => $objectName
            );

            $ret = $this->curl('/chatroom/message/priority/remove', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * destroy [销毁聊天室方法]
     *
     * @param string $chatroomId [要销毁的聊天室 Id。（必传）]
     *
     * @return int|mixed
     * @throws RongCloudException
     **/
    public function destroy($chatroomId) {
        try {
            if(empty($chatroomId)) {
                throw new RongCloudException('要销毁的聊天室 Id 不能为空');
            }

            $params = array(
                'chatroomId' => $chatroomId
            );

            $ret = $this->curl('/chatroom/destroy', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * addWhiteListUser [添加聊天室白名单成员方法]
     *
     * @param string       $chatroomId [聊天室 Id。（必传）]
     * @param string|array $userId     [聊天室中用户 Id，可提交多个，聊天室中白名单用户最多不超过 5 个。（必传）]
     *
     * @return int|mixed
     * @throws RongCloudException
     **/
    public function addWhiteListUser($chatroomId, $userId) {
        try {
            if(empty($chatroomId)) {
                throw new RongCloudException('聊天室 Id 不能为空');
            }
            if(empty($userId)) {
                throw new RongCloudException('聊天室中用户 Id 不能为空');
            }
            if(is_array($userId) && count($userId) > 5) {
                throw new RongCloudException('聊天室中用户 Id 最多不超过 5 个');
            }

            $params = array(
                'chatroomId' => $chatroomId,
                'userId'     => $userId
            );

            $ret = $this->curl('/chatroom/user/whitelist/add', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * removeWhiteListUser [移除聊天室白名单成员方法]
     *
     * @param string       $chatroomId [聊天室 Id。（必传）]
     * @param string|array $userId     [聊天室中用户 Id，可提交多个，聊天室中白名单用户最多不超过 5 个。（必传）]
     *
     * @return int|mixed
     * @throws RongCloudException
     **/
    public function removeWhiteListUser($chatroomId, $userId) {
        try {
            if(empty($chatroomId)) {
                throw new RongCloudException('聊天室 Id 不能为空');
            }
            if(empty($userId)) {
                throw new RongCloudException('聊天室中用户 Id 不能为空');
            }
            if(is_array($userId) && count($userId) > 5) {
                throw new RongCloudException('聊天室中用户 Id 最多不超过 5 个');
            }

            $params = array(
                'chatroomId' => $chatroomId,
                'userId'     => $userId
            );

            $ret = $this->curl('/chatroom/user/whitelist/remove', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

}
