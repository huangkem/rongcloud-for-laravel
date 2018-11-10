<?php

namespace RongCloud\Method;

use RongCloud\RongCloud;
use RongCloud\Exception\RongCloudException;

class User extends RongCloud {

    public function __construct() {

    }

    /**
     * getToken [获取 Token 方法]
     *
     * @param string $userId      [用户 Id，最大长度 64 字节.是用户在 App 中的唯一标识码，必须保证在同一个 App 内不重复，重复的用户 Id 将被当作是同一用户。（必传）]
     * @param string $name        [用户名称，最大长度 128 字节.用来在 Push 推送时显示用户的名称.用户名称，最大长度 128 字节.用来在 Push 推送时显示用户的名称。（必传）]
     * @param string $portraitUri [用户头像 URI，最大长度 1024 字节.用来在 Push 推送时显示用户的头像。（必传）]
     *
     * @return int|mixed
     * @throws RongCloudException
     */
    public function getToken($userId, $name, $portraitUri) {
        try {
            if(empty($userId)) {
                throw new RongCloudException('用户 Id 不能为空');
            }
            if(empty($name)) {
                throw new RongCloudException('用户名称不能为空');
            }
            if(empty($portraitUri)) {
                throw new RongCloudException('用户头像不能为空');
            }

            $params = array(
                'userId'      => $userId,
                'name'        => $name,
                'portraitUri' => $portraitUri
            );

            $ret = $this->curl('/user/getToken', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * refresh [刷新用户信息方法]
     *
     * @param string $userId      [用户 Id，最大长度 64 字节.是用户在 App 中的唯一标识码，必须保证在同一个 App 内不重复，重复的用户 Id 将被当作是同一用户。（必传）]
     * @param string $name        [用户名称，最大长度 128 字节。用来在 Push 推送时，显示用户的名称，刷新用户名称后 5 分钟内生效。（可选，提供即刷新，不提供忽略）]
     * @param string $portraitUri [用户头像 URI，最大长度 1024 字节。用来在 Push 推送时显示。（可选，提供即刷新，不提供忽略）]
     *
     * @return int|mixed
     * @throws RongCloudException
     */
    public function refresh($userId, $name = '', $portraitUri = '') {
        try {
            if(empty($userId)) {
                throw new RongCloudException('用户 Id 不能为空');
            }

            $params = array(
                'userId'      => $userId,
                'name'        => $name,
                'portraitUri' => $portraitUri
            );

            $ret = $this->curl('/user/refresh', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * checkOnline [检查用户在线状态]
     *
     * @param string $userId [用户 Id，最大长度 64 字节。是用户在 App 中的唯一标识码，必须保证在同一个 App 内不重复，重复的用户 Id 将被当作是同一用户。（必传）]
     *
     * @return int|mixed
     * @throws RongCloudException
     */
    public function checkOnline($userId) {
        try {
            if(empty($userId)) {
                throw new RongCloudException('用户 Id 不能为空');
            }

            $params = array(
                'userId' => $userId
            );

            $ret = $this->curl('/user/checkOnline', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * block [封禁用户方法（每秒钟限 100 次）]
     *
     * @param string $userId [用户 Id。（必传）]
     * @param int    $minute [封禁时长,单位为分钟，最大值为43200分钟。（必传）]
     *
     * @return int|mixed
     * @throws RongCloudException
     */
    public function block($userId, $minute) {
        try {
            if(empty($userId)) {
                throw new RongCloudException('用户 Id 不能为空');
            }

            if(empty($minute)) {
                throw new RongCloudException('封禁时长不能为空');
            }

            $params = array(
                'userId' => $userId,
                'minute' => $minute
            );

            $ret = $this->curl('/user/block', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * unBlock [解除用户封禁方法（每秒钟限 100 次）]
     *
     * @param string $userId [用户 Id。（必传）]
     *
     * @return int|mixed
     * @throws RongCloudException
     */
    public function unBlock($userId) {
        try {
            if(empty($userId)) {
                throw new RongCloudException('用户 Id 不能为空');
            }

            $params = array(
                'userId' => $userId
            );

            $ret = $this->curl('/user/unblock', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * queryBlock[获取被封禁用户方法（每秒钟限 100 次）]
     *
     * @return int|mixed
     * @throws RongCloudException
     **/
    public function queryBlock() {
        try {

            $params = array();

            $ret = $this->curl('/user/block/query', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * addBlacklist [添加用户到黑名单方法（每秒钟限 100 次）]
     *
     * @param string $userId      [用户 Id。（必传）]
     * @param string $blackUserId [被加到黑名单的用户Id。（必传）]
     *
     * @return int|mixed
     * @throws RongCloudException
     */
    public function addBlacklist($userId, $blackUserId) {
        try {
            if(empty($userId)) {
                throw new RongCloudException('用户 Id 不能为空');
            }

            if(empty($blackUserId)) {
                throw new RongCloudException('被加黑的用户 Id 不能为空');
            }

            $params = array(
                'userId'      => $userId,
                'blackUserId' => $blackUserId
            );

            $ret = $this->curl('/user/blacklist/add', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * queryBlacklist [获取某用户的黑名单列表方法（每秒钟限 100 次）]
     *
     * @param string $userId [用户 Id。（必传）]
     *
     * @return int|mixed
     * @throws RongCloudException
     */
    public function queryBlacklist($userId) {
        try {
            if(empty($userId)) {
                throw new RongCloudException('用户 Id 不能为空');
            }

            $params = array(
                'userId' => $userId
            );

            $ret = $this->curl('/user/blacklist/query', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * removeBlacklist [从黑名单中移除用户方法（每秒钟限 100 次）]
     *
     * @param string $userId      [用户 Id。（必传）]
     * @param string $blackUserId [被加到黑名单的用户Id。（必传）]
     *
     * @return int|mixed
     * @throws RongCloudException
     */
    public function removeBlacklist($userId, $blackUserId) {
        try {
            if(empty($userId)) {
                throw new RongCloudException('用户 Id 不能为空');
            }
            if(empty($blackUserId)) {
                throw new RongCloudException('被加黑的用户 Id 不能为空');
            }

            $params = array(
                'userId'      => $userId,
                'blackUserId' => $blackUserId
            );

            $ret = $this->curl('/user/blacklist/remove', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * userInfo[检测用户信息]
     *
     * @param string $userId [用户 Id。（必传）]
     *
     * @return int|mixed
     * @throws RongCloudException
     **/

    public function userInfo($userId) {
        try {
            if(empty($userId)) {
                throw new RongCloudException('用户 Id 不能为空');
            }
            $params = array(
                'userId' => $userId,
            );

            $ret = $this->curl('/user/info', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

}
