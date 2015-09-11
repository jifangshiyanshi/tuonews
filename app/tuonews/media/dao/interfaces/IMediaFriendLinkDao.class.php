<?php

namespace media\dao\interfaces;
use common\dao\interfaces\ICommonDao;
use herosphp\core\Loader;

Loader::import("common.dao.interfaces.ICommonDao", IMPORT_APP);
/**
 * 媒体友情链接(DAO)接口
 * Interface IMediaFriendLinkDao
 * @package media\dao\interfaces
 * @author yangjian102621@163.com
 */
interface IMediaFriendLinkDao extends ICommonDao {}