<?php

namespace media\dao;

use common\dao\CommonDao;
use herosphp\core\Loader;
use media\dao\interfaces\IMediaFriendLinkDao;

Loader::import('media.dao.interfaces.IMediaFriendLinkDao');
Loader::import('common.dao.CommonDao');

/**
 * 媒体友情链接(DAO)接口实现
 * Class MediaFriendLinkDao
 * @package media\dao
 * @author yangjian102621@163.com
 */
class MediaFriendLinkDao extends CommonDao implements IMediaFriendLinkDao {}