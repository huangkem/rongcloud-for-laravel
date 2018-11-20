<?php

namespace RongCloud\Method;

use RongCloud\RongCloud;
use RongCloud\Exception\RongCloudException;

class WordFilter extends RongCloud {

    public function __construct() {

    }

    /**
     * add [添加敏感词方法（设置敏感词后，App 中用户不会收到含有敏感词的消息内容，默认最多设置 50 个敏感词。）]
     *
     * @param string $word        [敏感词，最长不超过 32 个字符。（必传）]
     * @param string $replaceWord [需要替换的敏感词，最长不超过 32 个字符，（非必传）。如未设置替换的敏感词，当消息中含有敏感词时，消息将被屏蔽，用户不会收到消息。如设置了替换敏感词，当消息中含有敏感词时，将被替换为指定的字符进行发送。敏感词替换目前只支持单聊、群聊、聊天室会话。]
     *
     * @return int|mixed
     * @throws RongCloudException
     */
    public function add($word, $replaceWord = '') {
        try {
            if(empty($word)) {
                throw new RongCloudException('敏感词不能为空');
            }

            $params = array(
                'word'        => $word,
                'replaceWord' => $replaceWord
            );

            $ret = $this->curl('/wordfilter/add', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * getList [查询敏感词列表方法]
     *
     * @return int|mixed
     * @throws RongCloudException
     **/
    public function getList() {
        try {

            $params = array();

            $ret = $this->curl('/wordfilter/list', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * delete [移除敏感词方法（从敏感词列表中，移除某一敏感词。）]
     *
     * @param string $word [敏感词，最长不超过 32 个字符。（必传）]
     *
     * @return int|mixed
     * @throws RongCloudException
     **/
    public function delete($word) {
        try {
            if(empty($word)) {
                throw new RongCloudException('敏感词不能为空');
            }

            $params = array(
                'word' => $word
            );

            $ret = $this->curl('/wordfilter/delete', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }

    /**
     * batchDelete [批量移除敏感词方法（从敏感词列表中，移除多个敏感词。）]
     *
     * @param array $words [敏感词数组，一次最多移除 50 个敏感词。（必传）]
     *
     * @return int|mixed
     * @throws RongCloudException
     **/
    public function batchDelete($words) {
        try {
            if(empty($words)) {
                throw new RongCloudException('敏感词不能为空');
            }

            if(!is_array($words)) {
                throw new RongCloudException('敏感词必须数组');
            }

            if(is_array($words) && count($words) > 50) {
                throw new RongCloudException('敏感词数量不能大于50个');
            }

            $params = array(
                'words' => $words
            );

            $ret = $this->curl('/sensitiveword/batch/delete', $params);
            if(empty($ret)) {
                throw new RongCloudException('请求失败');
            }
            return $ret;

        }catch(RongCloudException $e) {
            throw new RongCloudException($e->getMessage());
        }
    }
}
