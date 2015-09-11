<?php
/**
 * 后台管理菜单分组数据模型
 * @author  yangjian <yangjian102621@163.com>
 */

namespace models;

use herosphp\core\Loader;
use herosphp\model\C_Model;

Loader::import('filter.Filter', IMPORT_FRAME);

class AdminMenuGroupModel extends C_Model {

    public function __construct() {

        parent::__construct('admin_menu_group');
        $this->setPrimaryKey('id');

        //初始化数据模型过滤器
        $filterMap = array(
            'name' => array(null, array(0, 20), null, '分组名称'),
            'icon' => array(null, array(0, 16), null, '分组图标'),
            'sort_num' => array(DFILTER_NUMERIC, null, DFILTER_SANITIZE_INT, '排序数字'),
        );
        $this->setFilterMap($filterMap);
    }
} 