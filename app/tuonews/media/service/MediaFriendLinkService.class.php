<?php
namespace media\service;

use common\service\CommonService;
use herosphp\cache\CacheFactory;
use herosphp\core\Loader;
use media\service\interfaces\IMediaFriendLinkService;

Loader::import('media.service.interfaces.IMediaFriendLinkService', IMPORT_APP);
Loader::import('common.service.CommonService', IMPORT_APP);

/**
 * 媒体友情链接服务接口实现
 * Class MediaFriendLinkService
 * @package media\service
 */
class MediaFriendLinkService extends CommonService implements IMediaFriendLinkService {

    /**
     * @see \media\service\interfaces\IMediaFriendLinkService::add
     */
    public function add($data) {

        $result = $this->getModelDao()->add($data);
        //清除缓存
        if ( $result && $data['media_id'] ) {
            $this->deleteMediaFLCache($data['media_id']);
        }
        return $result;
    }

    /**
     * @see \media\service\interfaces\IMediaFriendLinkService::update
     */
    public function update($data, $id) {

        $result = $this->getModelDao()->update($data, $id);
        //清除缓存
        if ( $result ) {
            $item = $this->getItem($id, 'media_id');
            $this->deleteMediaFLCache($item['media_id']);
        }
        return $result;
    }

    /**
     * @see \media\service\interfaces\IMediaFriendLinkService::delete
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

        $this->commit();
        //清除缓存
        $this->deleteMediaChanelCache($item['media_id']);
        return $result;

    }

    /**
     * @see \media\service\interfaces\IMediaFriendLinkService::getMediaFriendLinks
     */
    public function getMediaFriendLinks($mediaId) {

        //首先读取缓存
        $CACHER = CacheFactory::create('file');
        $CACHER->baseKey('media')->ftype('friendlink')->factor($mediaId);
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
     * 清除媒体友情链接缓存
     * @param $mediaId
     */
    public function deleteMediaFLCache($mediaId) {
        $CACHER = CacheFactory::create('file');
        $CACHER->baseKey('media')->ftype('friendlink')->factor($mediaId);
        $CACHER->delete(null);
    }
}
