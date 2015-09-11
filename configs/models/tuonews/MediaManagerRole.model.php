<?php
/**
 * 媒体管理员角色Model
 * @author  yangjian <yangjian102621@163.com>
 */

namespace models;

use herosphp\core\Loader;
use herosphp\model\C_Model;

Loader::import('filter.Filter', IMPORT_FRAME);

class MediaManagerRoleModel extends C_Model {

    public function __construct() {

        parent::__construct('media_manager_role');
        $this->setPrimaryKey('id');

        //初始化数据模型过滤器
        $filterMap = array(
            'name' => array(DFILTER_STRING, array(1, 20), DFILTER_SANITIZE_TRIM, '角色名称'),
        );
        $this->setFilterMap($filterMap);

    }
} 