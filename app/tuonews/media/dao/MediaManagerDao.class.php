<?php

namespace media\dao;

use common\dao\CommonDao;
use herosphp\core\Loader;
use media\dao\interfaces\IMediaManagerDao;

Loader::import('media.dao.interfaces.IMediaManagerDao');
Loader::import('common.dao.CommonDao');

/**
 * 媒体管理员(DAO)接口实现
 * Class MediaManagerDao
 * @package media\dao
 * @author yangjian102621@163.com
 */
class MediaManagerDao extends CommonDao implements IMediaManagerDao {}