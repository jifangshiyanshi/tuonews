<?php
/**
 * 用户收藏Model
 * @author  yangjian <yangjian102621@163.com>
 */

namespace models;

use herosphp\core\Loader;
use herosphp\model\C_Model;

Loader::import('filter.Filter', IMPORT_FRAME);

class UserCollectModel extends C_Model {

    public function __construct() {

        parent::__construct('user_collection');
        $this->setPrimaryKey('id');
    }
} 