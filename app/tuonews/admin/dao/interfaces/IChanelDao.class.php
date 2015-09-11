<?php

namespace admin\dao\interfaces;
use common\dao\interfaces\ICommonDao;
use herosphp\core\Loader;

Loader::import("common.dao.interfaces.ICommonDao", IMPORT_APP);
/**
 * 系统频道接口
 * Interface IChanelDao
 * @package admin\dao\interfaces
 * @author yangjian102621@163.com
 */
interface IChanelDao extends ICommonDao {}