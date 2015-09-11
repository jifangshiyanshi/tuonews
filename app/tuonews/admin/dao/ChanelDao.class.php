<?php

namespace admin\dao;

use admin\dao\interfaces\IChanelDao;
use common\dao\CommonDao;
use herosphp\core\Loader;

Loader::import('admin.dao.interfaces.IChanelDao');
Loader::import('common.dao.CommonDao');

/**
 * 系统频道(DAO)接口实现
 * Class ChanelDao
 * @package admin\dao
 * @author yangjian102621@163.com
 */
class ChanelDao extends CommonDao implements IChanelDao {}

?>