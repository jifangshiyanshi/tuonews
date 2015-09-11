<?php

namespace common\service\interfaces;

/**
 * 发送手机短信服务接口
 * Interface IMobileMessageService
 * @package common\service\interfaces
 * @author yangjian102621@163.com
 */
interface ISmsService {

    /**
     * 发送普通短信
     * @param string $mobiles 手机号码，多个手机号码用,隔开
     * @param string $message 短信内容
     * @param $sendTime 发送时间
     * @return boolean
     */
    public function sendMessage($mobiles, $message, $sendTime=null);

    /**
     * 发送模板短信
     * @param $mobiles
     * @param $tempKey
     * @param null $sendTime
     * @return mixed
     */
    public function sendTemplateMessage($mobiles, $tempKey, $sendTime=null);
}
