<?php
namespace admin\service;

use admin\service\interfaces\IAdminService;
use common\service\CommonService;
use herosphp\bean\Beans;
use herosphp\core\Loader;
use herosphp\session\Session;
use herosphp\utils\WebUtils;

Loader::import('admin.service.interfaces.IAdminService', IMPORT_APP);
Loader::import('common.service.CommonService', IMPORT_APP);

/**
 * admin服务接口实现
 * Class AdminService
 * @package admin\service
 */
class AdminService extends CommonService implements IAdminService {


    /**
     * @see \admin\service\interfaces\IAdminService::login()
     */
    public function login($username, $password) {

        $conditions = array(
            'username' => $username,
            'password' => md5(md5($password))
        );

        $item = $this->getItem($conditions);
        if ( !$item ) {
            return false;
        } else {

            //更新登录信息
            $data['last_login_time'] = time();
            $data['last_login_ip'] = WebUtils::getClientIP();
            $this->update($data, $item['id']);

            //记录session信息
            Session::start();
            $_SESSION[IAdminService::ADMIN_SESSION_USER] = $item;

            $this->updateUserPermission($item);
            return $item;
        }
    }

    public function updateUserPermission($user) {

        //获取管理员权限
        $roleService = Beans::get('admin.role.service');
        $permissions = $roleService->getItem($user['role_id']);
        $_SESSION[IAdminService::ADMIN_SESSION_PERMISSION] = cn_json_decode($permissions['permissions']);

    }

    /**
     * @see \admin\service\interfaces\IAdminService::logout()
     */
    public function logout() {

        Session::start();
        $_SESSION[IAdminService::ADMIN_SESSION_USER] = null;
        $_SESSION[IAdminService::ADMIN_SESSION_PERMISSION] = null;
        unset($_SESSION[IAdminService::ADMIN_SESSION_USER]);
        unset($_SESSION[IAdminService::ADMIN_SESSION_PERMISSION]);
        session_destroy();
    }

    /**
     * @see \admin\service\interfaces\IAdminService::getLoginUser()
     */
    public function getLoginUser() {

        Session::start();
        return $_SESSION[IAdminService::ADMIN_SESSION_USER];
    }

    /**
     * @see \admin\service\interfaces\IAdminService::isLogin()
     */
    public function isLogin() {

        Session::start();
        return isset($_SESSION[IAdminService::ADMIN_SESSION_USER]);

    }

    //获取当前登录管理员权限
    public function getPermissions() {

        Session::start();
        return $_SESSION[IAdminService::ADMIN_SESSION_PERMISSION];

    }

    /**
     * @see \admin\service\interfaces\IAdminService::hasPermission()
     */
    public function hasPermission($opt, &$permissions) {

        $user = $this->getLoginUser();
        if ( $this->isSuperManager($user) ) {
            return true;
        }
        $__opt = explode('@', $opt);
        //加载权限选项
        $permissionOptions = Loader::config('admin', 'permission');
        if ( !isset($permissionOptions[$__opt[0]]['methods'][$__opt[1]]) ) {
            //不需要进行权限验证
            return true;
        } else {

            return ($permissions[$opt] == 1);

        }

    }

    /**
     * @see \admin\service\interfaces\IAdminService::isSuperManager()
     */
    public function isSuperManager($user) {

        //获取系统配置
        $configService = Beans::get('admin.config.service');
        $superIds = $configService->getVarValue('basic', 'super_manager_ids');
        $superIds = explode(',', $superIds);
        return in_array($user['id'], $superIds);

    }

}
