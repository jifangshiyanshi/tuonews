<?php
/**
 * 后台管理菜单数据模型
 * @author  yangjian <yangjian102621@163.com>
 */

namespace models;

use herosphp\core\Loader;
use herosphp\model\C_Model;

Loader::import('filter.Filter', IMPORT_FRAME);

class AdminMenuModel extends C_Model {

    public function __construct() {

        parent::__construct('admin_menu');
        $this->setPrimaryKey('id');

        //初始化数据模型过滤器
        $filterMap = array(
            'name' => array(null, array(0, 10), null, '菜单名称'),
            'url' => array(null, array(0, 150), null, '菜单URL'),
            'sort_num' => array(DFILTER_NUMERIC, null, DFILTER_SANITIZE_INT, '排序数字'),
        );
        $this->setFilterMap($filterMap);
    }
} 