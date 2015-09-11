<?php

namespace media\dao\interfaces;
use common\dao\interfaces\ICommonDao;
use herosphp\core\Loader;

Loader::import("common.dao.interfaces.ICommonDao", IMPORT_APP);
/**
 * 媒体订阅(DAO)接口
 * Interface IMediaOrderDao
 * @package media\dao\interfaces
 * @author yangjian102621@163.com
 */
interface IMediaOrderDao extends ICommonDao {}