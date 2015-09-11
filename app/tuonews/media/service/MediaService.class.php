<?php
namespace media\service;

use common\service\CommonService;
use herosphp\bean\Beans;
use herosphp\cache\CacheFactory;
use herosphp\core\Loader;
use herosphp\session\Session;
use herosphp\utils\ArrayUtils;
use media\listener\MediaListener;
use media\service\interfaces\IMediaService;

Loader::import('media.service.interfaces.IMediaService', IMPORT_APP);
Loader::import('media.listener.MediaListener', IMPORT_APP);
Loader::import('common.service.CommonService', IMPORT_APP);

/**
 * 媒体服务接口实现
 * Class MediaService
 * @package media\service
 */
class MediaService extends CommonService implements IMediaService {


    /**
     * 媒体监听器
     * @var array
     */
    private $listener = null;

    /**
     * 初始化监听器
     */
    public function __construct() {

        $this->listener = new MediaListener();

    }

    /**
     * @see \media\service\interfaces\IMediaService::add
     */
    public function add($data) {

        $mediaId = $this->getModelDao()->add($data);
        if ( $mediaId > 0 ) {
            //触发媒体添加监听事件
            if ( $this->listener instanceof MediaListener ) {
                if ( method_exists($this->listener, 'add') ) {
                    $this->listener->add($mediaId);
                }
            }
        }

        return $mediaId;
    }

    /**
     * @see \media\service\interfaces\IMediaService::getLoginMedia
     */
    public function getLoginMedia() {

        Session::start();
        return $_SESSION[IMediaService::SESSION_MEDIA_USER];
    }

    /**
     * @see \media\service\interfaces\IMediaService::setLoginMedia
     */
    public function setLoginMedia($media) {

        Session::start();
        $_SESSION[IMediaService::SESSION_MEDIA_USER] = $media;

    }

    /**
     * @see \media\service\interfaces\IMediaService::setMediaData
     */
    public function setMediaData($field, $content, $id) {

        return $this->getModelDao()->setMediaData($field, $content, $id);

    }

    /**
     * @see \media\service\interfaces\IMediaService::delete
     */
    public function delete($id) {

        //开启事务
        $this->beginTransaction();
        $result = $this->getModelDao()->delete($id);

        if ( $result == false ) {
            $this->rollback();
            return false;
        }

        //触发删除媒体监听事件
        if ( $this->listener instanceof MediaListener ) {
            if ( method_exists($this->listener, 'delete') ) {
                if ( !$this->listener->delete($id) ) {
                    $this->rollback();
                    return false;
                }
            }
        }
        $this->commit();
        return $result;

    }

    /**
     * @see \media\service\interfaces\IMediaService::deletes
     */
    public function deletes($conditions) {

        $medias = $this->getItems($conditions, 'id');
        $counter = 0;
        foreach ( $medias as $value ) {
            if ( $this->delete($value['id']) ) {
                $counter++;
            }
        }

        return ($counter == count($medias));
    }

    /**
     * @see \media\service\interfaces\IMediaService::openSite
     */
    public function openSite($conditions) {

        $medias = $this->getItems($conditions, 'id, userid');
        $this->beginTransaction();
        foreach ( $medias as $value ) {
            //触发开通媒体站媒体监听事件
            if ( $this->listener instanceof MediaListener ) {
                if ( method_exists($this->listener, 'openSite') ) {
                    if ( !$this->listener->openSite($value, true) ) {
                        $this->rollback();
                        return false;
                    }
                }
            }
        }

        $this->commit();
        return true;
    }

    /**
     * @see \media\service\interfaces\IMediaService::getRecommendMedia
     */
    public function getRecommendMedia($rows, $position, $fields=null) {

        //首先获取缓存，默认缓存有效期为2小时
        $CACHER = CacheFactory::create('file');
        $CACHER->baseKey('media')->ftype($position)->factor($rows);
        $items = $CACHER->get(null, 7200);
        if ( $items ) {
            return $items;
        }

        //获取媒体推荐位
        if ( $fields == null ) {
            $fields = 'id,name,logo';
        }
        $mediaRecService = Beans::get('media.rec.service');
        $item = $mediaRecService->getItem(array('position' => $position), 'media_ids');

        //获取媒体
        if ( $item ) {
            $medias = $this->getItems("id in({$item['media_ids']})", $fields, null, 1, $rows);
            //添加缓存
            $CACHER->set(null, $medias);
        }

        return $medias;

    }

    /**
     * @see \media\service\interfaces\IMediaService::getMediaCarousel
     */
    public function getMediaCarousel($rows, $mediaId) {

        $articleService = Beans::get('article.article.service');
        $articleRecService = Beans::get('media.articleRec.service');
        $baseCondi = getMediaArticleConds();
        //1. 先读取轮播图推荐位
        $rcondi = array('media_id' => $mediaId, 'position' => 1, 'status' => 1);
        $item = $articleRecService->getItem($rcondi, 'aids');
        $field = 'id, title, thumb, bcontent, hits, author';
        if ( $item && $item['aids'] ) {
            $conditions = $baseCondi;
            $conditions['id'] = '#IN'.$item['aids'];
            $items = $articleService->getItems($conditions, $field, null, 1, $rows);
            if ( $items ) {
                //按照ID排序
                $ids = explode(',', $item['aids']);
                $newsItems = array();
                $items = ArrayUtils::changeArrayKey($items, 'id');
                foreach ( $ids as $value ) {
                    if ( $items[$value] ) {
                        $newsItems[] = $items[$value];
                    }
                }
            }
        }
        //2. 推荐位的文章不够，再从最热门搜索补上
        if ( count($newsItems) < $rows ) {
            $conditions = $baseCondi;
            $conditions['media_id'] = $mediaId;
            if ( $item['aids'] ) {
                $conditions['id'] = '#NI'.$item['aids'];
            }
            $conditions['thumb'] = "!=''";
            $__items = $articleService->getItems($conditions, $field, "id desc", 1, $rows-count($newsItems));
        }
        $result = array();
        if ( $newsItems ) {
            $result = array_merge($result, $newsItems);
        }
        if ( $__items ) {
            $result = array_merge($result, $__items);
        }
        return $result;
    }
}
