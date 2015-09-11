<?php

namespace user\dao;

use common\dao\CommonDao;
use herosphp\core\Loader;
use user\dao\interfaces\IUserCollectDao;

Loader::import('user.dao.interfaces.IUserCollectDao');
Loader::import('common.dao.CommonDao');

/**
 * 用户收藏(DAO)接口实现
 * Class UserCollectDao
 * @package user\dao
 * @author yangjian102621@163.com
 */
class UserCollectDao extends CommonDao implements IUserCollectDao {}

?>