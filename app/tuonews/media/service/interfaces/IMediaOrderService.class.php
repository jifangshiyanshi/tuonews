<?php

namespace media\service\interfaces;

use common\service\interfaces\ICommonService;
use herosphp\core\Loader;

Loader::import('common.service.interfaces.ICommonService', IMPORT_APP);

/**
 * 媒体订阅服务接口
 * Interface IMediaChanelService
 */
interface IMediaOrderService extends ICommonService {}
?>