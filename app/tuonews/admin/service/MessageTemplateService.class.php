<?php
namespace admin\service;

use admin\service\interfaces\IMessageTemplateService;
use common\service\CommonService;
use herosphp\core\Loader;

Loader::import('admin.service.interfaces.IMessageTemplateService', IMPORT_APP);
Loader::import('common.service.CommonService', IMPORT_APP);

/**
 * 消息模板服务接口实现
 * Class MessageTemplateService
 * @package admin\service
 */
class MessageTemplateService extends CommonService implements IMessageTemplateService {}