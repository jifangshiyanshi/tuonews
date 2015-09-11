<?php
/**
 * 图片空间表数据模型操作类，继承模型基类
 * @author  yangjian <yangjian102621@163.com>
 */

namespace models;

use herosphp\core\Loader;
use herosphp\model\C_Model;

Loader::import('filter.Filter', IMPORT_FRAME);

class ImageModel extends C_Model {

    public function __construct() {

        parent::__construct('image');
        $this->setPrimaryKey('id');

    }
} 