<?php

namespace user\service\interfaces;
use common\service\interfaces\ICommonService;
use herosphp\core\Loader;

Loader::import('common.service.interfaces.ICommonService', IMPORT_APP);

/**
 * 用户站内信服务接口
 * Interface IUserMessageService
 */
interface IUserMessageService extends ICommonService {}
?>