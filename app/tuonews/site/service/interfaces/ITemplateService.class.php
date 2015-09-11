<?php

namespace site\service\interfaces;

use common\service\interfaces\ICommonService;
use herosphp\core\Loader;

Loader::import('common.service.interfaces.ICommonService', IMPORT_APP);

/**
 * 媒体站模板服务接口
 * Interface ITemplateService
 */
interface ITemplateService extends ICommonService {}
?>