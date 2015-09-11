<?php
namespace user\service;

use common\service\CommonService;
use herosphp\core\Loader;
use user\service\interfaces\IUserMessageService;

Loader::import('user.service.interfaces.IUserMessageService', IMPORT_APP);
Loader::import('common.service.CommonService', IMPORT_APP);

/**
 * 用户站内信服务接口实现
 * Class UserMessageService
 * @package user\service
 */
class UserMessageService extends CommonService implements IUserMessageService {}