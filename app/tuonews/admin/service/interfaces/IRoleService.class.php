<?php

namespace admin\service\interfaces;
use common\service\interfaces\ICommonService;
use herosphp\core\Loader;

Loader::import('common.service.interfaces.ICommonService', IMPORT_APP);

/**
 * 后台管理员角色服务接口
 * Interface IRoleService
 */
interface IRoleService extends ICommonService {}
?>