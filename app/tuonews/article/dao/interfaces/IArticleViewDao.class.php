<?php

namespace article\dao\interfaces;
use common\dao\interfaces\ICommonDao;
use herosphp\core\Loader;

Loader::import("common.dao.interfaces.ICommonDao", IMPORT_APP);
/**
 * 文章视图(DAO)接口
 * Interface IArticleViewDao
 * @package article\dao\interfaces
 * @author yangjian102621@163.com
 */
interface IArticleViewDao extends ICommonDao {}