<?php

namespace media\service\interfaces;

use common\service\interfaces\ICommonService;
use herosphp\core\Loader;

Loader::import('common.service.interfaces.ICommonService', IMPORT_APP);

/**
 * 媒体管理员角色服务接口
 * Interface IMediaManagerRoleService
 */
interface IMediaManagerRoleService extends ICommonService {}
?>