<?php
/**
 * 系统保留关键字Model
 * @author  wangyanjun
 */

namespace models;

use herosphp\core\Loader;
use herosphp\model\C_Model;

Loader::import('filter.Filter', IMPORT_FRAME);

class KeywordsModel extends C_Model {

    public function __construct() {

        parent::__construct('keywords');
        $this->setPrimaryKey('id');

        //初始化数据模型过滤器
        $filterMap = array(
            'name' => array(DFILTER_STRING, array(4, 20), DFILTER_MAGIC_QUOTES, '保留字'),
        );
        $this->setFilterMap($filterMap);
    }
}
