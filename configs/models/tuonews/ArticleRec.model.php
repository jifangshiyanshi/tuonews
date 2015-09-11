<?php
/**
 * 文章推荐位置Model
 * @author  yangjian <yangjian102621@163.com>
 */

namespace models;

use herosphp\model\C_Model;

class ArticleRecModel extends C_Model {

    public function __construct() {

        parent::__construct('article_rec');
        $this->setPrimaryKey('id');

        //初始化数据模型过滤器
        $filterMap = array(
            'name' => array(DFILTER_STRING, array(0, 16), DFILTER_SANITIZE_TRIM, '推荐位名称'),
            'position' => array(DFILTER_STRING, array(0, 30), DFILTER_SANITIZE_TRIM, '推荐位key'),
            'sort_num' => array(DFILTER_NUMERIC, null, DFILTER_SANITIZE_INT, '排序数字'),
        );
        $this->setFilterMap($filterMap);
    }
} 