<?php
namespace article\service;

use article\service\interfaces\IArticleService;
use common\service\CommonService;
use herosphp\bean\Beans;
use herosphp\cache\CacheFactory;
use herosphp\core\Loader;

Loader::import('article.service.interfaces.IArticleService', IMPORT_APP);
Loader::import('common.service.CommonService', IMPORT_APP);

/**
 * 文章服务接口实现
 * Class ArticleService
 * @package article\service
 */
class ArticleService extends CommonService implements IArticleService {

    /**
     * @see \article\service\interfaces\IArticleService::add
     */
    public function add($data) {

        //添加文章
        $aid = $this->getModelDao()->add($data);

        //添加成功则提取远程图片
        if ( $aid > 0 ) {
            $imageService = Beans::get('image.image.service');
            $imageService->getRemoteImage($data['content'], $aid, 'article');
        }

        return $aid;
    }

    /**
     * @see \article\service\interfaces\IArticleService::update
     */
    public function update($data, $id) {

        //更新文章
        $result = $this->getModelDao()->update($data, $id);

        //更新成功则提取远程图片
        if ( $result ) {
            $imageService = Beans::get('image.image.service');
            $imageService->getRemoteImage($data['content'], $id, 'article');
        }

        return $result;
    }

    /**
     * @see \article\service\interfaces\IArticleService::setContent
     */
    public function setContent($content, $id) {

        return $this->getModelDao()->getDataDao()->set('content', $content, $id);

    }

    /**
     * @see \article\service\interfaces\IArticleService::getContent
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
     * 推荐算法：
     * 1. 如果有标签，则找出含有相关标签的文章
     * 2. 如果没有标签,则找出当前频道的最热门的文章
     * @see \article\service\interfaces\IArticleService::getAlikeArticles
     */
    public function getAlikeArticles($id, $num, $field=null) {

        //首先获取缓存，默认缓存有效期为30分钟
        $CACHER = CacheFactory::create('file');
        $CACHER->baseKey('article')->ftype('alike')->factor($id);
        $items = $CACHER->get(null, 1800);
        if ( $items ) {
            return $items;
        }
        $item = $this->getModelDao()->getItem($id);

        if ( !$field ) {
            $field = 'id,title,thumb';
        }

        $conditions = array(
            'chanel_id' => $item['chanel_id'],
            'ischeck' => 1,
            'id' => '#NI '.$item['id']
        );

        if ( $item['tags'] != '' ) {
            $service = Beans::get('article.view.service');
            $__conditions = array(
                'tagid' => '#IN '.$item['tags'],
                'id' => '#NI '.$item['id']
            );
            $items = $service->getItems($__conditions, $field, "id DESC", 1, $num, 'id');
            if( !$items ) {
                $items = $this->getItems($conditions, $field, "id DESC", 1, $num);
            }

        } else {
            $items = $this->getItems($conditions, $field, "hits DESC", 1, $num);
        }

        //添加缓存
        $CACHER->set(null, $items);
        return $items;
    }

    /**
     * @see \article\service\interfaces\IArticleService::getHotRank
     */
    public function getHotRank($rows=10, $field=null) {

        //首先获取缓存，默认缓存有效期为5分钟
//        $CACHER = CacheFactory::create('file');
//        $CACHER->baseKey('article')->ftype('hotRank')->factor($rows);
//        $items = $CACHER->get(null, 300);
//        if ( $items ) {
//            return $items;
//        }

        if ( $field == null ) {
            $field = 'id, title, thumb';
        }

        $result = array();
        //1. 查看后台对应的推荐位是否有足够数量的文章
        $recommendService = Beans::get('article.rec.service');
        $recommend = $recommendService->getItem("position='hot_recommend'", 'aids');
        if ( $recommend['aids'] != '' ) {
            $items = $this->getItems("id in({$recommend['aids']})", $field, null, 1, $rows);
            if ( $items ) {
                $result = array_merge($result, $items);
            }
        }

        //2. 如果不够则直接从点击率最高的文章补上
        if ( count($items) < $rows ) {
            $condi = getArticleBasicConditions();
            if ( $recommend['aids'] != '' ) {
                $condi['id'] = '#NI'.$recommend['aids'];
            }
            $__items = $this->getItems($condi, $field, 'hits DESC', 1, $rows-count($items));
            if ( $__items ) {
                $result = array_merge($result, $__items);
            }
        }

        //添加缓存
        //$CACHER->set(null, $result);
        return $result;

    }

    /**
     * @see \article\service\interfaces\IArticleService::getWeekRank
     */
    public function getWeekRank($rows=10, $field=null) {

        //首先获取缓存，默认缓存有效期为20分钟
//        $CACHER = CacheFactory::create('file');
//        $CACHER->baseKey('article')->ftype('weekRank')->factor($rows);
//        $items = $CACHER->get(null, 1200);
//        if ( $items ) {
//            return $items;
//        }

        if ( $field == null ) {
            $field = 'id, title, thumb';
        }

        $result = array();
        //1. 查看后台对应的推荐位是否有足够数量的文章
        $recommendService = Beans::get('article.rec.service');
        $recommend = $recommendService->getItem("position='week_recommend'", 'aids');
        if ( $recommend['aids'] != '' ) {
            $items = $this->getItems("id in({$recommend['aids']})", $field, null, 1, $rows);
            if ( $items ) {
                $result = array_merge($result, $items);
            }
        }

        //2. 如果不够则直接从点击率最高的文章补上
        if ( count($items) < $rows ) {
            $condi = getArticleBasicConditions();
            if ( $recommend['aids'] != '' ) {
                $condi['id'] = '#NI'.$recommend['aids'];
            }
            $condi['add_time'] = '>='.strtotime(date('Y-m-d', strtotime("-7 day")));
            $__items = $this->getItems($condi, $field, 'hits DESC', 1, $rows-count($items));

            if ( $__items ) {
                $result = array_merge($result, $__items);
            }
        }

        //添加缓存
        //$CACHER->set(null, $result);
        return $result;

    }

    /**
     * @see \article\service\interfaces\IArticleService::getEditorRecommend
     */
    public function getEditorRecommend($rows=10, $field=null) {

        //首先获取缓存，默认缓存有效期为5分钟
//        $CACHER = CacheFactory::create('file');
//        $CACHER->baseKey('article')->ftype('editorRecommend')->factor($rows);
//        $items = $CACHER->get(null, 300);
//        if ( $items ) {
//            return $items;
//        }

        if ( $field == null ) {
            $field = 'id, title, thumb';
        }

        $result = array();
        //1. 查看后台对应的推荐位是否有足够数量的文章
        $recommendService = Beans::get('article.rec.service');
        $recommend = $recommendService->getItem("position='editor_recommend'", 'aids');
        if ( $recommend['aids'] != '' ) {
            $items = $this->getItems("id in({$recommend['aids']})", $field, null, 1, $rows);
            if ( $items ) {
                $result = array_merge($result, $items);
            }
        }

        //2. 如果不够则直接从点击率最高的文章补上
        if ( count($items) < $rows ) {
            $condi = getArticleBasicConditions();
            if ( $recommend['aids'] != '' ) {
                $condi['id'] = '#NI'.$recommend['aids'];
            }
            $__items = $this->getItems($condi, $field, 'hits DESC', 1, $rows-count($items));

            if ( $__items ) {
                $result = array_merge($result, $__items);
            }
        }

        //添加缓存
        //$CACHER->set(null, $result);
        return $result;

    }

    /**
     * @see \article\service\interfaces\IArticleService::getIndexCarousel
     */
    public function getIndexCarousel($rows, $field=null) {

        //首先获取缓存，默认缓存有效期为5分钟
//        $CACHER = CacheFactory::create('file');
//        $CACHER->baseKey('article')->ftype('indexCarousel')->factor($rows);
//        $items = $CACHER->get(null, 300);
//        if ( $items ) {
//            return $items;
//        }

        if ( $field == null ) {
            $field = 'id, title, thumb, bcontent';
        }

        //获取后台对应的推荐位的文章
        $result = array();
        $recommendService = Beans::get('article.rec.service');
        $recommend = $recommendService->getItem("position='index_carousel'", 'aids');
        if ( $recommend['aids'] != '' ) {
            $result = $this->getItems("id in({$recommend['aids']})", $field, 'id DESC', 1, $rows);
            //添加缓存
            //$CACHER->set(null, $result);
        }

        return $result;
    }

}
