<?php
/**
 * 测试模型Model
 * @author  yangjian <yangjian102621@163.com>
 */

namespace models;

use herosphp\core\Loader;
use herosphp\model\C_Model;

Loader::import('filter.Filter', IMPORT_FRAME);

class TestModel extends C_Model {

    public function __construct() {

        parent::__construct('test');
        $this->setPrimaryKey('id');

        //初始化数据模型过滤器
        $filterMap = array(
            'name' => array(DFILTER_STRING, array(1, 20), DFILTER_SANITIZE_TRIM, '名称'),
            'mobile' => array(DFILTER_MOBILE, array(1, 11), DFILTER_SANITIZE_TRIM, '手机'),
            'email' => array(DFILTER_EMAIL, array(0, 30), DFILTER_SANITIZE_TRIM, '邮箱'),
        );
        $this->setFilterMap($filterMap);
    }
} 