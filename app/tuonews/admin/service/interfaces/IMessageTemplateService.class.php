<?php

namespace admin\service\interfaces;
use common\service\interfaces\ICommonService;
use herosphp\core\Loader;

Loader::import('common.service.interfaces.ICommonService', IMPORT_APP);

/**
 * 消息模板服务接口
 * Interface IMessageTemplateService
 */
interface IMessageTemplateService extends ICommonService {}