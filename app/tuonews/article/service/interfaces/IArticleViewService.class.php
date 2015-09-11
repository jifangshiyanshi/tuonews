<?php

namespace article\service\interfaces;

use common\service\interfaces\ICommonService;
use herosphp\core\Loader;

Loader::import('common.service.interfaces.ICommonService', IMPORT_APP);

/**
 * 文章视图服务接口
 * Interface IArticleViewService
 */
interface IArticleViewService extends ICommonService {}
?>