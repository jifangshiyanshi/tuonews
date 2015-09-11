<?php

namespace article\dao\interfaces;
use common\dao\interfaces\ICommonDao;
use herosphp\core\Loader;

Loader::import("common.dao.interfaces.ICommonDao", IMPORT_APP);
/**
 * 文章标签(DAO)接口
 * Interface IArticleTagDao
 * @package article\dao\interfaces
 * @author yangjian102621@163.com
 */
interface IArticleTagDao extends ICommonDao {}