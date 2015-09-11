<?php
namespace media\service;

use common\service\CommonService;
use herosphp\core\Loader;
use media\service\interfaces\IMediaRecService;

Loader::import('media.service.interfaces.IMediaRecService', IMPORT_APP);
Loader::import('common.service.CommonService', IMPORT_APP);

/**
 * 媒体推荐位服务接口实现
 * Class MediaRecService
 * @package media\service
 */
class MediaRecService extends CommonService implements IMediaRecService {}