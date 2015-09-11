<?php
namespace user\service;

use common\service\CommonService;
use herosphp\core\Loader;
use user\service\interfaces\IUserCollectService;
use user\service\interfaces\IUserRoleService;

Loader::import('user.service.interfaces.IUserCollectService', IMPORT_APP);
Loader::import('common.service.CommonService', IMPORT_APP);

/**
 * 用户收藏服务接口实现
 * Class UserService
 * @package user\service
 */
class UserCollectService extends CommonService implements IUserCollectService {}