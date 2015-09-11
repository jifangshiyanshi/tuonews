<?php

namespace media\dao\interfaces;
use common\dao\interfaces\ICommonDao;
use herosphp\core\Loader;

Loader::import("common.dao.interfaces.ICommonDao", IMPORT_APP);
/**
 * 媒体类型(DAO)接口
 * Interface IMediaTypeDao
 * @package media\dao\interfaces
 * @author yangjian102621@163.com
 */
interface IMediaTypeDao extends ICommonDao {}