<?php
/**
 * 模板Model
 * @author  yangjian <yangjian102621@163.com>
 */

namespace models;

use herosphp\core\Loader;
use herosphp\model\C_Model;

Loader::import('filter.Filter', IMPORT_FRAME);

class TemplateModel extends C_Model {

    public function __construct() {

        parent::__construct('template');
        $this->setPrimaryKey('id');

        //初始化数据模型过滤器
        $filterMap = array(
            'name' => array(DFILTER_STRING, array(0, 20), null, '模板名称'),
            'change_notes' => array(DFILTER_STRING, array(1, 255), null, '版本更新说明'),
            'sdesc' => array(DFILTER_STRING, array(1, 255), null, '模板描述'),
        );
        $this->setFilterMap($filterMap);
    }
} 