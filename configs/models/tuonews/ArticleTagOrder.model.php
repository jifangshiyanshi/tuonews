<?php
/**
 * 文章标签订阅Model
 * @author  yangjian <yangjian102621@163.com>
 */

namespace models;

use herosphp\model\C_Model;

class ArticleTagOrderModel extends C_Model {

    public function __construct() {

        parent::__construct('article_tags_order');
        $this->setPrimaryKey('id');
    }
} 