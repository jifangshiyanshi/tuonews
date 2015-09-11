<?php

namespace site\service\interfaces;

use common\service\interfaces\ICommonService;
use herosphp\core\Loader;

Loader::import('common.service.interfaces.ICommonService', IMPORT_APP);

/**
 * 媒体站模板关联服务接口
 * Interface IMediaTemplateService
 */
interface IMediaTemplateService extends ICommonService {}
?>