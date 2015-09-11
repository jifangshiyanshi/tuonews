<?php
namespace media\service;

use common\service\CommonService;
use herosphp\core\Loader;
use media\service\interfaces\IMediaTypeService;

Loader::import('media.service.interfaces.IMediaTypeService', IMPORT_APP);
Loader::import('common.service.CommonService', IMPORT_APP);

/**
 * 媒体类型服务接口实现
 * Class MediaTypeService
 * @package media\service
 */
class MediaTypeService extends CommonService implements IMediaTypeService {}