<?php

namespace user\dao;

use common\dao\CommonDao;
use herosphp\core\Loader;
use user\dao\interfaces\IUserGroupDao;

Loader::import('user.dao.interfaces.IUserGroupDao');
Loader::import('common.dao.CommonDao');

/**
 * 用户分组(DAO)接口实现
 * Class UserGroupDao
 * @package user\dao
 * @author yangjian102621@163.com
 */
class UserGroupDao extends CommonDao implements IUserGroupDao {}

?>