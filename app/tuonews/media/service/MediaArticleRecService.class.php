<?php
namespace media\service;

use common\service\CommonService;
use herosphp\core\Loader;
use media\service\interfaces\IMediaArticleRecService;

Loader::import('media.service.interfaces.IMediaArticleRecService', IMPORT_APP);
Loader::import('common.service.CommonService', IMPORT_APP);

/**
 * 媒体推荐位服务接口实现
 * Class MediaArticleRecService
 * @package media\service
 */
class MediaArticleRecService extends CommonService implements IMediaArticleRecService {}
