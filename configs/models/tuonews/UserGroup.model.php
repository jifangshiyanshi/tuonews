<?php
/**
 * 用户分组Model
 * @author  yangjian <yangjian102621@163.com>
 */

namespace models;

use herosphp\core\Loader;
use herosphp\model\C_Model;

Loader::import('filter.Filter', IMPORT_FRAME);

class UserGroupModel extends C_Model {

    public function __construct() {

        parent::__construct('user_group');
        $this->setPrimaryKey('id');

        //初始化数据模型过滤器
        $filterMap = array(
            'name' => array(DFILTER_STRING, array(1, 20), DFILTER_SANITIZE_TRIM, '分组名称'),
            'mark' => array(DFILTER_NUMERIC, null, DFILTER_SANITIZE_INT, '分组标识'),
            'summary' => array(DFILTER_STRING, array(0, 60), DFILTER_MAGIC_QUOTES | DFILTER_SANITIZE_TRIM, '会员分组简介'),
        );
        $this->setFilterMap($filterMap);
    }
} 