<?php
namespace site\service;

use common\service\CommonService;
use herosphp\core\Loader;
use site\service\interfaces\ITemplateService;

Loader::import('site.service.interfaces.ITemplateService', IMPORT_APP);
Loader::import('common.service.CommonService', IMPORT_APP);

/**
 * 媒体站模板服务接口实现
 * Class TemplateService
 * @package site\service
 */
class TemplateService extends CommonService implements ITemplateService {}