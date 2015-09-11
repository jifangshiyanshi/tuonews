<?php

namespace admin\service\interfaces;
use common\service\interfaces\ICommonService;
use herosphp\core\Loader;

Loader::import('common.service.interfaces.ICommonService', IMPORT_APP);

/**
 * admin服务接口
 * Interface IAdminService
 */
interface IAdminService extends ICommonService {

    /**
     * 后台登录session user key
     */
    const ADMIN_SESSION_USER = 'admin_session_user';

    /**
     * 后台登录用户权限key
     */
    const ADMIN_SESSION_PERMISSION = 'admin_session_permission';

    /**
     * 是否超级管理员
     */
    const ADMIN_SUPPER_MANAGER = 'admin_super_manager';

    /**
     * 登录服务
     * @param $username
     * @param $password
     * @return boolean
     */
    public function login($username, $password);

    /**
     * 安全退出
     * @return boolean
     */
    public function logout();

    /**
     * 获取当前登陆管理员
     * @return array
     */
    public function getLoginUser();

    /**
     * 更新用户权限
     * @param $user
     * @return mixed
     */
    public function updateUserPermission($user);

    /**
     * 判断用户是否登录
     * @return bool
     */
    public function isLogin();

    /**
     * 判断某个操作是否有权限
     * @param $opt
     * @param $permissions
     * @return bool
     */
    public function hasPermission($opt, &$permissions);

    /**
     * 判断某个管理员是否为超级管理员
     * @param $user
     * @return bool
     */
    public function isSuperManager($user);
}
?>