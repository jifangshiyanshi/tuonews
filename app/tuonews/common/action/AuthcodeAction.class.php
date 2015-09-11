<?php
namespace common\action;

use herosphp\bean\Beans;
use herosphp\http\HttpRequest;
use herosphp\utils\AjaxResult;

/**
 * 发送授权码 Action
 * @author          yangjian<yangjian102621@163.com>
 */
class AuthcodeAction extends CommonAction {

    /**
     * 发送短信验证码
     * @param HttpRequest $request
     */
    public function sendMobileCode(HttpRequest $request) {

        //接收手机号码参数
        $mobile = $request->getParameter('mobile', 'trim');
        //接收短信模板参数
        $template = $request->getParameter('template', 'trim');
        //验证手机是否已经绑定
        if(!empty($this->loginUser["mobile"]) && !empty($this->loginUser["mobile_check"])){
            if($mobile == $this->loginUser["mobile"]){
                AjaxResult::ajaxResult("error","此手机号".$mobile."已绑定,请更换手机号");
            }
        }

        $service = Beans::get('common.mobileMessage.service');
        $result = $service->sendTemplateMessage($mobile, $template);
        if ( $result ) {
            AjaxResult::ajaxResult('ok', '短信发送成功,请于30分钟之内输入验证！');
        } else {
            AjaxResult::ajaxResult('error', '短信发送失败！');
        }
    }

    /**
     * 发送邮件验证码
     * @param HttpRequest $request
     */
    public function sendEmailCode(HttpRequest $request) {

        //接收邮箱地址
        $email = $request->getParameter('email', 'urldecode|trim');
        //接收模板参数
        $template = $request->getParameter('template', 'trim');
        //获取模板参数
        $params = array();
        foreach ( $request->getParameters() as $key => $value ) {

            if ( strpos($key, '_') !== 0 ) continue;
            //组合模板标签
            $key = '{'.ltrim($key, '_').'}';
            $params[$key] = urldecode($value);

        }

        $service = Beans::get('common.email.service');
        $result = $service->sendTemplateEmail($email, $template, $params);
        if ( $result ) {
            AjaxResult::ajaxResult('ok', '邮件发送成功,请尽快登录邮箱验证！');
        } else {
            AjaxResult::ajaxResult('error', '邮件发送失败！');
        }

    }
}
?>
