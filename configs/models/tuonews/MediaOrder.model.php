<?php
/**
 * 媒体订阅Model
 * @author  yangjian <yangjian102621@163.com>
 */

namespace models;

use herosphp\core\Loader;
use herosphp\model\C_Model;

Loader::import('filter.Filter', IMPORT_FRAME);

class MediaOrderModel extends C_Model {

    public function __construct() {

        parent::__construct('media_order');
        $this->setPrimaryKey('id');

    }
} 