<?php
namespace user\action;

use common\action\CommonAction;
use herosphp\bean\Beans;
use herosphp\http\HttpRequest;
use herosphp\utils\AjaxResult;

/**
 * 找回密码登陆 Action
 * @author          yangjian<yangjian102621@163.com>
 */
class ResetPassAction extends CommonAction {

    /**
     * 找回密码首页
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {
        $this->setView('password_reset_select');
    }

    /**
     * 找回密码输入邀请码页面
     * @param HttpRequest $request
     */
    public function reset( HttpRequest $request ) {

        $username = $request->getParameter('username', 'trim');
        $type = $request->getParameter('type');
        //获取用户信息
        $userService = Beans::get('user.user.service');
        $user = $userService->getItem(array('username' => $username));
        if ( !$user ) page404();

        $this->assign('user', $user);
        $this->assign('type', $type);
        $this->setView('password_reset');
    }

    /**
     * 检测用户名是否存在
     * @param HttpRequest $request
     */
    public function checkUser(HttpRequest $request) {

        $username = $request->getParameter('username', 'trim');
        if ( $username == '' ) {
            AjaxResult::ajaxResult('error', '请输入用户名');
        }
        $userService = Beans::get('user.user.service');
        if ( $userService->checkField('username', $username) ) {
            AjaxResult::ajaxSuccessResult();
        } else {
            AjaxResult::ajaxResult('error', '用户名不存在');
        }
    }

    /**
     * 重置密码验证
     * 包括邮件重置密码和短信重置密码都在这里统一验证
     * @param HttpRequest $request
     */
    public function password(HttpRequest $request) {

        $email = $request->getParameter('email', 'trim');
        $authcode = $request->getParameter('authcode', 'trim');
        $mobile = $request->getParameter('mobile', 'trim');
        $password = $request->getParameter('password', 'trim');
        $repass = $request->getParameter('repass', 'trim');
        $userid = $request->getParameter('userid', 'intval');

        if ( $email != '' ) {
            $__authcode = getEmailCode($email, 7200);
        } else if( $mobile != '' ) {
            $__authcode = getMobileCode($mobile, 600);
        }

        if ( $__authcode != $authcode ) {
            AjaxResult::ajaxResult('error', '授权码错误');
        }
        if ( $password != $repass ) {
            AjaxResult::ajaxResult('error', '两次输入密码不一致');
        }
        $userService = Beans::get('user.user.service');
        if ( $userService->set('password', md5(md5($password)), $userid) ) {
            AjaxResult::ajaxSuccessResult();
        } else {
            AjaxResult::ajaxFailtureResult();
        }

    }

    /**
     * 重置密码成功
     * @param HttpRequest $request
     */
    public function finish(HttpRequest $request) {

        $this->setView('password_reset_finish');
    }

}
?>
