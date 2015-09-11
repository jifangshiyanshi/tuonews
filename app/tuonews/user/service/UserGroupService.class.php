<?php
namespace user\service;

use common\service\CommonService;
use herosphp\core\Loader;
use user\service\interfaces\IUserGroupService;

Loader::import('user.service.interfaces.IUserGroupService', IMPORT_APP);
Loader::import('common.service.CommonService', IMPORT_APP);

/**
 * 用户服分组务接口实现
 * Class UserGroupService
 * @package user\service
 */
class UserGroupService extends CommonService implements IUserGroupService {}