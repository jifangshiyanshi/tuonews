<?php
/**
 * 媒体友情链接表Model
 * @author  yangjian <yangjian102621@163.com>
 */

namespace models;

use herosphp\core\Loader;
use herosphp\model\C_Model;

Loader::import('filter.Filter', IMPORT_FRAME);

class MediaFriendLinkModel extends C_Model {

    public function __construct() {

        parent::__construct('media_friendlink');
        $this->setPrimaryKey('id');

        //初始化数据模型过滤器
        $filterMap = array(
            'name' => array(DFILTER_STRING, array(1, 20), DFILTER_SANITIZE_TRIM, '链接名称'),
            'url' => array(DFILTER_URL, array(1, 160), DFILTER_SANITIZE_TRIM, '链接url'),
            'sort_num' => array(DFILTER_NUMERIC, null, DFILTER_SANITIZE_INT, '排序'),
        );
        $this->setFilterMap($filterMap);
    }
} 