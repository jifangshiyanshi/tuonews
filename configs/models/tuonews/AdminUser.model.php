<?php
/**
 * admin表数据模型操作类，继承模型基类
 * @author  yangjian <yangjian102621@163.com>
 */

namespace models;

use herosphp\core\Loader;
use herosphp\model\C_Model;

Loader::import('filter.Filter', IMPORT_FRAME);

class AdminUserModel extends C_Model {

    public function __construct() {

        parent::__construct('admin_user');
        $this->setPrimaryKey('id');

        //初始化数据模型过滤器
        $filterMap = array(
            'username' => array(DFILTER_STRING, array(3, 20), DFILTER_MAGIC_QUOTES, '用户名'),
            'summary' => array(DFILTER_STRING, null, DFILTER_SANITIZE_HTML|DFILTER_MAGIC_QUOTES, '简介')
        );
        $this->setFilterMap($filterMap);
    }
} 