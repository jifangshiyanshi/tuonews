<?php

namespace common\service\interfaces;

/**
 * 邮件服务接口
 * Interface ICommonService
 * @package common\service\interfaces
 * @author yangjian102621@163.com
 */
interface IEmailService {

    /**
     * 发送普通邮件
     * @param string $to 收件人
     * @param string $subject 邮件主题
     * @param string $content 邮件内容
     * @param string $type 邮件类别 text => 普通文本邮件, html => html邮件
     * @param string $cc 抄送
     * @return mixed
     */
    public function sendEmail($to, $subject, $content, $type='text', $cc='');

    /**
     * 发送模板邮件
     * @param string $to 收件人
     * @param string $templateKey 邮件模板key
     * @param array $params 邮件模板中的自定义参数
     * @return mixed
     */
    public function sendTemplateEmail($to, $templateKey, $params=null);
}