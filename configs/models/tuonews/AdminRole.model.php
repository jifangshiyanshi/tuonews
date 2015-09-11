<?php
/**
 * 管理员角色数据模型
 * @author  yangjian <yangjian102621@163.com>
 */

namespace models;

use herosphp\core\Loader;
use herosphp\model\C_Model;

Loader::import('filter.Filter', IMPORT_FRAME);

class AdminRoleModel extends C_Model {

    public function __construct() {

        parent::__construct('admin_role');
        $this->setPrimaryKey('id');

        //初始化数据模型过滤器
        $filterMap = array(
            'name' => array(DFILTER_STRING, array(0, 20), DFILTER_MAGIC_QUOTES, '用户名'),
            'summary' => array(DFILTER_STRING, array(0, 100), DFILTER_SANITIZE_HTML|DFILTER_MAGIC_QUOTES, '简介'),
            'sort_num' => array(DFILTER_NUMERIC, null, DFILTER_SANITIZE_INT, '排序数字'),
        );
        $this->setFilterMap($filterMap);
    }
} 