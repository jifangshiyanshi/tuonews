<?php
/**
 * 系统配置数据模型
 * @author  yangjian <yangjian102621@163.com>
 */

namespace models;

use herosphp\model\C_Model;

class ConfigModel extends C_Model {

    public function __construct() {

        parent::__construct('config');
        $this->setPrimaryKey('id');
    }
} 