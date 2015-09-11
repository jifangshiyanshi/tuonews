<?php

namespace admin\dao;

use admin\dao\interfaces\IChanelDao;
use admin\dao\interfaces\IFriendLinkDao;
use common\dao\CommonDao;
use herosphp\core\Loader;

Loader::import('admin.dao.interfaces.IFriendLinkDao');
Loader::import('common.dao.CommonDao');

/**
 * 系统友情链接(DAO)接口实现
 * Class FriendLinkDao
 * @package admin\dao
 * @author yangjian102621@163.com
 */
class FriendLinkDao extends CommonDao implements IFriendLinkDao {}

?>