<?php
namespace article\service;

use article\service\interfaces\IArtoneService;
use common\service\CommonService;
use herosphp\bean\Beans;
use herosphp\cache\CacheFactory;
use herosphp\core\Loader;

Loader::import('article.service.interfaces.IArtoneService', IMPORT_APP);
Loader::import('common.service.CommonService', IMPORT_APP);

/**
 * 单文章服务接口实现
 * Class ArtoneService
 * @package article\service
 */
class ArtoneService extends CommonService implements IArtoneService {

    /**
     * @see \article\service\interfaces\IArtoneService::add
     */
    public function add($data) {

        //添加文章
        $aid = $this->getModelDao()->add($data);

        //添加成功则提取远程图片
        if ( $aid > 0 ) {
            $imageService = Beans::get('image.image.service');
            $imageService->getRemoteImage($data['content'], $aid, 'artone');

            //删除单文章缓存
            if ( $data['media_id']  > 0 ) {
                $this->deleteMediaArtcache($data['media_id']);
            }
        }

        return $aid;
    }

    /**
     * @see \article\service\interfaces\IArtoneService::update
     */
    public function update($data, $id) {

        //更新文章
        $result = $this->getModelDao()->update($data, $id);

        //更新成功则提取远程图片
        if ( $result ) {
            $imageService = Beans::get('image.image.service');
            $imageService->getRemoteImage($data['content'], $id, 'artone');

            //删除媒体单文章缓存
            $item = $this->getItem($id, 'media_id');
            if ( $item['media_id']  > 0 ) {
                $this->deleteMediaArtcache($item['media_id']);
            }
        }

        return $result;
    }

    /**
     * @see \article\service\interfaces\IArtoneService::delete
     */
    public function delete($id) {

        $result = $this->getModelDao()->delete($id);

        //更新单文章缓存
        if ( $result ) {
            $item = $this->getItem($id, 'media_id');
            if ( $item['media_id']  > 0 ) {
                $this->deleteMediaArtcache($item['media_id']);
            }
        }

        return $result;

    }

    /**
     * @see \article\service\interfaces\IArtoneService::setContent
     */
    public function setContent($content, $id) {

        return $this->getModelDao()->getDataDao()->set('content', $content, $id);

    }

    /**
     * @see \article\service\interfaces\IArtoneService::getContent
     */
    public function getContent($id) {

        $item = $this->getModelDao()->getItem($id);
        if ( $item ) {
            return $item['content'];
        } else {
            return false;
        }

    }

    /**
     * @see \article\service\interfaces\IArtoneService::getFootNavis
     */
    public function getFootNavis($rows, $position) {

        //首先获取缓存
        $CACHER = CacheFactory::create('file');
        $items = $CACHER->get(self::FOOT_NAVIS_CACHE, 0);
        if ( $items ) {
            return $items;
        }

        //获取推荐位信息
        $artonePositionService = Beans::get('artone.position.service');
        $item = $artonePositionService->getItem("position='{$position}'", 'aids');

        //获取单文章信息
        if( trim($item['aids']) == '' ) {
            return null;
        }
        $items = $this->getItems("id in({$item['aids']})", 'id,title', 'sort_num ASC', 1, $rows);
        $CACHER->set(self::FOOT_NAVIS_CACHE, $items);
        return $items;
    }

    /**
     * @see \article\service\interfaces\IArtoneService::deleteFootNavisCache
     */
    public function deleteFootNavisCache() {
        $CACHER = CacheFactory::create('file');
        $CACHER->delete(self::FOOT_NAVIS_CACHE);
    }

    /**
     * @see \article\service\interfaces\IArtoneService::getMediaNavis
     */
    public function getMediaArtone($mediaId) {

        //首先获取缓存
        $CACHER = CacheFactory::create('file');
        $CACHER->baseKey('media')->ftype('artone')->factor($mediaId);
        $items = $CACHER->get(null, 0);
        if ( $items ) {
            return $items;
        }

        $condi = array('media_id' => intval($mediaId));
        $items = $this->getItems($condi, null, 'sort_num ASC');

        if ( $items ) {
            $CACHER->set(null, $items);
        }
        return $items;
    }

    /**
     * 删除媒体单文章缓存
     * @param $mediaId
     */
    public function deleteMediaArtcache($mediaId) {
        $CACHER = CacheFactory::create('file');
        $CACHER->baseKey('media')->ftype('artone')->factor($mediaId);
        $CACHER->delete(null);
    }

}
