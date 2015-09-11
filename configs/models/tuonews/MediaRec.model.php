<?php
/**
 * 媒体推荐位Model
 * @author  yangjian <yangjian102621@163.com>
 */

namespace models;

use herosphp\core\Loader;
use herosphp\model\C_Model;

Loader::import('filter.Filter', IMPORT_FRAME);

class MediaRecModel extends C_Model {

    public function __construct() {

        parent::__construct('media_rec');
        $this->setPrimaryKey('id');

        //初始化数据模型过滤器
        $filterMap = array(
            'name' => array(DFILTER_STRING, array(1, 20), DFILTER_SANITIZE_TRIM, '推荐位名称'),
            'position' => array(DFILTER_STRING, array(1, 30), DFILTER_SANITIZE_TRIM, '推荐位置key'),
            'sort_num' => array(DFILTER_NUMERIC, null, DFILTER_SANITIZE_INT, '排序'),
        );
        $this->setFilterMap($filterMap);
    }
} 