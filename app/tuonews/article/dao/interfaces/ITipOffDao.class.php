<?php

namespace article\dao\interfaces;
use common\dao\interfaces\ICommonDao;
use herosphp\core\Loader;

Loader::import("common.dao.interfaces.ICommonDao", IMPORT_APP);
/**
 * 用户爆料(DAO)接口
 * Interface ITipOffDao
 * @package article\dao\interfaces
 * @author yangjian102621@163.com
 */
interface ITipOffDao extends ICommonDao {}