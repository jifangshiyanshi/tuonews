<?php
/**
 * 用户短消息Model
 * @author  yangjian <yangjian102621@163.com>
 */

namespace models;

use herosphp\core\Loader;
use herosphp\model\C_Model;

Loader::import('filter.Filter', IMPORT_FRAME);

class UserMessageModel extends C_Model {

    public function __construct() {

        parent::__construct('user_message');
        $this->setPrimaryKey('id');

        //初始化数据模型过滤器
        $filterMap = array(
            'content' => array(DFILTER_STRING, array(0, 500), DFILTER_MAGIC_QUOTES | DFILTER_SANITIZE_TRIM, '短消息内容'),
        );
        $this->setFilterMap($filterMap);
    }
} 