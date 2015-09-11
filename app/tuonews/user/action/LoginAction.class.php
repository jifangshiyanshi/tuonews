<?php
namespace user\action;

use common\action\CommonAction;
use herosphp\cache\CacheFactory;
use herosphp\bean\Beans;
use herosphp\http\HttpRequest;
use herosphp\utils\AjaxResult;

/**
 * 用户登陆 Action
 * @author          yangjian<yangjian102621@163.com>
 */
class LoginAction extends CommonAction {

    /**
     * 允许登录错误次数
     * @var int
     */
    protected static $LOGIN_FAIL_TIME = 10;

    /**
     * 登陆
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {
        $userService = Beans::get('user.user.service');
        if($userService->getLoginUser()){
            $this->location('/user_ucenter_index');
        }
        
        //获取友情链接
        $friendLinkService = Beans::get('admin.friendlink.service');
        $friendLinks = $friendLinkService->getFootLinks(40);
        $this->assign('friendLinks', $friendLinks);
        
        //获取底部导航
        $artoneService = Beans::get('artone.artone.service');
        $footNavis = $artoneService->getFootNavis(6, 'site_bottom', 'sort_num ASC');
        $this->assign('footNavis', $footNavis); 
        
        $this->assign('title', '用户登录');
        $this->setView('login');
    }

    /**
     * 登陆验证
     * @param HttpRequest $request
     */
    public function signin( HttpRequest $request ) {

        $username = $request->getParameter('username', 'addslashes|trim');
        $password = $request->getParameter('password', 'addslashes|trim');

        $userService = Beans::get('user.user.service');
        $CACHER = CacheFactory::create('file');
        $cacheKey = 'user_loginTime_'.$username;
        $maxLoginTime = intval($CACHER->get($cacheKey, 0));

        if ( $maxLoginTime >= self::$LOGIN_FAIL_TIME ) {
            AjaxResult::ajaxResult('error', '您登录已经连续'.self::$LOGIN_FAIL_TIME.'次登录失败，帐号已被锁定，请联系管理员！');
        }
        $errorMsg = null;
        $login = $userService->login($username, $password, $errorMsg);
        if ( $login ) {
            //登录成功，清空登录失败的记录
            $CACHER->set($cacheKey, 0);

            if ( $login['ischeck'] == 2 ) {
                AjaxResult::ajaxResult('error', '您的帐号被封号，请联系管理员！');
            }
            if ( $login['mobile'] == '' && $login['email_check'] == 0 ) {
                AjaxResult::ajaxResult('not_active', $login['email']);
            }

            $userService->setLoginUser($login);
            AjaxResult::ajaxResult('ok', '登录成功！');
        } else {
            //登录失败，记录用户登录失败次数
            $CACHER->set($cacheKey, $maxLoginTime+1);
            if ( $maxLoginTime + 1 >= 10 ) {
                //登录错误10次锁定帐号
                $adminService = Beans::get('admin.admin.service');
                $adminService->sets('status', 0, array('username' => $username));
            }
            AjaxResult::ajaxResult('error', '登录失败，'.$errorMsg.'，您还有'.(self::$LOGIN_FAIL_TIME - $maxLoginTime-1).'次登录机会！');
        }

    }

    /**
     * 邀请管理员登录
     * @param HttpRequest $request
     */
    public function inviteCheck( HttpRequest $request ) {

        $username = $request->getParameter('username', 'trim');
        $password = $request->getParameter('password', 'trim');
        $authcode = $request->getParameter('authcode', 'trim');
        $email = $request->getParameter('email', 'trim');
        $mid = $request->getParameter('mid', 'intval');     //管理员ID

        $__authcode = getEmailCode($email);
        if ( $authcode != $__authcode ) {
            AjaxResult::ajaxResult('error', "验证失败，邀请码错误或者失效！");
        }
        $userService = Beans::get('user.user.service');
        $errorMsg = null;
        $login = $userService->login($username, $password, $errorMsg);
        if ( $login ) {

            if ( $login['ischeck'] == 2 ) {
                AjaxResult::ajaxResult('error', '您的帐号被封号，请联系管理员！');
            }
            $userService->setLoginUser($login);

            //更新管理员的授权状态
            $managerService = Beans::get('media.manager.service');
            $managerService->set('status', 1, $mid);
            AjaxResult::ajaxResult('ok', url('/user_ucenter_index'));
        } else {
            AjaxResult::ajaxResult('error', "验证失败，{$errorMsg}");
        }

    }


    /**
     * 登出操作
     * @param HttpRequest $request
     */
    public function logout( HttpRequest $request ) {

        $op = $request->getParameter('op', 'trim');
        if ( $op == 'logout' ) {
            $userService = Beans::get('user.user.service');
            $userService->logout();
            $this->location(url('/user_login_index'));
        } else {
            page404();
        }
    }

    /**
     * 第三方登陆
     * @param HttpRequest $request
     */
    public function other( HttpRequest $request ) {
        $this->setView('login_other');
    }

}
?>
