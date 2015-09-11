<?php
/**
 * 用户数据表Model
 * @author  yangjian <yangjian102621@163.com>
 */

namespace models;

use herosphp\core\Loader;
use herosphp\model\C_Model;

Loader::import('filter.Filter', IMPORT_FRAME);

class UserDataModel extends C_Model {

    public function __construct() {

        parent::__construct('user_data');
        $this->setPrimaryKey('userid');

        //初始化数据模型过滤器
        $filterMap = array(
            'check_note' => array(DFILTER_STRING, array(0, 255), DFILTER_MAGIC_QUOTES, '审核备注'),
            'intro' => array(null, null, DFILTER_MAGIC_QUOTES, '用户简介'),
        );
        $this->setFilterMap($filterMap);
    }
} 