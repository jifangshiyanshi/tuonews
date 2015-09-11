<?php
/**
 * 媒体频道表Model
 * @author  yangjian <yangjian102621@163.com>
 */

namespace models;

use herosphp\core\Loader;
use herosphp\model\C_Model;

Loader::import('filter.Filter', IMPORT_FRAME);

class MediaChanelModel extends C_Model {

    public function __construct() {

        parent::__construct('media_chanel');
        $this->setPrimaryKey('id');

        //初始化数据模型过滤器
        $filterMap = array(
            'name' => array(DFILTER_STRING, array(1, 20), DFILTER_SANITIZE_TRIM, '频道名称'),
            'seo_title' => array(DFILTER_STRING, array(1, 100), DFILTER_SANITIZE_TRIM, 'seo标题'),
            'seo_kword' => array(DFILTER_STRING, array(1, 100), DFILTER_SANITIZE_TRIM|DFILTER_MAGIC_QUOTES, 'seo关键字'),
            'seo_desc' => array(DFILTER_STRING, array(1, 255), DFILTER_SANITIZE_TRIM|DFILTER_MAGIC_QUOTES, 'seo描述'),
        );
        $this->setFilterMap($filterMap);
    }
} 