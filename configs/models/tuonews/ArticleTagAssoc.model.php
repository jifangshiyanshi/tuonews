<?php
/**
 * 文章标签关联表Model
 * @author  yangjian <yangjian102621@163.com>
 */

namespace models;

use herosphp\model\C_Model;

class ArticleTagAssocModel extends C_Model {

    public function __construct() {

        parent::__construct('article_tags_assoc');
        $this->setPrimaryKey('id');
    }
} 