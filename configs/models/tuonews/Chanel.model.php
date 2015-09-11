<?php
/**
 * 系统频道model
 * @author  yangjian <yangjian102621@163.com>
 */

namespace models;

use herosphp\core\Loader;
use herosphp\model\C_Model;

Loader::import('filter.Filter', IMPORT_FRAME);

class ChanelModel extends C_Model {

    public function __construct() {

        parent::__construct('chanel');
        $this->setPrimaryKey('id');

        //初始化数据模型过滤器
        $filterMap = array(
            'name' => array(null, array(0, 10), null, '频道名称'),
            'seo_title' => array(null, array(0, 100), null, 'seo标题'),
            'seo_kword' => array(null, array(0, 100), null, 'seo关键子'),
            'seo_desc' => array(null, array(0, 150), null, 'seo描述'),
            'sort_num' => array(DFILTER_NUMERIC, null, DFILTER_SANITIZE_INT, '排序数字'),
        );
        $this->setFilterMap($filterMap);
    }
} 