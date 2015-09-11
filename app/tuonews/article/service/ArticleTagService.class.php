<?php
namespace article\service;

use article\service\interfaces\IArticleTagService;
use common\service\CommonService;
use herosphp\bean\Beans;
use herosphp\cache\CacheFactory;
use herosphp\core\Loader;

Loader::import('article.service.interfaces.IArticleTagService', IMPORT_APP);
Loader::import('common.service.CommonService', IMPORT_APP);

/**
 * 文章标签服务接口实现
 * Class ArticleTagService
 * @package article\service
 */
class ArticleTagService extends CommonService implements IArticleTagService {


    /**
     * 批量标签
     * @see \article\service\interfaces\IArticleTagService::delete()
     */
    public function delete($id) {

        if ( $this->getModelDao()->delete($id) ) {

            //删除标签订阅
            $tagOrderSerivce = Beans::get('article.tags.order');
            $tagOrderSerivce->deletes("tagid={$id}");
            return true;
        } else {
            return false;
        }

    }

    /**
     * 批量删除标签
     * @see \article\service\interfaces\IArticleTagService::deletes()
     */
    public function deletes($conditions) {

        $items = $this->getModelDao()->getItems($conditions, 'id');
        $counter = 0;
        foreach ( $items as $value ) {
            if ( $this->delete($value['id']) ) {
                $counter++;
            }
        }
        //全部删除成功才算删除成功
        return (count($items) == $counter);
    }

    /**
     * @see \article\service\interfaces\IArticleTagService::getHotTags
     */
    public function getHotTags($rows=4, $field='id,name') {

        //首先获取缓存，默认缓存有效期为2小时
//        $CACHER = CacheFactory::create('file');
//        $CACHER->baseKey('article')->ftype('hotTags')->factor($rows);
//        $items = $CACHER->get(null, 7200);
//        if ( $items ) {
//            return $items;
//        }

        $result = array();
        //1. 获取后台推荐的标签
        $items = $this->getItems('isrec=1', $field, null, 1, $rows);
        if ( $items ) {
            $result = array_merge($result, $items);
        }

        $__rows = count($items);
        //2. 如果不够的话直接或点击率开前的补上
        if ( $__rows < $rows ) {
            if ( $__rows > 0 ) {
                $tagIds = array();
                foreach ( $items as $value ) {
                    $tagIds[] = $value['id'];
                }
                $condi = array('id' => '#NI '.implode(',', $tagIds));

            } else {
                $condi = null;
            }
            $__items = $this->getItems($condi, $field, 'hits DESC', 1, $rows-$__rows);
            if ( $__items ) {
                $result = array_merge($result, $__items);
            }
        }

//        if ( !empty($result) ) {
//            $CACHER->set(null, $result);
//        }

        return $result;
    }

}
