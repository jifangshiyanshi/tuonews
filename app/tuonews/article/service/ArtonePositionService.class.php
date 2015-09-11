<?php
namespace article\service;

use article\service\interfaces\IArtonePositionService;
use common\service\CommonService;
use herosphp\core\Loader;

Loader::import('article.service.interfaces.IArtonePositionService', IMPORT_APP);
Loader::import('common.service.CommonService', IMPORT_APP);

/**
 * 单文章显示位置接口实现
 * Class ArtonePositionService
 * @package article\service
 */
class ArtonePositionService extends CommonService implements IArtonePositionService {}