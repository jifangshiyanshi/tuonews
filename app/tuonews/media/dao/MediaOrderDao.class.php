<?php

namespace media\dao;

use common\dao\CommonDao;
use herosphp\core\Loader;
use media\dao\interfaces\IMediaOrderDao;

Loader::import('media.dao.interfaces.IMediaOrderDao');
Loader::import('common.dao.CommonDao');

/**
 * 媒体订阅(DAO)接口实现
 * Class MediaOrderDao
 * @package media\dao
 * @author yangjian102621@163.com
 */
class MediaOrderDao extends CommonDao implements IMediaOrderDao {}