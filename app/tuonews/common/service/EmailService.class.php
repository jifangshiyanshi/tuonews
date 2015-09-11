<?php

namespace common\service;

use common\service\interfaces\IEmailService;
use herosphp\bean\Beans;
use herosphp\cache\CacheFactory;
use herosphp\core\Loader;
use herosphp\utils\Smtp;

Loader::import('common.service.interfaces.IEmailService', IMPORT_APP);
/**
 * 邮件服务实现
 * Class EmailService
 * @package common\service
 */
class EmailService implements IEmailService {

    /**
     * 配置参数
     * @var array
     */
    private $config = array();

    /**
     * smtp对象
     * @var \herosphp\utils\Smtp
     */
    private  $smtp = null;

    // 构造方法
    public function __construct() {

        //初始化配置参数
        $configService = Beans::get('admin.config.service');
        $configs = $configService->getGroupConfigs('email');
        //初始化smtp对象
        $this->smtp = new Smtp($configs['smtp_host'], $configs['smtp_port'], $configs['smtp_user'], $configs['smtp_pass'], true, $configs['smtp_timeout']);
        $this->config = $configs;


    }

    /**
     * @see \common\service\interfaces\IEmailService::sendEmail
     */
    public function sendEmail($to, $subject, $content, $type='text', $cc = '')
    {
        return $this->smtp->Send_Mail($to, $this->config['smtp_user'], $subject, $content, $type, $cc);
    }

    /**
     * @see \common\service\interfaces\IEmailService::sendTemplateEmail
     */
    public function sendTemplateEmail($to, $templateKey, $params=null)
    {
        //获取模板内容
        $templateService = Beans::get('admin.messageTemplate.service');
        $template = $templateService->getItem("type='email' AND tkey='{$templateKey}'");

        if ( !$template ) {
            return false;
        }
        //获取当前登录用户
        $userService = Beans::get('user.user.service');
        $mediaService = Beans::get('media.media.service');
        $loginUser = $userService->getLoginUser();
        $loginMedia = $mediaService->getLoginMedia();

        $CACHER = CacheFactory::create('file');
        if ( !$loginUser ) {
            $key = 'register_'.$to;
            $loginUser = $CACHER->get($key, 0);
            //删除缓存
            //$CACHER->delete($key);
        }
        //替换标签
        $replacements = array(
            '{username}' => $loginUser['username'],
            '{userid}' => $loginUser['id'],
            '{site_url}' => getConfig('site_url'),
            '{mobile}' => $loginUser['mobile'],
            '{email}' => $loginUser['email'],
            '{nickname}' => $loginUser['nickname'],
            '{media_name}' => $loginMedia['name'],
            '{media_id}' => $loginMedia['id'],
        );
        $content = str_replace(array_keys($replacements), $replacements,$template['content']);

        //如果有传入自定义参数则惊醒自定义参数替换
        if ( is_array($params) ) {
            $content = str_replace(array_keys($params), $params, $content);
        }

        //发送校验码
        if ( strpos($content, '{authcode}') !== false ) {
            $authCode = mt_rand(100000, 999999);
            //缓存校验码
            $factor = getHashCode($to);
            $CACHER->baseKey('authcode')->ftype('email')->factor($factor);
            $CACHER->set(null, $authCode);

            $content = str_replace('{authcode}', $authCode, $content);
        }

        return $this->sendEmail($to, $template['name'], $content, 'html');
    }
}
