<?php
namespace admin\action;

use herosphp\bean\Beans;
use herosphp\cache\CacheFactory;
use herosphp\core\Controller;
use herosphp\core\WebApplication;
use herosphp\http\HttpRequest;
use herosphp\session\Session;
use herosphp\utils\AjaxResult;

/**
 * 登陆 Action
 * @author          yangjian<yangjian102621@163.com>
 */
class LoginAction extends Controller {

    /**
     * 允许登录错误次数
     * @var int
     */
    protected static $LOGIN_FAIL_TIME = 10;

    /**
     * 首页方法
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {

        $adminService = Beans::get('admin.admin.service');
        //如果用户已经登录，则直接跳转到用户中心
        if ( $adminService->isLogin() ) {
            $this->location('/admin_index_index');
        }
        $this->setView('login');

    }

    /**
     * 登陆验证
     * @param HttpRequest $request
     */
    public function signin( HttpRequest $request ) {

        $username = $request->getParameter('username');
        $password = $request->getParameter('password');

        $adminService = Beans::get('admin.admin.service');
        $CACHER = CacheFactory::create('file');
        $cacheKey = 'admin_loginTime_'.$username;
        $maxLoginTime = intval($CACHER->get($cacheKey, 0));

//        if ( $maxLoginTime >= self::$LOGIN_FAIL_TIME ) {
//            AjaxResult::ajaxResult(1, '您登录已经连续'.self::$LOGIN_FAIL_TIME.'次登录失败，帐号已被锁定，请联系管理员！');
//        }
        $login = $adminService->login($username, $password);
        if ( $login ) {
            //登录成功，清空登录失败的记录
            $CACHER->set($cacheKey, 0);

            if ( $login['status'] == 0 ) {
                AjaxResult::ajaxResult(1, '您的帐号已经被锁定，请联系管理员！');
            }

            AjaxResult::ajaxResult(0, '登录成功！');
        } else {
            //登录失败，记录用户登录失败次数
            $CACHER->set($cacheKey, $maxLoginTime+1);
            if ( $maxLoginTime + 1 >= 10 ) {
                //登录错误10次锁定帐号
                $adminService->sets('status', 0, array('username' => $username));
            }
            AjaxResult::ajaxResult(1, '登录失败，您还有'.(self::$LOGIN_FAIL_TIME - $maxLoginTime-1).'次登录机会！');
        }

    }

    /**
     * 登出操作
     * @param HttpRequest $request
     */
    public function logout( HttpRequest $request ) {

        $op = $request->getParameter('op', 'trim');
        if ( $op == 'logout' ) {
            $adminService = Beans::get('admin.admin.service');
            $adminService->logout();
            $this->location(url('/admin_login_index'));
        } else {
            die('您要进行的操作不存在！');
        }
    }

}
?>
