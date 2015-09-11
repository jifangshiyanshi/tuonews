<?php

namespace admin\service\interfaces;
use common\service\interfaces\ICommonService;
use herosphp\core\Loader;

Loader::import('common.service.interfaces.ICommonService', IMPORT_APP);

/**
 * 系统广告服务接口
 * Interface IRoleService
 */
interface IAdService extends ICommonService {}
?>