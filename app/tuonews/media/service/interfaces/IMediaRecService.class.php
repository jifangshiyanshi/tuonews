<?php

namespace media\service\interfaces;

use common\service\interfaces\ICommonService;
use herosphp\core\Loader;

Loader::import('common.service.interfaces.ICommonService', IMPORT_APP);

/**
 * 媒体推荐位服务接口
 * Interface IMediaTypeService
 */
interface IMediaRecService extends ICommonService {}
?>