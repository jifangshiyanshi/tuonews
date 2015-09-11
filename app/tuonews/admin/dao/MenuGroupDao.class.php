<?php

namespace admin\dao;

use admin\dao\interfaces\IMenuGroupDao;
use common\dao\CommonDao;
use herosphp\core\Loader;

Loader::import('admin.dao.interfaces.IMenuGroupDao');
Loader::import('common.dao.CommonDao');

/**
 * 后台菜单分组dao接口实现
 * Class MenuGroupDao
 * @package admin\dao
 * @author yangjian102621@163.com
 */
class MenuGroupDao extends CommonDao implements IMenuGroupDao {}

?>