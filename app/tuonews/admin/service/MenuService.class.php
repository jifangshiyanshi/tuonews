<?php
namespace admin\service;

use admin\service\interfaces\IMenuService;
use common\service\CommonService;
use herosphp\bean\Beans;
use herosphp\cache\CacheFactory;
use herosphp\core\Loader;
use herosphp\utils\ArrayUtils;

Loader::import('admin.service.interfaces.IMenuService', IMPORT_APP);
Loader::import('common.service.CommonService', IMPORT_APP);

/**
 * 后台菜单接口实现
 * Class MenuService
 * @package admin\service
 */
class MenuService extends CommonService implements IMenuService {

    /**
     * 菜单缓存key
     * @var string
     */
    protected static $CACHE_KEY = 'admin.menu.data';

    /**
     * @see \admin\service\interfaces\IMenuService::getMenuCache
     */
    public function getMenuCache() {

        $CACHER = CacheFactory::create('file');
        $items = $CACHER->get(self::$CACHE_KEY, 0);
        if ( !$items ) {
            $this->updateMenuCache();
            return $CACHER->get(self::$CACHE_KEY, 0);
        }
        return $items;

    }

    /**
     * @see \admin\service\interfaces\IMenuService::updateMenuCache
     */
    public function updateMenuCache() {

        //获取菜单分组
        $groupService = Beans::get('admin.menuGroup.service');
        $groups = $groupService->getItems(null, 'tkey');
        //获取所有的菜单
        $menus = $this->getItems('ishow=1', 'id,groupkey,name,url,pid');
        $menuData = array();
        foreach ( $groups as $values ) {
            //获取当前分组的一级菜单
            $conditions = array('pid' => 0, 'groupkey' => $values['tkey'], 'ishow' => 1);
            $topMemus = $this->getItems($conditions, 'id,groupkey,name,url,pid', 'sort_num ASC');
            foreach ( $topMemus as $key => $val ) {
                $topMemus[$key]['sub'] = ArrayUtils::filterArrayByKey('pid', $val['id'], $menus);
            }
            $menuData[$values['tkey']] = $topMemus;
        }

        $CACHER = CacheFactory::create('file');
        return $CACHER->set(self::$CACHE_KEY, $menuData);
    }

    /**
     * @see \admin\service\interfaces\IMenuService::getMenuByUser
     */
    public function getMenuByUser($user) {

        $menus = $this->getMenuCache();

        //如果是超级管理员，则直接返回所有菜单
        $adminService = Beans::get('admin.admin.service');
        if ( $adminService->isSuperManager($user) ) {
            return $menus;
        }
        $permissions = $adminService->getPermissions();
        $data = array();
        foreach ( $menus as $key => $value ) {
            $data[$key] = array();
            $i = 0;
            foreach ( $value as $_value ) {
                if ( $this->hasSubMenu($_value['sub'], $permissions) ) {

                    $data[$key][$i] = $_value;
                    $data[$key][$i]['sub'] = array();
                    foreach ( $_value['sub'] as $val ) {
                        $__key = $this->url2PermissionKey($val['url']);
                        if ( $permissions[$__key] == 1 ) {
                            $data[$key][$i]['sub'][] = $val;
                        }
                    }
                }
                $i++;
            }
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

        $url = explode('_', $url);
        return $url[1].'@'.$url[2];

    }
}