<?php
/**
 * 加博会Model
 */

namespace models;

use herosphp\core\Loader;
use herosphp\model\C_Model;

Loader::import('filter.Filter', IMPORT_FRAME);

class JiaboModel extends C_Model {

    public function __construct() {

        parent::__construct('jiabo');
        $this->setPrimaryKey('id');
    }
}
