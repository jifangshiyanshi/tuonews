<?php
namespace admin\service;

use admin\service\interfaces\IFriendLinkService;
use common\service\CommonService;
use herosphp\cache\CacheFactory;
use herosphp\core\Loader;

Loader::import('admin.service.interfaces.IFriendLinkService', IMPORT_APP);
Loader::import('common.service.CommonService', IMPORT_APP);

/**
 * 系统频道服务接口实现
 * Class ChanelService
 * @package admin\service
 */
class FriendLinkService extends CommonService implements IFriendLinkService {

    /**
     * @see \admin\service\interfaces\IFriendLinkService::add
     */
    public function add($data) {

        $result = $this->getModelDao()->add($data);
        if ( $result ) {
            $this->deleteFootLinkCache();
        }
        return $result;
    }

    /**
     * @see \admin\service\interfaces\IFriendLinkService::update
     */
    public function update($data, $id) {

        $result = $this->getModelDao()->update($data, $id);
        if ( $result ) {
            $this->deleteFootLinkCache();
        }
        return $result;

    }

    /**
     * @see \admin\service\interfaces\IFriendLinkService::getFootLink
     */
    public function getFootLinks($rows=10, $order='sort_num ASC') {

        //首先获取缓存
        $CACHER = CacheFactory::create('file');
        $items = $CACHER->get(self::FOOT_LINK_CACHE, 120);
        if ( $items ) {
            //return $items;
        }

        $items = $this->getItems('ishow=1', 'id,url,name', $order, 1, $rows);
        //添加缓存
        $CACHER->set(self::FOOT_LINK_CACHE, $items);

        return $items;

    }

    /**
     * @see \admin\service\interfaces\IFriendLinkService::deleteFootLinkCache
     */
    public function deleteFootLinkCache() {
        $CACHER = CacheFactory::create('file');
        $CACHER->delete(self::FOOT_LINK_CACHE);
    }
}
