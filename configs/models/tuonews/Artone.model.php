<?php
/**
 * 单文章Model
 * @author  yangjian <yangjian102621@163.com>
 */

namespace models;

use herosphp\model\C_Model;

class ArtoneModel extends C_Model {

    public function __construct() {

        parent::__construct('artone');
        $this->setPrimaryKey('id');

        //初始化数据模型过滤器
        $filterMap = array(
            'title' => array(DFILTER_STRING, array(0, 30), DFILTER_SANITIZE_TRIM, '文章标题'),
            'kwords' => array(DFILTER_STRING, array(0,60), DFILTER_SANITIZE_HTML|DFILTER_MAGIC_QUOTES, '文章关键字'),
            'bcontent' => array(DFILTER_STRING, array(0, 60), DFILTER_SANITIZE_HTML|DFILTER_MAGIC_QUOTES, '文章简介'),
            'sort_num' => array(null, null, DFILTER_SANITIZE_INT, '排序数字'),
        );
        $this->setFilterMap($filterMap);
    }
} 