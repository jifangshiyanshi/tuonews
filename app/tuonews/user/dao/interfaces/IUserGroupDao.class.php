<?php

namespace user\dao\interfaces;
use common\dao\interfaces\ICommonDao;
use herosphp\core\Loader;

Loader::import("common.dao.interfaces.ICommonDao", IMPORT_APP);
/**
 * 用户分组(DAO)接口
 * Interface IUserGroupDao
 * @package user\dao\interfaces
 * @author yangjian102621@163.com
 */
interface IUserGroupDao extends ICommonDao {}