<?php
namespace admin\service;

use admin\service\interfaces\IAdService;
use common\service\CommonService;
use herosphp\core\Loader;

Loader::import('admin.service.interfaces.IAdService', IMPORT_APP);
Loader::import('common.service.CommonService', IMPORT_APP);

/**
 * 广告服务接口实现
 * Class ChanelService
 * @package admin\service
 */
class AdService extends CommonService implements IAdService {}