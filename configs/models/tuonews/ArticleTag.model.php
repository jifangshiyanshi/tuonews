<?php
/**
 * 文章标签Model
 * @author  yangjian <yangjian102621@163.com>
 */

namespace models;

use herosphp\model\C_Model;

class ArticleTagModel extends C_Model {

    public function __construct() {

        parent::__construct('article_tags');
        $this->setPrimaryKey('id');
    }
} 