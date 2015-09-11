<?php

namespace media\dao;

use common\dao\CommonDao;
use herosphp\core\Loader;
use media\dao\interfaces\IMediaRecDao;

Loader::import('media.dao.interfaces.IMediaRecDao');
Loader::import('common.dao.CommonDao');

/**
 * 媒体推荐位(DAO)接口实现
 * Class MediaRecDao
 * @package media\dao
 * @author yangjian102621@163.com
 */
class MediaRecDao extends CommonDao implements IMediaRecDao {}