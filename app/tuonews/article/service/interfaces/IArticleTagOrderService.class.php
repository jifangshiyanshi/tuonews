<?php

namespace article\service\interfaces;

use common\service\interfaces\ICommonService;
use herosphp\core\Loader;

Loader::import('common.service.interfaces.ICommonService', IMPORT_APP);

/**
 * 文章标签订阅服务接口
 * Interface IArticleTagService
 */
interface IArticleTagOrderService extends ICommonService {

    /**
     * 获取用户订阅标签的文章
     * @param int $userid 用户ID
     * @param string $fields 要查询的字段
     * @param int $page
     * @param int $pagesize
     * @return mixed
     */
    public function getOrdersByUser( $userid, $fields, $page, $pagesize );
}
?>