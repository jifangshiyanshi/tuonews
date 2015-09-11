<?php
namespace admin\service;

use admin\service\interfaces\IChanelService;
use common\service\CommonService;
use herosphp\cache\CacheFactory;
use herosphp\core\Loader;
use herosphp\utils\ArrayUtils;

Loader::import('admin.service.interfaces.IChanelService', IMPORT_APP);
Loader::import('common.service.CommonService', IMPORT_APP);

/**
 * 系统频道服务接口实现
 * Class ChanelService
 * @package admin\service
 */
class ChanelService extends CommonService implements IChanelService {

    const  CHANEL_ITEMS_KEY = 'chenel_items_key';

    /**
     * @see \admin\service\interfaces\IChanelService::getChanelCache
     */
    public function getChanelCache($expr=0) {

        //首先获取缓存
        $CACHE = CacheFactory::create('file');
        $items = $CACHE->get(self::CHANEL_ITEMS_KEY, $expr);
        //如果命中缓存了，则直接返回缓存
        if ( $items ) {
            return $items;
        }

        //获取全部频道
        $chanels = $this->getItems(null, 'id,pid,name,sort_num', 'sort_num ASC');

        //获取一级频道
        $levelOne = ArrayUtils::filterArrayByKey('pid', 0, $chanels);
        foreach ( $levelOne as $key => $value ) {
            $levelOne[$key]['sub'] = ArrayUtils::filterArrayByKey('pid', $value['id'], $chanels);
        }

        $CACHE->set(self::CHANEL_ITEMS_KEY, $levelOne);
        return $levelOne;

    }

    /**
     * @see \admin\service\interfaces\IChanelService::add
     */
    public function add($data) {

        $resullt = parent::add($data);
        if ( $resullt ) {
            //删除缓存，以便前台重新生成
            $CACHE = CacheFactory::create('file');
            $CACHE->delete(self::CHANEL_ITEMS_KEY);
        }
        return $resullt;
    }

    /**
     * @see \admin\service\interfaces\IChanelService::update
     */
    public function update($data, $id) {

        $resullt = parent::update($data, $id);
        if ( $resullt ) {
            //删除缓存，以便前台重新生成
            $CACHE = CacheFactory::create('file');
            $CACHE->delete(self::CHANEL_ITEMS_KEY);
        }

        return $resullt;
    }

    /**
     * @see \admin\service\interfaces\IChanelService::delete
     */
    public function delete($id) {

        $resullt = parent::delete($id);
        if ( $resullt ) {
            //删除缓存，以便前台重新生成
            $CACHE = CacheFactory::create('file');
            $CACHE->delete(self::CHANEL_ITEMS_KEY);
        }
        return $resullt;
    }
}