<?php
/**
 * 文章视图Model
 * @author  yangjian <yangjian102621@163.com>
 */

namespace models;

use herosphp\core\Loader;
use herosphp\model\C_Model;

Loader::import('filter.Filter', IMPORT_FRAME);

class ArticleViewModel extends C_Model {

    public function __construct() {

        parent::__construct('article_view');
        $this->setPrimaryKey('id');

    }
} 