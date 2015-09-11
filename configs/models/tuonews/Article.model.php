<?php
/**
 * 文章基本信息Model
 * @author  yangjian <yangjian102621@163.com>
 */

namespace models;

use herosphp\core\Loader;
use herosphp\model\C_Model;

Loader::import('filter.Filter', IMPORT_FRAME);

class ArticleModel extends C_Model {

    public function __construct() {

        parent::__construct('article');
        $this->setPrimaryKey('id');

        //初始化数据模型过滤器
        $filterMap = array(
            'title' => array(DFILTER_STRING, array(4, 30), DFILTER_MAGIC_QUOTES, '文章标题'),
            'kwords' => array(null, array(0,150), DFILTER_SANITIZE_HTML|DFILTER_MAGIC_QUOTES, '文章关键字'),
            'bcontent' => array(null, array(0, 150), DFILTER_SANITIZE_HTML|DFILTER_MAGIC_QUOTES, '文章简介'),
            'author' => array(null, array(0, 10), DFILTER_SANITIZE_TRIM, '文章作者'),
            'source' => array(null, array(0, 16), DFILTER_SANITIZE_TRIM, '文章来源'),
        );
        $this->setFilterMap($filterMap);
    }
}
