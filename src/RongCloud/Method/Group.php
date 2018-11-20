<?php

namespace RongCloud\Method;

use RongCloud\RongCloud;
use RongCloud\Exception\RongCloudException;

class Group extends RongCloud {

    public function __construct() {

    }

    /**
     * create [创建群组方法（创建群组，并将用户加入该群组，用户将可以收到该群的消息，同一用户最多可加入 500 个群，每个群最大至 3000 人，App 内的群组数量没有限制.注：其实本方法是加入群组方法 /group/join 的别名。）]
     *
     * @param  string $userId    [要加入群的用户 Id。（必传）]
     * @param  string $groupId   [创建群组 Id。（必传）]
     * @param  string $groupName [群组 Id 对应的名称。（必传）]
     *
     * @return int|mixed
     * @throws RongCloudException
     **/
    public function create($userId, $groupId, $groupName) {
        try {
            if(empty($userId)) {
                throw new RongCloudException('要加入群的用户 Id 不能为空');
            }
            if(empty($groupId)) {
                throw new RongCloudException('创建群组 Id 不能为空');
            }
            if(empty($groupName)) {
                throw new RongCloudException('群组 Id 对应的名称不能为空');
            }

            $params = array(
                'userId'    => $userId,
                'groupId'   => $groupId,
                'groupName' => $groupName
            );

            $ret = $this->curl('/group/create', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * sync [同步用户所属群组方法（当第一次连接融云服务器时，需要向融云服务器提交 userId 对应的用户当前所加入的所有群组，此接口主要为防止应用中用户群信息同融云已知的用户所属群信息不同步。）]
     *
     * @param string $userId    [被同步群信息的用户 Id。（必传）]
     * @param array  $groupInfo [该用户的群信息，如群 Id 已经存在，则不会刷新对应群组名称，如果想刷新群组名称请调用刷新群组信息方法。]
     *
     * @return int|mixed
     * @throws RongCloudException
     **/
    public function sync($userId, $groupInfo) {
        try {
            if(empty($userId)) {
                throw new RongCloudException('被同步群信息的用户 Id 不能为空');
            }
            if(empty($groupInfo) || !is_array($groupInfo)) {
                throw new RongCloudException('该用户的群信息参数有误');
            }

            $params = array();
            $params['userId'] = $userId;

            foreach($groupInfo as $key => $value) {
                $params['group[' . $key . ']'] = $value;
            }

            $ret = $this->curl('/group/sync', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * refresh [刷新群组信息方法]
     *
     * @param string $groupId   [群组 Id。（必传）]
     * @param string $groupName [群名称。（必传）]
     *
     * @return int|mixed
     * @throws RongCloudException
     **/
    public function refresh($groupId, $groupName) {
        try {
            if(empty($groupId)) {
                throw new RongCloudException('群组 Id 不能为空');
            }
            if(empty($groupName)) {
                throw new RongCloudException('群名称不能为空');
            }

            $params = array(
                'groupId'   => $groupId,
                'groupName' => $groupName
            );

            $ret = $this->curl('/group/refresh', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * join [将用户加入指定群组，用户将可以收到该群的消息，同一用户最多可加入 500 个群，每个群最大至 3000 人。]
     *
     * @param string|array $userId    [要加入群的用户 Id，可提交多个，最多不超过 1000 个。（必传）]
     * @param string       $groupId   [要加入的群 Id。（必传）]
     * @param string       $groupName [要加入的群 Id 对应的名称。（必传）]
     *
     * @return int|mixed
     * @throws RongCloudException
     **/
    public function join($userId, $groupId, $groupName) {
        try {
            if(empty($userId)) {
                throw new RongCloudException('要加入群的用户 Id 不能为空');
            }
            if(is_array($userId) && count($userId) > 1000) {
                throw new RongCloudException('要加入群的用户最多不超过 1000 个');
            }
            if(empty($groupId)) {
                throw new RongCloudException('群组 Id 不能为空');
            }
            if(empty($groupName)) {
                throw new RongCloudException('群名称不能为空');
            }

            $params = array(
                'userId'    => $userId,
                'groupId'   => $groupId,
                'groupName' => $groupName
            );

            $ret = $this->curl('/group/join', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * queryUser [查询群成员方法]
     *
     * @param string $groupId [群组Id。（必传）]
     *
     * @return int|mixed
     * @throws RongCloudException
     **/
    public function queryUser($groupId) {
        try {
            if(empty($groupId)) {
                throw new RongCloudException('群组 Id 不能为空');
            }

            $params = array(
                'groupId' => $groupId
            );

            $ret = $this->curl('/group/user/query', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * quit [退出群组方法（将用户从群中移除，不再接收该群组的消息.）]
     *
     * @param string $userId  [要退出群的用户 Id.（必传）]
     * @param string $groupId [要退出的群 Id.（必传）]
     *
     * @return int|mixed
     * @throws RongCloudException
     **/
    public function quit($userId, $groupId) {
        try {
            if(empty($userId)) {
                throw new RongCloudException('要退出群的用户 Id 不能为空');
            }
            if(empty($groupId)) {
                throw new RongCloudException('要退出的群 Id 不能为空');
            }

            $params = array(
                'userId'  => $userId,
                'groupId' => $groupId
            );

            $ret = $this->curl('/group/quit', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * addGagUser [添加禁言群成员方法（在 App 中如果不想让某一用户在群中发言时，可将此用户在群组中禁言，被禁言用户可以接收查看群组中用户聊天信息，但不能发送消息。）]
     *
     * @param  string|array $userId  [用户 Id，支持群组中多个用户禁言，每次最多设置 20 个用户（必传）]
     * @param  string       $groupId [群组 Id。（必传）]
     * @param  string       $minute  [禁言时长，以分钟为单位，最大值为43200分钟。（必传）]
     *
     * @return int|mixed
     * @throws RongCloudException
     **/
    public function addGagUser($userId, $groupId, $minute) {
        try {
            if(empty($userId)) {
                throw new RongCloudException('用户 Id 不能为空');
            }
            if(is_array($userId) && count($userId) > 20) {
                throw new RongCloudException('每次最多设置 20 个用户');
            }
            if(empty($groupId)) {
                throw new RongCloudException('群组 Id 不能为空');
            }
            if(empty($minute)) {
                throw new RongCloudException('禁言时长不能为空');
            }

            $params = array(
                'userId'  => $userId,
                'groupId' => $groupId,
                'minute'  => $minute
            );

            $ret = $this->curl('/group/user/gag/add', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * lisGagUser [查询被禁言群成员方法]
     *
     * @param string $groupId [群组Id。（必传）]
     *
     * @return int|mixed
     * @throws RongCloudException
     **/
    public function lisGagUser($groupId) {
        try {
            if(empty($groupId)) {
                throw new RongCloudException('群组 Id 不能为空');
            }

            $params = array(
                'groupId' => $groupId
            );

            $ret = $this->curl('/group/user/gag/list', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * rollBackGagUser [移除禁言群成员方法]
     *
     * @param string|array $userId  [用户Id。支持同时移除多个群成员，每次最多解禁 20 个用户（必传）]
     * @param string       $groupId [群组Id。（必传）]
     *
     * @return int|mixed
     * @throws RongCloudException
     **/
    public function rollBackGagUser($userId, $groupId) {
        try {
            if(empty($userId)) {
                throw new RongCloudException('用户 Id 不能为空');
            }
            if(is_array($userId) && count($userId) > 20) {
                throw new RongCloudException('每次最多解禁 20 个用户');
            }
            if(empty($groupId)) {
                throw new RongCloudException('群组 Id 不能为空');
            }

            $params = array(
                'userId'  => $userId,
                'groupId' => $groupId
            );

            $ret = $this->curl('/group/user/gag/rollback', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * dismiss [解散群组方法。（将该群解散，所有用户都无法再接收该群的消息。）]
     *
     * @param string $userId  [操作解散群的用户 Id。（必传）]
     * @param string $groupId [要解散的群 Id。（必传）]
     *
     * @return int|mixed
     * @throws RongCloudException
     **/
    public function dismiss($userId, $groupId) {
        try {
            if(empty($userId))
                throw new RongCloudException('操作解散群的用户 Id 不能为空');

            if(empty($groupId))
                throw new RongCloudException('要解散的群 Id 不能为空');


            $params = array(
                'userId'  => $userId,
                'groupId' => $groupId
            );

            $ret = $this->curl('/group/dismiss', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

}
