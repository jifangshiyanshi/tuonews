<?php

namespace test\service\interfaces;
use common\service\interfaces\ICommonService;
use herosphp\core\Loader;

Loader::import('common.service.interfaces.ICommonService', IMPORT_APP);

/**
 * 测试服务接口
 * Interface ICommonService
 * @package common\service\interfaces
 * @author yangjian102621@163.com
 */
interface ITestService extends ICommonService{}