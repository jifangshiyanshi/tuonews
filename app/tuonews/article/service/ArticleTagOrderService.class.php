<?php
namespace article\service;

use article\service\interfaces\IArticleTagOrderService;
use common\service\CommonService;
use herosphp\core\Loader;

Loader::import('article.service.interfaces.IArticleTagOrderService', IMPORT_APP);
Loader::import('common.service.CommonService', IMPORT_APP);

/**
 * 文章标签订阅接口实现
 * Class ArticleTagOrderService
 * @package article\service
 */
class ArticleTagOrderService extends CommonService implements IArticleTagOrderService {

    /**
     * @see \article\service\interfaces\IArticleTagOrderService::getOrdersByUser
     */
    public function getOrdersByUser( $userid, $fields, $page, $pagesize ) {

    }

}