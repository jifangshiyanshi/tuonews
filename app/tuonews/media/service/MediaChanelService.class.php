<?php
namespace media\service;

use common\service\CommonService;
use herosphp\cache\CacheFactory;
use herosphp\core\Loader;
use media\listener\MediaChanelListener;
use media\service\interfaces\IMediaChanelService;

Loader::import('media.service.interfaces.IMediaChanelService', IMPORT_APP);
Loader::import('media.listener.MediaChanelListener', IMPORT_APP);
Loader::import('common.service.CommonService', IMPORT_APP);

/**
 * 媒体频道服务接口实现
 * Class MediaChanelService
 * @package media\service
 */
class MediaChanelService extends CommonService implements IMediaChanelService {


    /**
     * 媒体频道监听器
     * @var array
     */
    private $listener = null;

    /**
     * 初始化监听器
     */
    public function __construct() {

        $this->listener = new MediaChanelListener();

    }

    /**
     * @see \media\service\interfaces\IMediaChanelService::add
     */
    public function add($data) {

        $result = $this->getModelDao()->add($data);
        //清除缓存
        if ( $result && $data['media_id'] ) {
            $this->deleteMediaChanelCache($data['media_id']);
        }
        return $result;
    }

    /**
     * @see \media\service\interfaces\IMediaChanelService::update
     */
    public function update($data, $id) {

        $result = $this->getModelDao()->update($data, $id);
        //清除缓存
        if ( $result ) {
            $item = $this->getItem($id, 'media_id');
            $this->deleteMediaChanelCache($item['media_id']);
        }
        return $result;
    }

    /**
     * @see \media\service\interfaces\IMediaChanelService::delete
     */
    public function delete($id) {

        //开启事务
        $this->beginTransaction();
        $item = $this->getItem($id, 'media_id');
        $result = $this->getModelDao()->delete($id);

        if ( $result == false ) {
            $this->rollback();
            return false;
        }

        //触发删除媒体频道监听事件
//        if ( $this->listener instanceof MediaChanelListener ) {
//            if ( method_exists($this->listener, 'delete') ) {
//                if ( !$this->listener->delete($id) ) {
//                    $this->rollback();
//                    return false;
//                }
//            }
//        }

        //清除缓存
        $this->deleteMediaChanelCache($item['media_id']);
        $this->commit();
        return $result;

    }

    /**
     * @see \media\service\interfaces\IMediaChanelService::deletes
     */
    public function deletes($conditions) {

        $users = $this->getItems($conditions, 'id');
        $counter = 0;
        foreach ( $users as $value ) {
            if ( $this->delete($value['id']) ) {
                $counter++;
            }
        }

        return ($counter == count($users));
    }

    /**
     * @see \media\service\interfaces\IMediaChanelService::getChanelCache
     */
    public function getChanelCache($mediaId) {

        //首先读取缓存
        $CACHER = CacheFactory::create('file');
        $CACHER->baseKey('media')->ftype('chanel')->factor($mediaId);
        $items = $CACHER->get(null, 0);
        if ( $items ) {
            return $items;
        }

        $condi = array('media_id' => $mediaId);
        $items  = $this->getItems($condi, null, "sort_num ASC");

        if ( $items ) {
            $CACHER->set(null, $items);
        }
        return $items;
    }

    /**
     * 清除媒体频道缓存
     * @param $mediaId
     */
    public function deleteMediaChanelCache($mediaId) {
        $CACHER = CacheFactory::create('file');
        $CACHER->baseKey('media')->ftype('chanel')->factor($mediaId);
        $CACHER->delete(null);
    }
}
