<?php
/**
 * 媒体管理员Model
 * @author  yangjian <yangjian102621@163.com>
 */

namespace models;

use herosphp\core\Loader;
use herosphp\model\C_Model;

Loader::import('filter.Filter', IMPORT_FRAME);

class MediaManagerModel extends C_Model {

    public function __construct() {

        parent::__construct('media_manager');
        $this->setPrimaryKey('id');

        //初始化数据模型过滤器
        $filterMap = array(
            'email' => array(DFILTER_EMAIL, array(1,30), DFILTER_SANITIZE_TRIM, '电子邮箱'),
        );
        $this->setFilterMap($filterMap);
    }
}
