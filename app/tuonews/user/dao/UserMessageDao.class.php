<?php

namespace user\dao;

use common\dao\CommonDao;
use herosphp\core\Loader;
use user\dao\interfaces\IUserMessageDao;

Loader::import('user.dao.interfaces.IUserMessageDao');
Loader::import('common.dao.CommonDao');

/**
 * 用户站内信(DAO)接口实现
 * Class UserMessageDao
 * @package user\dao
 * @author yangjian102621@163.com
 */
class UserMessageDao extends CommonDao implements IUserMessageDao {}

?>