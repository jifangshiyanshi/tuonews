<?php
/**
 * 友情链接model
 * @author  yangjian <yangjian102621@163.com>
 */

namespace models;

use herosphp\core\Loader;
use herosphp\model\C_Model;

Loader::import('filter.Filter', IMPORT_FRAME);

class FriendLinkModel extends C_Model {

    public function __construct() {

        parent::__construct('friendlink');
        $this->setPrimaryKey('id');

        //初始化数据模型过滤器
        $filterMap = array(
            'name' => array(DFILTER_STRING, array(0, 10), null, '友情链接名称'),
            'url' => array(DFILTER_URL, array(0, 160), null, '链接地址'),
            'sort_num' => array(DFILTER_NUMERIC, null, DFILTER_SANITIZE_INT, '排序数字'),
        );
        $this->setFilterMap($filterMap);
    }
} 