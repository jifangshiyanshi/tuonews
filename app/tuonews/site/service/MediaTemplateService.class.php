<?php
namespace site\service;

use common\service\CommonService;
use herosphp\core\Loader;
use site\service\interfaces\IMediaTemplateService;

Loader::import('site.service.interfaces.IMediaTemplateService', IMPORT_APP);
Loader::import('common.service.CommonService', IMPORT_APP);

/**
 * 媒体站模板关联表服务接口实现
 * Class MediaTemplateService
 * @package site\service
 */
class MediaTemplateService extends CommonService implements IMediaTemplateService {}