<?php
/**
 * 消息模板数据模型
 * @author  yangjian <yangjian102621@163.com>
 */

namespace models;

use herosphp\core\Loader;
use herosphp\model\C_Model;

Loader::import('filter.Filter', IMPORT_FRAME);

class MessageTemplateModel extends C_Model {

    public function __construct() {

        parent::__construct('message_template');
        $this->setPrimaryKey('id');

        //初始化数据模型过滤器
        $filterMap = array(
            'name' => array(null, array(0, 20), null, '模板名称'),
            'content' => array(null, null, DFILTER_MAGIC_QUOTES, '模板内容'),
            'sort_num' => array(DFILTER_NUMERIC, null, DFILTER_SANITIZE_INT, '排序数字'),
        );
        $this->setFilterMap($filterMap);
    }
} 