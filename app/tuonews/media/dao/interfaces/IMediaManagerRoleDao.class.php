<?php

namespace media\dao\interfaces;
use common\dao\interfaces\ICommonDao;
use herosphp\core\Loader;

Loader::import("common.dao.interfaces.ICommonDao", IMPORT_APP);
/**
 * 媒体管理员角色(DAO)接口
 * Interface IMediaManagerRoleDao
 * @package media\dao\interfaces
 * @author yangjian102621@163.com
 */
interface IMediaManagerRoleDao extends ICommonDao {}