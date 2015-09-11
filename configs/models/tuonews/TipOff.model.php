<?php
/**
 * 用户爆料Model
 * @author  yangjian <yangjian102621@163.com>
 */

namespace models;

use herosphp\model\C_Model;

class TipOffModel extends C_Model {

    public function __construct() {

        parent::__construct('tipoff');
        $this->setPrimaryKey('id');

        //初始化数据模型过滤器
        $filterMap = array(
            'contact' => array(DFILTER_STRING, array(0, 30), DFILTER_SANITIZE_TRIM, '联系方式'),
            'content' => array(DFILTER_STRING, array(0, 500), DFILTER_MAGIC_QUOTES, '爆料内容'),
        );
        $this->setFilterMap($filterMap);
    }
} 