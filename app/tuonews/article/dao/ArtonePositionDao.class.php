<?php

namespace article\dao;

use article\dao\interfaces\IArtonePositionDao;
use common\dao\CommonDao;
use herosphp\core\Loader;

Loader::import('article.dao.interfaces.IArtonePositionDao');
Loader::import('common.dao.CommonDao');

/**
 * 单文章位置(DAO)接口实现
 * Class ArtonePositionDao
 * @package article\dao
 * @author yangjian102621@163.com
 */
class ArtonePositionDao extends CommonDao implements IArtonePositionDao {}

?>