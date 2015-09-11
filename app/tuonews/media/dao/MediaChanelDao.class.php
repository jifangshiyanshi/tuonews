<?php

namespace media\dao;

use common\dao\CommonDao;
use herosphp\core\Loader;
use media\dao\interfaces\IMediaChanelDao;

Loader::import('media.dao.interfaces.IMediaChanelDao');
Loader::import('common.dao.CommonDao');

/**
 * 媒体频道(DAO)接口实现
 * Class MediaChanelDao
 * @package media\dao
 * @author yangjian102621@163.com
 */
class MediaChanelDao extends CommonDao implements IMediaChanelDao {}