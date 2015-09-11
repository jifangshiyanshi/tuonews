<?php

namespace admin\dao\interfaces;
use common\dao\interfaces\ICommonDao;
use herosphp\core\Loader;

Loader::import("common.dao.interfaces.ICommonDao", IMPORT_APP);
/**
 * 系统配置(DAO)接口
 * Interface IConfigDao
 * @package admin\dao\interfaces
 * @author yangjian102621@163.com
 */
interface IConfigDao extends ICommonDao {}