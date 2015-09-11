<?php

namespace article\dao;

use article\dao\interfaces\IArticleViewDao;
use common\dao\CommonDao;
use herosphp\core\Loader;

Loader::import('article.dao.interfaces.IArticleViewDao');
Loader::import('common.dao.CommonDao');

/**
 * 文章视图(DAO)接口实现
 * Class ArticleViewDao
 * @package article\dao
 * @author yangjian102621@163.com
 */
class ArticleViewDao extends CommonDao implements IArticleViewDao {}

?>