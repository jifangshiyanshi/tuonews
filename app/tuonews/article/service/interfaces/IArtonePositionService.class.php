<?php

namespace article\service\interfaces;

use common\service\interfaces\ICommonService;
use herosphp\core\Loader;

Loader::import('common.service.interfaces.ICommonService', IMPORT_APP);

/**
 * 单文章显示位置服务接口
 * Interface IArtonePositionService
 */
interface IArtonePositionService extends ICommonService {}
?>