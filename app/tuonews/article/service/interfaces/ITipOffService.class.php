<?php

namespace article\service\interfaces;

use common\service\interfaces\ICommonService;
use herosphp\core\Loader;

Loader::import('common.service.interfaces.ICommonService', IMPORT_APP);

/**
 * 用户爆料服务接口
 * Interface IArticleRecService
 */
interface ITipOffService extends ICommonService {}
?>