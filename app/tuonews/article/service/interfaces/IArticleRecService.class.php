<?php

namespace article\service\interfaces;

use common\service\interfaces\ICommonService;
use herosphp\core\Loader;

Loader::import('common.service.interfaces.ICommonService', IMPORT_APP);

/**
 * 文章推荐位置服务接口
 * Interface IArticleRecService
 */
interface IArticleRecService extends ICommonService {}
?>