<?php
/**
 * 单文章显示位置Model
 * @author  yangjian <yangjian102621@163.com>
 */

namespace models;

use herosphp\model\C_Model;

class ArtonePositionModel extends C_Model {

    public function __construct() {

        parent::__construct('artone_position');
        $this->setPrimaryKey('id');

        //初始化数据模型过滤器
        $filterMap = array(
            'name' => array(DFILTER_STRING, array(1, 20), DFILTER_SANITIZE_TRIM, '位置名称'),
            'position' => array(DFILTER_STRING, array(1, 20), DFILTER_SANITIZE_TRIM, '位置key'),
        );
        $this->setFilterMap($filterMap);
    }
} 