<?php
namespace admin\service;

use admin\service\interfaces\IKeywordsService;
use common\service\CommonService;
use herosphp\core\Loader;

Loader::import('admin.service.interfaces.IKeywordsService', IMPORT_APP);
Loader::import('common.service.CommonService', IMPORT_APP);

/**
 * 系统保留字实现
 * Class DomainService
 * @package admin\service
 */
class KeywordsService extends CommonService implements IKeywordsService {}
