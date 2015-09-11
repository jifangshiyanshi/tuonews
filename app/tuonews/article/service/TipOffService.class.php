<?php
namespace article\service;

use article\service\interfaces\ITipOffService;
use common\service\CommonService;
use herosphp\core\Loader;

Loader::import('article.service.interfaces.ITipOffService', IMPORT_APP);
Loader::import('common.service.CommonService', IMPORT_APP);

/**
 * 用户爆料服务接口实现
 * Class TipOffService
 * @package article\service
 */
class TipOffService extends CommonService implements ITipOffService {}