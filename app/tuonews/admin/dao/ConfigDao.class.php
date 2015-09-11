<?php

namespace admin\dao;

use admin\dao\interfaces\IConfigDao;
use common\dao\CommonDao;
use herosphp\core\Loader;

Loader::import('admin.dao.interfaces.IConfigDao');
Loader::import('common.dao.CommonDao');

/**
 * 系统配置(DAO)接口实现
 * Class CommonDao
 * @package common\dao
 * @author yangjian102621@163.com
 */
class ConfigDao extends CommonDao implements IConfigDao {}

?>