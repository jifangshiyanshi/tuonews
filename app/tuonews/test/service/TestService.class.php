<?php

namespace test\service;

use common\service\CommonService;
use herosphp\core\Loader;
use test\service\interfaces\ITestService;

Loader::import('test.service.interfaces.ITestService', IMPORT_APP);
Loader::import('common.service.CommonService', IMPORT_APP);
/**
 * 通用服务接口实现
 * Class CommonService
 * @package common\service
 */
class TestService extends CommonService implements ITestService {}

?>