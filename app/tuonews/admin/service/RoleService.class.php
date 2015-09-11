<?php
namespace admin\service;

use admin\service\interfaces\IRoleService;
use common\service\CommonService;
use herosphp\core\Loader;

Loader::import('admin.service.interfaces.IRoleService', IMPORT_APP);
Loader::import('common.service.CommonService', IMPORT_APP);

/**
 * 后台管理员角色接口实现
 * Class RoleService
 * @package admin\service
 */
class RoleService extends CommonService implements IRoleService {}