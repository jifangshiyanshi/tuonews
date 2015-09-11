<?php
namespace article\service;

use article\service\interfaces\IArticleViewService;
use common\service\CommonService;
use herosphp\bean\Beans;
use herosphp\core\Loader;

Loader::import('article.service.interfaces.IArticleViewService', IMPORT_APP);
Loader::import('common.service.CommonService', IMPORT_APP);

/**
 * 文章视图接口实现
 * Class ArticleViewService
 * @package article\service
 */
class ArticleViewService extends CommonService implements IArticleViewService {

    /**
     * @see \article\service\interfaces\IArticleViewService::add
     */
    public function add($data) {

        if ( APP_DEBUG ) {
            E('视图服务不支持写操作！');
        }

    }

    /**
     * @see \article\service\interfaces\IArticleViewService::update
     */
    public function update($data, $id) {

        if ( APP_DEBUG ) {
            E('视图服务不支持写操作！');
        }

    }

    /**
     * @see \article\service\interfaces\IArticleViewService::getItems
     */
    public function getItems($conditions, $fields, $order, $page, $pagesize, $group, $having) {

        //默认按照ID分组
        if ( !$group ) {
            $group = 'id';
        }
        return $this->getModelDao()->getItems($conditions, $fields, $order, $page, $pagesize, $group, $having);
    }

    /**
     * @see \article\service\interfaces\IArticleViewService::getItems
     */
    public function getItem($conditions, $fields, $order, $group, $having) {

        $item = $this->getModelDao()->getItem($conditions, $fields, $order, $group, $having);
        //将标签ID转为标签名称
        $tagSerive = Beans::get('article.tags.service');
        $tags = $tagSerive->getItems(explode(',', $item['tags']), 'name');
        $item['tags_name'] = array();
        foreach ( $tags as $_val ) {
            $item['tags_name'][] = $_val['name'];
        }
        return $item;
    }

    /**
     * @see \article\service\interfaces\IArticleViewService::delete
     */
    public function delete($id) {

        if ( APP_DEBUG ) {
            E('视图服务支持删除操作！');
        }

    }

    /**
     * @see \article\service\interfaces\IArticleViewService::deletes
     */
    public function deletes($conditions) {

        if ( APP_DEBUG ) {
            E('视图服务支持删除操作！');
        }

    }
}
