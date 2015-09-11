<?php

namespace media\dao;

use common\dao\CommonDao;
use herosphp\core\Loader;
use media\dao\interfaces\IMediaManagerRoleDao;

Loader::import('media.dao.interfaces.IMediaManagerRoleDao');
Loader::import('common.dao.CommonDao');

/**
 * 媒体类型(DAO)接口实现
 * Class MediaManagerRoleDao
 * @package media\dao
 * @author yangjian102621@163.com
 */
class MediaManagerRoleDao extends CommonDao implements IMediaManagerRoleDao {}