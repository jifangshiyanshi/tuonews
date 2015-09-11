<?php

namespace article\dao;

use article\dao\interfaces\IArticleTagOrderDao;
use common\dao\CommonDao;
use herosphp\core\Loader;

Loader::import('article.dao.interfaces.IArticleTagOrderDao');
Loader::import('common.dao.CommonDao');

/**
 * 文章标签订阅(DAO)接口实现
 * Class ArticleTagOrderDao
 * @package article\dao
 * @author yangjian102621@163.com
 */
class ArticleTagOrderDao extends CommonDao implements IArticleTagOrderDao {}

?>