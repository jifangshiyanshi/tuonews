<?php
/**
 * 媒体用户data表Model
 * @author  yangjian <yangjian102621@163.com>
 */

namespace models;

use herosphp\core\Loader;
use herosphp\model\C_Model;

Loader::import('filter.Filter', IMPORT_FRAME);

class MediaDataModel extends C_Model {

    public function __construct() {

        parent::__construct('media_data');
        $this->setPrimaryKey('media_id');

        //初始化数据模型过滤器
        $filterMap = array(
            'configs' => array(null, null, DFILTER_MAGIC_QUOTES, '媒体网站配置信息'),
        );
        $this->setFilterMap($filterMap);
    }
} 