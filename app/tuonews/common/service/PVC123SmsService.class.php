<?php

namespace common\service;

use herosphp\core\Loader;
use herosphp\http\HttpClient;

Loader::import('common.service.AbstractSmsService', IMPORT_APP);
/**
 * 环球接口发送手机短信服务实现
 * Class PVC123SmsService
 * @package common\service
 * @author yangjian102621@163.com
 */
class PVC123SmsService extends AbstractSmsService {

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

    /**
     * 通道分组
     * @var string
     */
    private static $group = '';

    /**
     * 短信签名
     * @var string
     */
    private static $sign = '';

    public function __construct() {
        //获取配置，并初始化
        $configs = getConfig('pvc123_message_config');
        self::$user = $configs['user'];
        self::$password = $configs['password'];
        self::$gateway = $configs['gateway'];
        self::$group = $configs['group'];
        self::$sign = $configs['sign'];
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
        return $this->sendSms(self::$user, self::$password, $mobiles, $message, self::$sign, $sendTime);
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
    private function sendSms($user, $password, $mobiles, $message, $sign, $sendTime ) {

        $datas = array(
            // 用户账号
            'name' => $user,
            //密码
            'pwd' => $password,
            //手机号码
            'mobile' => $mobiles,
            //短信内容
            'content' => $message,
            //签名
            'sign' => $sign,
            //必填参数。固定值 pt
            'type' => 'pt',
            'stime' => $sendTime // 定时发送
        );

        $httpClient = new HttpClient();
        $result = $httpClient->post(self::$gateway, $datas);
        $this->result = $result;
        return ($result[0] === '0');

    }

    /**
     * 获取短信发送信息
     */
    public function getMessage() {
        return $this->result;
    }

}
