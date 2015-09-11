<?php
/**
 * 媒体类型Model
 * @author  yangjian <yangjian102621@163.com>
 */

namespace models;

use herosphp\core\Loader;
use herosphp\model\C_Model;

Loader::import('filter.Filter', IMPORT_FRAME);

class MediaTypeModel extends C_Model {

    public function __construct() {

        parent::__construct('media_type');
        $this->setPrimaryKey('id');

        //初始化数据模型过滤器
        $filterMap = array(
            'name' => array(DFILTER_STRING, array(1, 10), DFILTER_SANITIZE_TRIM, '类型名称'),
            'summary' => array(DFILTER_STRING, array(1, 100), DFILTER_SANITIZE_TRIM, '媒体类型说明'),
            'sort_num' => array(DFILTER_NUMERIC, null, DFILTER_SANITIZE_INT, '排序'),
        );
        $this->setFilterMap($filterMap);
    }
} 