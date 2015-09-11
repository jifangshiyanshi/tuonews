<?php

namespace admin\dao\interfaces;
use common\dao\interfaces\ICommonDao;
use herosphp\core\Loader;

Loader::import("common.dao.interfaces.ICommonDao", IMPORT_APP);
/**
 * 系统友情链接dao接口
 * Interface IFriendLinkDao
 * @package admin\dao\interfaces
 * @author yangjian102621@163.com
 */
interface IFriendLinkDao extends ICommonDao {}