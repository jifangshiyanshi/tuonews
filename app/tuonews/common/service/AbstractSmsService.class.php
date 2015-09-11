<?php

namespace common\service;

use common\service\interfaces\ISmsService;
use herosphp\bean\Beans;
use herosphp\cache\CacheFactory;
use herosphp\core\Loader;

Loader::import('common.service.interfaces.ISmsService', IMPORT_APP);
/**
 * 发送手机短信服务抽象类
 * Class AbstractSmsService
 * @package common\service
 * @author yangjian102621@163.com
 */
abstract class AbstractSmsService implements ISmsService {

    /**
     * 短信发送结果
     * @var string
     */
    protected $result = '';

    /**
     * @see ISmsService::sendTemplateMessage()
     */
    public function sendTemplateMessage($mobiles, $tempKey, $sendTime='')
    {
        //获取模板内容
        $templateService = Beans::get('admin.messageTemplate.service');
        $template = $templateService->getItem("type='message' AND tkey='{$tempKey}'");

        if ( !$template ) {
            return false;
        }
        //获取当前登录用户
        $userService = Beans::get('user.user.service');
        $loginUser = $userService->getLoginUser();
        //替换标签
        $replacements = array(
            '{username}' => $loginUser['username'],
            '{mobile}' => $loginUser['mobile'],
            '{email}' => $loginUser['email'],
            '{nickname}' => $loginUser['nickname'],
        );
        $content = str_replace(array_keys($replacements), $replacements,$template['content']);
        //去除html标签
        $content = strip_tags($content);
        //发送校验码
        if ( strpos($content, '{authcode}') !== false ) {
            $authCode = mt_rand(100000, 999999);
            //缓存校验码
            $factor = $mobiles;
            if ( !is_numeric($mobiles) ) {
                $factor = getHashCode($mobiles);
            }
            $CACHER = CacheFactory::create('file');
            $CACHER->baseKey('authcode')->ftype('mobile')->factor($factor);
            $CACHER->set(null, $authCode);

            $content = str_replace('{authcode}', $authCode, $content);
        }

        return $this->sendMessage($mobiles, strip_tags($content), $sendTime);
    }

    /**
     * 获取短信发送信息
     */
    public function getMessage() {
        return $this->result;
    }

}
