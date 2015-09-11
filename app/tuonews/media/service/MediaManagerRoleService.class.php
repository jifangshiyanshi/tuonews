<?php
namespace media\service;

use common\service\CommonService;
use herosphp\core\Loader;
use media\service\interfaces\IMediaManagerRoleService;

Loader::import('media.service.interfaces.IMediaManagerRoleService', IMPORT_APP);
Loader::import('common.service.CommonService', IMPORT_APP);

/**
 * 媒体类型服务接口实现
 * Class MediaManagerRoleService
 * @package media\service
 */
class MediaManagerRoleService extends CommonService implements IMediaManagerRoleService {}