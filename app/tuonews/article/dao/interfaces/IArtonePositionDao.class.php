<?php

namespace article\dao\interfaces;

use common\dao\interfaces\ICommonDao;
use herosphp\core\Loader;

Loader::import("common.dao.interfaces.ICommonDao", IMPORT_APP);
/**
 * 单文章位置(DAO)接口
 * Interface IArtonePositionDao
 * @package article\dao\interfaces
 * @author yangjian102621@163.com
 */
interface IArtonePositionDao extends ICommonDao {}