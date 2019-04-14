<?php

namespace RongCloud\Method;

use RongCloud\RongCloud;
use RongCloud\Exception\RongCloudException;

class Message extends RongCloud {

    public function __construct() {

    }

    /**
     * publishPrivate [发送单聊消息方法（一个用户向另外一个用户发送消息，单条消息最大 128k。每分钟最多发送 6000 条信息，每次发送用户上限为 1000 人，如：一次发送 1000 人时，示为 1000 条消息。）]
     *
     * @param string       $fromUserId      [发送人用户 Id。（必传）]
     * @param string|array $toUserId        [接收用户 Id，可以实现向多人发送消息，每次上限为 1000 人。（必传）]
     * @param string       $objectName      [消息类型，参考融云消息类型表：https://www.rongcloud.cn/docs/message_architecture.html；可自定义消息类型，长度不超过 32 个字符，您在自定义消息时需要注意，不要以 "RC:" 开头，以避免与融云系统内置消息的 ObjectName 重名。（必传）]
     * @param string       $content         [发送消息内容，参考融云消息类型表：https://www.rongcloud.cn/docs/message_architecture.html；如果 objectName 为自定义消息类型，该参数可自定义格式。（必传）]
     * @param string       $pushContent     [定义显示的 Push 内容，如果 objectName 为融云内置消息类型时，则发送后用户一定会收到 Push 信息。如果为自定义消息，则 pushContent 为自定义消息显示的 Push 内容，如果不传则用户不会收到 Push 通知。（可选）]
     * @param string       $pushData        [针对 iOS 平台为 Push 通知时附加到 payload 中，Android 客户端收到推送消息时对应字段名为 pushData。（可选）]
     * @param string       $count           [针对 iOS 平台，Push 时用来控制未读消息显示数，只有在 toUserId 为一个用户 Id 的时候有效。（可选）]
     * @param int          $verifyBlacklist [是否过滤发送人黑名单列表，0 表示为不过滤、 1 表示为过滤，默认为 0 不过滤。（可选）]
     * @param int          $isPersisted     [当前版本有新的自定义消息，而老版本没有该自定义消息时，老版本客户端收到消息后是否进行存储，0 表示为不存储、 1 表示为存储，默认为 1 存储消息。（可选）]
     * @param int          $isCounted       [当前版本有新的自定义消息，而老版本没有该自定义消息时，老版本客户端收到消息后是否进行未读消息计数，0 表示为不计数、 1 表示为计数，默认为 1 计数，未读消息数增加 1。（可选）]
     * @param int          $isIncludeSender [发送用户自已是否接收消息，0 表示为不接收，1 表示为接收，默认为 0 不接收。（可选）]
     *
     * @return int|mixed
     * @throws RongCloudException
     */
    public function publishPrivate($fromUserId, $toUserId, $objectName, $content, $pushContent = '', $pushData = '', $count = '', $verifyBlacklist = 0, $isPersisted = 1, $isCounted = 1, $isIncludeSender = 0) {
        try {
            if(empty($fromUserId)) {
                throw new RongCloudException('发送人用户 Id 不能为空');
            }
            if(empty($toUserId)) {
                throw new RongCloudException('接收用户 Id 不能为空');
            }
            if(is_array($toUserId) && count($toUserId) > 1000) {
                throw new RongCloudException('接收用户每次上限为 1000 人');
            }
            if(empty($objectName)) {
                throw new RongCloudException('消息类型不能为空');
            }

            if(empty($content)) {
                throw new RongCloudException('发送消息内容不能为空');
            }

            $params = array(
                'fromUserId'      => $fromUserId,
                'toUserId'        => $toUserId,
                'objectName'      => $objectName,
                'content'         => $content,
                'pushContent'     => $pushContent,
                'pushData'        => $pushData,
                'count'           => $count,
                'verifyBlacklist' => $verifyBlacklist,
                'isPersisted'     => $isPersisted,
                'isCounted'       => $isCounted,
                'isIncludeSender' => $isIncludeSender
            );

            $ret = $this->curl('/message/private/publish', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * publishTemplate [发送单聊模板消息方法（一个用户向多个用户发送不同消息内容，单条消息最大 128k。每分钟最多发送 6000 条信息，每次发送用户上限为 1000 人。）]
     *
     * @param $templateMessage [单聊模版消息]
     *
     * @return int|mixed
     * @throws RongCloudException
     */
    public function publishTemplate($templateMessage) {
        try {
            if(empty($templateMessage))
                throw new RongCloudException('Paramer "templateMessage" is required');


            $params = json_decode($templateMessage, true);

            $ret = $this->curl('/message/private/publish_template', $params, 'json', 'im', 'POST');
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * publishSystem [发送系统消息方法（一个用户向一个或多个用户发送系统消息，单条消息最大 128k，会话类型为 SYSTEM。每秒钟最多发送 100 条消息，每次最多同时向 100 人发送，如：一次发送 100 人时，示为 100 条消息。）]
     *
     * @param string       $fromUserId       [fromUserId:发送人用户 Id。（必传）]
     * @param string|array $toUserId         [接收用户 Id，提供多个本参数可以实现向多人发送消息，上限为 1000 人。（必传）]
     * @param string       $objectName       [消息类型，参考融云消息类型表：https://www.rongcloud.cn/docs/message_architecture.html；可自定义消息类型，长度不超过 32 个字符，您在自定义消息时需要注意，不要以 "RC:" 开头，以避免与融云系统内置消息的 ObjectName 重名。（必传）]
     * @param string       $content          [发送消息内容，参考融云消息类型表：https://www.rongcloud.cn/docs/message_architecture.html；如果 objectName 为自定义消息类型，该参数可自定义格式。（必传）]
     * @param string       $pushContent      [如果为自定义消息，定义显示的 Push 内容，内容中定义标识通过 values 中设置的标识位内容进行替换.如消息类型为自定义不需要 Push 通知，则对应数组传空值即可。（可选）]
     * @param string       $pushData         [针对 iOS 平台为 Push 通知时附加到 payload 中，Android 客户端收到推送消息时对应字段名为 pushData。如不需要 Push 功能对应数组传空值即可。（可选）]
     * @param int          $isPersisted      [当前版本有新的自定义消息，而老版本没有该自定义消息时，老版本客户端收到消息后是否进行存储，0 表示为不存储、 1 表示为存储，默认为 1 存储消息。（可选）]
     * @param int          $isCounted        [当前版本有新的自定义消息，而老版本没有该自定义消息时，老版本客户端收到消息后是否进行未读消息计数，0 表示为不计数、 1 表示为计数，默认为 1 计数，未读消息数增加 1。（可选）]
     * @param int          $contentAvailable [针对 iOS 平台，对 SDK 处于后台暂停状态时为静默推送，是 iOS7 之后推出的一种推送方式。 允许应用在收到通知后在后台运行一段代码，且能够马上执行，查看详细。1 表示为开启，0 表示为关闭，默认为 0（可选）]
     *
     * @return int|mixed
     * @throws RongCloudException
     */
    public function publishSystem($fromUserId, $toUserId, $objectName, $content, $pushContent = '', $pushData = '', $isPersisted = 1, $isCounted = 1, $contentAvailable = 0) {
        try {
            if(empty($fromUserId)) {
                throw new RongCloudException('发送人用户 Id 不能为空');
            }
            if(empty($toUserId)) {
                throw new RongCloudException('接收用户 Id 不能为空');
            }
            if(is_array($toUserId) && count($toUserId) > 1000) {
                throw new RongCloudException('接收用户上限为 1000 人');
            }
            if(empty($objectName)) {
                throw new RongCloudException('消息类型不能为空');
            }

            if(empty($content)) {
                throw new RongCloudException('发送消息内容不能为空');
            }

            $params = array(
                'fromUserId'       => $fromUserId,
                'toUserId'         => $toUserId,
                'objectName'       => $objectName,
                'content'          => $content,
                'pushContent'      => $pushContent,
                'pushData'         => $pushData,
                'isPersisted'      => $isPersisted,
                'isCounted'        => $isCounted,
                'contentAvailable' => $contentAvailable
            );

            $ret = $this->curl('/message/system/publish', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * 发送系统模板消息方法（一个用户向一个或多个用户发送系统消息，单条消息最大 128k，会话类型为 SYSTEM.每秒钟最多发送 100 条消息，每次最多同时向 100 人发送，如：一次发送 100 人时，示为 100 条消息。）
     *
     * @param  $templateMessage [系统模版消息]
     *
     * @return int|mixed
     * @throws RongCloudException
     **/
    public function publishSystemTemplate($templateMessage) {
        try {
            if(empty($templateMessage))
                throw new RongCloudException('Paramer "templateMessage" is required');


            $params = json_decode($templateMessage, true);

            $ret = $this->curl('/message/system/publish_template', $params, 'json', 'im', 'POST');
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * publishGroup [发送群组消息方法（以一个用户身份向群组发送消息，单条消息最大 128k.每秒钟最多发送 20 条消息，每次最多向 3 个群组发送，如：一次向 3 个群组发送消息，示为 3 条消息。）]
     *
     * @param string       $fromUserId       [发送人用户 Id 。（必传）]
     * @param string|array $toGroupId        [接收群Id，提供多个本参数可以实现向多群发送消息，最多不超过 3 个群组。（必传）]
     * @param string       $objectName       [消息类型，参考融云消息类型表：https://www.rongcloud.cn/docs/message_architecture.html；可自定义消息类型，长度不超过 32 个字符，您在自定义消息时需要注意，不要以 "RC:" 开头，以避免与融云系统内置消息的 ObjectName 重名。（必传）]
     * @param string       $content          [发送消息内容，参考融云消息类型表：https://www.rongcloud.cn/docs/message_architecture.html；如果 objectName 为自定义消息类型，该参数可自定义格式。（必传）]
     * @param string       $pushContent      [定义显示的 Push 内容，如果 objectName 为融云内置消息类型时，则发送后用户一定会收到 Push 信息. 如果为自定义消息，则 pushContent 为自定义消息显示的 Push 内容，如果不传则用户不会收到 Push 通知。（可选）]
     * @param string       $pushData         [针对 iOS 平台为 Push 通知时附加到 payload 中，Android 客户端收到推送消息时对应字段名为 pushData。（可选）]
     * @param int          $isPersisted      [当前版本有新的自定义消息，而老版本没有该自定义消息时，老版本客户端收到消息后是否进行存储，0 表示为不存储、 1 表示为存储，默认为 1 存储消息。（可选）]
     * @param int          $isCounted        [当前版本有新的自定义消息，而老版本没有该自定义消息时，老版本客户端收到消息后是否进行未读消息计数，0 表示为不计数、 1 表示为计数，默认为 1 计数，未读消息数增加 1。（可选）]
     * @param int          $isIncludeSender  [发送用户自已是否接收消息，0 表示为不接收，1 表示为接收，默认为 0 不接收。（可选）]
     * @param int          $isMentioned      [是否为 @消息，0 表示为普通消息，1 表示为 @消息，默认为 0。当为 1 时 content 参数中必须携带 mentionedInfo @消息的详细内容。为 0 时则不需要携带 mentionedInfo。当指定了 toUserId 时，则 @ 的用户必须为 toUserId 中的用户。（可选）]
     * @param int          $contentAvailable [针对 iOS 平台，对 SDK 处于后台暂停状态时为静默推送，是 iOS7 之后推出的一种推送方式。 允许应用在收到通知后在后台运行一段代码，且能够马上执行，查看详细。1 表示为开启，0 表示为关闭，默认为 0（可选）]
     *
     * @return int|mixed
     * @throws RongCloudException
     */
    public function publishGroup($fromUserId, $toGroupId, $objectName, $content, $pushContent = '', $pushData = '', $isPersisted = 1, $isCounted = 1, $isIncludeSender = 0, $isMentioned = 0, $contentAvailable = 0) {
        try {
            if(empty($fromUserId)) {
                throw new RongCloudException('发送人用户 Id 不能为空');
            }
            if(empty($toGroupId)) {
                throw new RongCloudException('接收群 Id 不能为空');
            }
            if(is_array($toGroupId) && count($toGroupId) > 3) {
                throw new RongCloudException('接收群最多不超过 3 个');
            }
            if(empty($objectName)) {
                throw new RongCloudException('消息类型不能为空');
            }

            if(empty($content)) {
                throw new RongCloudException('发送消息内容不能为空');
            }

            $params = array(
                'fromUserId'       => $fromUserId,
                'toGroupId'        => $toGroupId,
                'objectName'       => $objectName,
                'content'          => $content,
                'pushContent'      => $pushContent,
                'pushData'         => $pushData,
                'isPersisted'      => $isPersisted,
                'isCounted'        => $isCounted,
                'isIncludeSender'  => $isIncludeSender,
                'isMentioned'      => $isMentioned,
                'contentAvailable' => $contentAvailable
            );

            $ret = $this->curl('/message/group/publish', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * publishChatroom [发送聊天室消息方法（一个用户向聊天室发送消息，单条消息最大 128k。每秒钟限 100 次。）]
     *
     * @param string       $fromUserId   [发送人用户 Id。（必传）]
     * @param string|array $toChatroomId [接收聊天室Id，提供多个本参数可以实现向多个聊天室发送消息，建议最多不超过 10 个聊天室。（必传）]
     * @param string       $objectName   [消息类型，参考融云消息类型表：https://www.rongcloud.cn/docs/message_architecture.html；可自定义消息类型，长度不超过 32 个字符，您在自定义消息时需要注意，不要以 "RC:" 开头，以避免与融云系统内置消息的 ObjectName 重名。（必传）]
     * @param string       $content      [发送消息内容，参考融云消息类型表：https://www.rongcloud.cn/docs/message_architecture.html；如果 objectName 为自定义消息类型，该参数可自定义格式。（必传）]
     *
     * @return int|mixed
     * @throws RongCloudException
     */
    public function publishChatroom($fromUserId, $toChatroomId, $objectName, $content) {
        try {
            if(empty($fromUserId)) {
                throw new RongCloudException('发送人用户 Id 不能为空');
            }
            if(empty($toChatroomId)) {
                throw new RongCloudException('接收聊天室 Id 不能为空');
            }
            if(is_array($toChatroomId) && count($toChatroomId) > 10) {
                throw new RongCloudException('接收聊天室最多不超过 10 个');
            }
            if(empty($objectName)) {
                throw new RongCloudException('消息类型不能为空');
            }

            if(empty($content)) {
                throw new RongCloudException('发送消息内容不能为空');
            }

            $params = array(
                'fromUserId'   => $fromUserId,
                'toChatroomId' => $toChatroomId,
                'objectName'   => $objectName,
                'content'      => $content
            );

            $ret = $this->curl('/message/chatroom/publish', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * broadcast [发送广播消息方法（发送消息给一个应用下的所有注册用户，如用户未在线会对满足条件（绑定手机终端）的用户发送 Push 信息，单条消息最大 128k，会话类型为 SYSTEM。每小时只能发送 1 次，每天最多发送 3 次。）]
     *
     * @param string $fromUserId       [发送人用户 Id。（必传）]
     * @param string $objectName       [消息类型，参考融云消息类型表：https://www.rongcloud.cn/docs/message_architecture.html；可自定义消息类型，长度不超过 32 个字符，您在自定义消息时需要注意，不要以 "RC:" 开头，以避免与融云系统内置消息的 ObjectName 重名。（必传）]
     * @param string $content          [发送消息内容，参考融云消息类型表：https://www.rongcloud.cn/docs/message_architecture.html；如果 objectName 为自定义消息类型，该参数可自定义格式。（必传）]
     * @param string $pushContent      [定义显示的 Push 内容，如果 objectName 为融云内置消息类型时，则发送后用户一定会收到 Push 信息。 如果为自定义消息，则 pushContent 为自定义消息显示的 Push 内容，如果不传则用户不会收到 Push 通知。(可选)]
     * @param string $pushData         [针对 iOS 平台为 Push 通知时附加到 payload 中，客户端获取远程推送内容时为 appData 查看详细，Android 客户端收到推送消息时对应字段名为 pushData。(可选)]
     * @param string $os               [针对操作系统发送 Push，值为 iOS 表示对 iOS 手机用户发送 Push ,为 Android 时表示对 Android 手机用户发送 Push ，如对所有用户发送 Push 信息，则不需要传 os 参数。(可选)]
     * @param int    $contentAvailable [针对 iOS 平台，对 SDK 处于后台暂停状态时为静默推送，是 iOS7 之后推出的一种推送方式。 允许应用在收到通知后在后台运行一段代码，且能够马上执行，查看详细。1 表示为开启，0 表示为关闭，默认为 0（可选）]
     *
     * @return int|mixed
     * @throws RongCloudException
     */
    public function broadcast($fromUserId, $objectName, $content, $pushContent = '', $pushData = '', $os = '', $contentAvailable = 0) {
        try {
            if(empty($fromUserId)) {
                throw new RongCloudException('发送人用户 Id 不能为空');
            }

            if(empty($objectName)) {
                throw new RongCloudException('消息类型不能为空');
            }

            if(empty($content)) {
                throw new RongCloudException('发送消息内容不能为空');
            }

            $params = array(
                'fromUserId'       => $fromUserId,
                'objectName'       => $objectName,
                'content'          => $content,
                'pushContent'      => $pushContent,
                'pushData'         => $pushData,
                'os'               => $os,
                'contentAvailable' => $contentAvailable
            );

            $ret = $this->curl('/message/broadcast', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * getHistory [消息历史记录下载地址获取 方法消息历史记录下载地址获取方法。获取 APP 内指定某天某小时内的所有会话消息记录的下载地址。（目前支持二人会话、讨论组、群组、聊天室、客服、系统通知消息历史记录下载）]
     *
     * @param $date [指定北京时间某天某小时，格式为2014010101,表示：2014年1月1日凌晨1点。（必传）]
     *
     * @return int|mixed
     * @throws RongCloudException
     */
    public function getHistory($date) {
        try {
            if(empty($date)) {
                throw new RongCloudException('查询时间不能为空');
            }

            $params = array(
                'date' => $date
            );

            $ret = $this->curl('/message/history', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * deleteMessage [消息历史记录删除方法（删除 APP 内指定某天某小时内的所有会话消息记录。调用该接口返回成功后，date参数指定的某小时的消息记录文件将在随后的5-10分钟内被永久删除。）]
     *
     * @param $date [指定北京时间某天某小时，格式为2014010101,表示：2014年1月1日凌晨1点。（必传）]
     *
     * @return int|mixed
     * @throws RongCloudException
     */
    public function deleteMessage($date) {
        try {
            if(empty($date)) {
                throw new RongCloudException('时间不能为空');
            }

            $params = array(
                'date' => $date
            );

            $ret = $this->curl('/message/history/delete', $params, 'urlencoded', 'im', 'POST');
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * recallMessage [消息撤回服务（支持撤回单聊、群聊中用户发送的消息，如开通了单群聊消息云存储功能，则云存储中的消息数据也将被删除）]
     *
     * @param $fromUserId       [消息发送人用户 Id。（必传）]
     * @param $conversationType [会话类型，二人会话是 1 、群组会话是 3 。（必传）]
     * @param $targetId         [目标 Id，根据不同的 ConversationType，可能是用户 Id、群组 Id。（必传）]
     * @param $messageUID       [消息唯一标识，可通过服务端实时消息路由获取，对应名称为 msgUID。（必传）]
     * @param $sentTime         [消息发送时间，可通过服务端实时消息路由获取，对应名称为 msgTimestamp。（必传）]
     *
     * @return int|mixed
     * @throws RongCloudException
     * 2019/4/14 15:09
     */
    public function recallMessage($fromUserId, $conversationType, $targetId, $messageUID, $sentTime) {
        try {
            if(empty($fromUserId)) {
                throw new RongCloudException('消息发送人用户 Id 不能为空');
            }

            if(empty($conversationType)) {
                throw new RongCloudException('会话类型 不能为空');
            }

            if($conversationType !== 1 && $conversationType !== 3 && $conversationType !== 6) {
                throw new RongCloudException('会话类型 二人会话是 1 、群组会话是 3 ');
            }

            if(empty($targetId)) {
                throw new RongCloudException('目标 Id 不能为空');
            }

            if(empty($messageUID)) {
                throw new RongCloudException('消息唯一标识 不能为空');
            }

            if(empty($sentTime)) {
                throw new RongCloudException('消息发送时间 不能为空');
            }

            $params = [
                'fromUserId'       => $fromUserId,
                'conversationType' => $conversationType,
                'targetId'         => $targetId,
                'messageUID'       => $messageUID,
                'sentTime'         => $sentTime,
            ];

            $ret = $this->curl('/message/recall', $params, 'urlencoded', 'im', 'POST');
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }
}
