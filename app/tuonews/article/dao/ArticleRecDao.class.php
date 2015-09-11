<?php

namespace article\dao;

use article\dao\interfaces\IArticleRecDao;
use common\dao\CommonDao;
use herosphp\core\Loader;

Loader::import('article.dao.interfaces.IArticleRecDao');
Loader::import('common.dao.CommonDao');

/**
 * 文章推荐位(DAO)接口实现
 * Class ArticleRecDao
 * @package article\dao
 * @author yangjian102621@163.com
 */
class ArticleRecDao extends CommonDao implements IArticleRecDao {}

?>