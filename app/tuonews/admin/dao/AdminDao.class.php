<?php

namespace admin\dao;

use admin\dao\interfaces\IAdminDao;
use common\dao\CommonDao;
use herosphp\core\Loader;

Loader::import('admin.dao.interfaces.IAdminDao');
Loader::import('common.dao.CommonDao');

/**
 * 管理员数据操作(DAO)接口实现
 * Class AdminDao
 * @package admin\dao
 * @author yangjian102621@163.com
 */
class AdminDao extends CommonDao implements IAdminDao {}

?>