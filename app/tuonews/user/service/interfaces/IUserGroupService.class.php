<?php

namespace user\service\interfaces;
use common\service\interfaces\ICommonService;
use herosphp\core\Loader;

Loader::import('common.service.interfaces.ICommonService', IMPORT_APP);

/**
 * 用户分组服务接口
 * Interface IUserGroupService
 */
interface IUserGroupService extends ICommonService {}
?>