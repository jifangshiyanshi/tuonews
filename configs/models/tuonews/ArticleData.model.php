<?php
/**
 * 博客文章内容数据模型
 * @author  yangjian <yangjian102621@163.com>
 */

namespace models;

use herosphp\core\Loader;
use herosphp\model\C_Model;

Loader::import('filter.Filter', IMPORT_FRAME);

class ArticleDataModel extends C_Model {

    public function __construct() {

        parent::__construct('article_data_0');
        $this->setPrimaryKey('aid');

        //设置多表映射
        $this->setTableMapping(array(
            'article_data_0',
            'article_data_1',
            'article_data_2',
            'article_data_3',
        ));

        //初始化数据模型过滤器
        $filterMap = array(
            'content' => array(null, null, DFILTER_MAGIC_QUOTES, '文章详情'),
        );
        $this->setFilterMap($filterMap);

    }
} 