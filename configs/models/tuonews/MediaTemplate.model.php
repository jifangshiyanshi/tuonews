<?php
/**
 * 媒体模板关联数据Model
 * @author  yangjian <yangjian102621@163.com>
 */

namespace models;

use herosphp\core\Loader;
use herosphp\model\C_Model;

Loader::import('filter.Filter', IMPORT_FRAME);

class MediaTemplateModel extends C_Model {

    public function __construct() {

        parent::__construct('media_template');
        $this->setPrimaryKey('id');

    }
} 