<?php
namespace media\service;

use common\service\CommonService;
use herosphp\core\Loader;
use media\service\interfaces\IMediaOrderService;

Loader::import('media.service.interfaces.IMediaOrderService', IMPORT_APP);
Loader::import('common.service.CommonService', IMPORT_APP);

/**
 * 媒体频道服务接口实现
 * Class MediaChanelService
 * @package media\service
 */
class MediaOrderService extends CommonService implements IMediaOrderService {}