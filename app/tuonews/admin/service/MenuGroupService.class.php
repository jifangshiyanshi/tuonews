<?php
namespace admin\service;

use admin\service\interfaces\IMenuGroupService;
use common\service\CommonService;
use herosphp\cache\CacheFactory;
use herosphp\core\Loader;

Loader::import('admin.service.interfaces.IMenuGroupService', IMPORT_APP);
Loader::import('common.service.CommonService', IMPORT_APP);

/**
 * 后台菜单分组服务接口实现
 * Class MenuGroupService
 * @package admin\service
 */
class MenuGroupService extends CommonService implements IMenuGroupService {

    /**
     * 缓存key
     * @var string
     */
    protected static $CACHE_KEY = 'admin.menu.group';

    /**
     * @see \admin\service\interfaces\IMenuGroupService::add
     */
    public function add($data) {

        $reuslt = $this->getModelDao()->add($data);
        if ( $reuslt ) {
            $this->updateCache();
        }
        return $reuslt;
    }

    /**
     * @see \admin\service\interfaces\IMenuGroupService::update
     */
    public function update($data, $id) {

        $reuslt = $this->getModelDao()->update($data, $id);
        if ( $reuslt ) {
            $this->updateCache();
        }
        return $reuslt;

    }

    /**
     * @see \admin\service\interfaces\IMenuGroupService::getGroupCache
     */
    public function getGroupCache() {

        $CACHER = CacheFactory::create('file');
        $items = $CACHER->get(self::$CACHE_KEY, 0);
        if ( !$items ) {
            $this->updateCache();
            return $CACHER->get(self::$CACHE_KEY, 0);
        }
        return $items;
    }

    /**
     * 更新菜单分组缓存
     */
    protected function updateCache() {

        $items = $this->getItems();
        $CACHER = CacheFactory::create('file');
        return $CACHER->set(self::$CACHE_KEY, $items);
    }
}