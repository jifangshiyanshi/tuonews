<?php
/**
 * 用户Model
 * @author  yangjian <yangjian102621@163.com>
 */

namespace models;

use herosphp\core\Loader;
use herosphp\model\C_Model;

Loader::import('filter.Filter', IMPORT_FRAME);

class UserModel extends C_Model {

    public function __construct() {

        parent::__construct('user');
        $this->setPrimaryKey('id');

        //初始化数据模型过滤器
        $filterMap = array(
            'username' => array(DFILTER_REGEXP, '/^[a-z|0-9]{4,20}$/i', null, '用户名'),
            'email' => array(DFILTER_EMAIL, null, DFILTER_SANITIZE_TRIM, '邮箱'),
            'mobile' => array(DFILTER_MOBILE, null, DFILTER_SANITIZE_TRIM, '手机号码'),
            'id_code' => array(DFILTER_IDENTIRY, null, DFILTER_SANITIZE_TRIM, '身份证号码'),
        );
        $this->setFilterMap($filterMap);
    }
} 