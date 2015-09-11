<?php

namespace admin\service\interfaces;

use common\service\interfaces\ICommonService;
use herosphp\core\Loader;

Loader::import('common.service.interfaces.ICommonService', IMPORT_APP);

/**
 * 系统保留字服务接口
 * Interface IDomainService
 */
interface IKeywordsService extends ICommonService {}
?>
