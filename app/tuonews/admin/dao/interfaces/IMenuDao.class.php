<?php

namespace admin\dao\interfaces;
use common\dao\interfaces\ICommonDao;
use herosphp\core\Loader;

Loader::import("common.dao.interfaces.ICommonDao", IMPORT_APP);
/**
 * 后台菜单dao接口
 * Interface IMenuDao
 * @package admin\dao\interfaces
 * @author yangjian102621@163.com
 */
interface IMenuDao extends ICommonDao {}