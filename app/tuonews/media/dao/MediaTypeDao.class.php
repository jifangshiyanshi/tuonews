<?php

namespace media\dao;

use common\dao\CommonDao;
use herosphp\core\Loader;
use media\dao\interfaces\IMediaTypeDao;

Loader::import('media.dao.interfaces.IMediaTypeDao');
Loader::import('common.dao.CommonDao');

/**
 * 媒体类型(DAO)接口实现
 * Class MediaTypeDao
 * @package media\dao
 * @author yangjian102621@163.com
 */
class MediaTypeDao extends CommonDao implements IMediaTypeDao {}