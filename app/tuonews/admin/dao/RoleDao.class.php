<?php

namespace admin\dao;

use admin\dao\interfaces\IRoleDao;
use common\dao\CommonDao;
use herosphp\core\Loader;

Loader::import('admin.dao.interfaces.IRoleDao');
Loader::import('common.dao.CommonDao');

/**
 * 后台管理员角色接口实现
 * Class RoleDao
 * @package admin\dao
 * @author yangjian102621@163.com
 */
class RoleDao extends CommonDao implements IRoleDao {}

?>