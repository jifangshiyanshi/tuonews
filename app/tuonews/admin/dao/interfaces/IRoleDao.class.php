<?php

namespace admin\dao\interfaces;
use common\dao\interfaces\ICommonDao;
use herosphp\core\Loader;

Loader::import("common.dao.interfaces.ICommonDao", IMPORT_APP);
/**
 * 管理员角色接口
 * Interface IRoleDao
 * @package admin\dao\interfaces
 * @author yangjian102621@163.com
 */
interface IRoleDao extends ICommonDao {}