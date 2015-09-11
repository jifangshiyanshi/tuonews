<?php
namespace media\service;

use common\service\CommonService;
use herosphp\bean\Beans;
use herosphp\core\Loader;
use herosphp\utils\ArrayUtils;
use media\service\interfaces\IMediaManagerService;

Loader::import('media.service.interfaces.IMediaManagerService', IMPORT_APP);
Loader::import('common.service.CommonService', IMPORT_APP);

/**
 * 媒体管理员服务接口实现
 * Class MediaManagerService
 * @package media\service
 */
class MediaManagerService extends CommonService implements IMediaManagerService {

    /**
     * @see \media\service\interfaces\IMediaManagerService::getItems
     */
    public function getItems($conditions, $fields, $order, $page, $pagesize, $group, $having)
    {
        $items = $this->getModelDao()->getItems($conditions, $fields, $order, $page, $pagesize, $group, $having);
        //填充用户数据和角色数据
        $roleIds = array();
        $userIds = array();
        foreach ( $items as $value ) {
            $userIds[] = $value['userid'];
            $roleIds[] = $value['role_id'];
        }

        $managerRoleService = Beans::get('media.managerRole.service');
        $userService = Beans::get('user.user.service');

        //获取用户和角色
        $users = array();
        $roles = array();
        if ( !empty($roleIds) ) {
            $roles = $managerRoleService->getItems($roleIds, 'id,name');
            $roles = ArrayUtils::changeArrayKey($roles, 'id');
        }
        if ( !empty($userIds) ) {
            $users = $userService->getItems($userIds,'id,username,email');
            $users = ArrayUtils::changeArrayKey($users, 'id');
        }

        //填充数据
        foreach ( $items as $key => $value ) {
            $items[$key]['username'] = $users[$value['userid']]['username'];
            if ( $items[$key]['email'] == '' ) {
                $items[$key]['email'] = $users[$value['userid']]['email'];
            }
            $items[$key]['role'] = $roles[$value['role_id']]['name'];
        }
        return $items;
    }

    /**
     * @see \media\service\interfaces\IMediaManagerService::getItem
     */
    public function getItem($conditions, $fields, $order, $group, $having)
    {
        $item = $this->getModelDao()->getItem($conditions, $fields, $order, $group, $having);

        //补全用户信息和角色信息
        $managerRoleService = Beans::get('media.managerRole.service');
        $userService = Beans::get('user.user.service');
        $user = $userService->getItem($item['userid'], 'username,email');
        $role = $managerRoleService->getItem($item['role'], 'name');

        $item['username'] = $user['username'];
        if ( $item['email'] == '' ) {
            $item['email'] = $user['email'];
        }
        $item['role'] = $role['name'];

        return $item;
    }

    /**
     * @see \media\service\interfaces\IMediaManagerService::getUserMenu
     */
    public function getUserMenu($userid, $mediaId) {

        //1. 不是当前登录媒体的管理员
        $item = $this->getItem("userid={$userid} AND media_id={$mediaId}");
        if ( !$item ) {
            return false;
        }
        $mediaService = Beans::get('media.media.service');
        $loginMedia = $mediaService->getItem($mediaId, 'id, media_type');

        //获取媒体类型，加载媒体权限模板
        $mediaTypeService = Beans::get('media.type.service');
        $mediaType = $mediaTypeService->getItem($loginMedia['media_type']);
        $permissionTpl = $mediaType['permission_tpl'];
        $menus = Loader::config($permissionTpl.'_menu', 'permission');

        //2. 当前媒体的超级管理员
        if ( $item['role_id'] == 0 ) {
            return $menus;
        }

        //3. 如果管理员已经被禁用，则直接返回false
        if ( $item['status'] == -1 ) {
            return false;
        }

        //获取管理员角色和权限
        $roleService = Beans::get('media.managerRole.service');
        $role = $roleService->getItem($item['role_id']);
        $permissions = cn_json_decode($role['permission']);

        //获取菜单
        $data = array();
        $i = 0;
        foreach ( $menus as $key => $value ) {

            if ( $this->hasSubMenu($value['sub'], $permissions) ) {
                $data[$key] = $value;
                $data[$key]['sub'] = array();
                foreach ( $value['sub'] as $val ) {
                    $__key = $this->url2PermissionKey($val['url']);
                    if ( $permissions[$__key] == 1 ) {
                        $data[$key]['sub'][] = $val;
                    }
                }
            }
            $i++;
        }
        return $data;
    }

    /**
     * 是否有子菜单
     * @param $subMenus
     * @param $permissions
     * @return bool
     */
    private function hasSubMenu($subMenus, &$permissions) {

        foreach ( $subMenus as $value ) {
            $key = $this->url2PermissionKey($value['url']);
            if ( $permissions[$key] == 1 ) {
                return true;
            }
        }
        return false;
    }

    /**
     * 将菜单的url转为权限数组的key
     * @param $url
     * @return string
     */
    private function url2PermissionKey($url) {

        $url = str_replace('.shtml', '', $url);
        $url = explode('_', $url);
        return $url[1].'@'.$url[2];

    }

    /**
     * @see \media\service\interfaces\IMediaManagerService::getUserPermission
     */
    public function getUserPermission($userid, $mediaId) {

        //1. 不是当前登录媒体的管理员
        $item = $this->getItem("userid={$userid} AND media_id={$mediaId}");
        if ( !$item ) {
            return false;
        }
        //4. 如果管理员已经被禁用，则直接返回false
        if ( $item['status'] == -1 ) {
            return false;
        }

        //获取管理员角色和权限
        $roleService = Beans::get('media.managerRole.service');
        $role = $roleService->getItem($item['role_id']);
        $permissions = cn_json_decode($role['permission']);

        return $permissions;

    }

    /**
     * @see \media\service\interfaces\IMediaManagerService::hasPermission
     */
    public function hasPermission($opt, $userid) {

        //获取当前登录媒体的权限
        $mediaService = Beans::get('media.media.service');
        $loginMedia = $mediaService->getLoginMedia();

        //1. 如果是当前登录媒体的超级管理员(申请者)
        if ( $loginMedia['userid'] == $userid ) {
            return true;
        }

        //加载媒体所有权限选项
        $permissionOptions = Loader::config('media_permissions', 'permission');
        //2. 如果该该操作没有加入权限限制，则所有人都有权限操作
        $__opt = explode('@', $opt);
        if ( !isset($permissionOptions[$__opt[0]]['methods'][$__opt[1]]) ) {
            return true;
        }

        //3. 判断操作权限
        $permissions = $loginMedia['permission'];
        return ($permissions[$opt] == 1);
    }

}
