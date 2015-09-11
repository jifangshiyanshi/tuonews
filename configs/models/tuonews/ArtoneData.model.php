<?php
/**
 * 单文章数据Model
 * @author  yangjian <yangjian102621@163.com>
 */

namespace models;

use herosphp\model\C_Model;

class ArtoneDataModel extends C_Model {

    public function __construct() {

        parent::__construct('artone_data');
        $this->setPrimaryKey('id');

        //初始化数据模型过滤器
        $filterMap = array(
            'content' => array(null, null, DFILTER_MAGIC_QUOTES, '文章详情'),
        );
        $this->setFilterMap($filterMap);
    }
} 