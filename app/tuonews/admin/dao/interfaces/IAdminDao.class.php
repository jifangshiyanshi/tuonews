<?php

namespace admin\dao\interfaces;
use common\dao\interfaces\ICommonDao;
use herosphp\core\Loader;

Loader::import("common.dao.interfaces.ICommonDao", IMPORT_APP);
/**
 * admin(DAO)接口
 * Interface IAdminDao
 * @package admin\dao\interfaces
 * @author yangjian102621@163.com
 */
interface IAdminDao extends ICommonDao {}