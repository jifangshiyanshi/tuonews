<?php

namespace common\service;

use herosphp\core\Loader;
use herosphp\http\HttpClient;

Loader::import('common.service.AbstractSmsService', IMPORT_APP);
/**
 * 维信互动平台商发送手机短信服务实现
 * Class MobileMessageService
 * @package common\service
 * @author yangjian102621@163.com
 */
class WeixinSmsService extends AbstractSmsService {

    /**
     * 网关
     * @var string
     */
    private static $gateway = null;

    /**
     * 用户账号
     * @var string
     */
    private static $user = '';

    /**
     * 用户密码
     * @var string
     */
    private static $password = '';

    public function __construct() {
        //获取配置，并初始化
        $configs = getConfig('weixin_message_config');
        self::$user = $configs['user'];
        self::$password = $configs['password'];
        self::$gateway = $configs['gateway'];
    }

    /**
     * 发送短信接口方法
     * @param string $mobiles
     * @param string $message
     * @param string $sendTime
     * @return boolean 成功返回ture,失败返回fasle
     * @see ISmsService::send()
     *
     */
    public function sendMessage($mobiles, $message, $sendTime='') {

        if(!$mobiles || !$message) {
            return false;
        }
        return $this->sendSms(self::$user, self::$password, $mobiles, $message, $sendTime);
    }

    /**
     * 发送短信操作
     * @param $user
     * @param $password
     * @param $mobiles
     * @param $message
     * @param $sign
     * @param $sendTime
     * @return bool
     */
    private function sendSms($user, $password, $mobiles, $message ) {

        $datas = array(
            'method' => 'Submit',
            // 用户账号
            'account' => $user,
            //密码
            'password' => $password,
            //手机号码
            'mobile' => $mobiles,
            //短信内容
            'content' => $message,
        );

        $httpClient = new HttpClient();
        $result = $httpClient->get(self::$gateway, $datas);
        //解析xml文档
        $xml = simplexml_load_string($result);
        $this->result = $xml->msg;
        //__print($xml);
        return ($xml->code == '2');

    }

    /**
     * 获取短信发送信息
     */
    public function getMessage() {
        return $this->result;
    }

}
