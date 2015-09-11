<?php

namespace admin\dao;

use admin\dao\interfaces\IMenuDao;
use common\dao\CommonDao;
use herosphp\core\Loader;

Loader::import('admin.dao.interfaces.IMenuDao');
Loader::import('common.dao.CommonDao');

/**
 * 后台菜单分组dao接口实现
 * Class MenuDao
 * @package admin\dao
 * @author yangjian102621@163.com
 */
class MenuDao extends CommonDao implements IMenuDao {}

?>