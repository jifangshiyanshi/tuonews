<?php

namespace article\dao\interfaces;
use common\dao\interfaces\ICommonDao;
use herosphp\core\Loader;

Loader::import("common.dao.interfaces.ICommonDao", IMPORT_APP);
/**
 * 单文章(DAO)接口
 * Interface IArticleDao
 * @package article\dao\interfaces
 * @author yangjian102621@163.com
 */
interface IArtoneDao extends ICommonDao {}