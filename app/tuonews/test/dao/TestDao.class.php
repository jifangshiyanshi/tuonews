<?php

namespace test\dao;

use common\dao\CommonDao;
use herosphp\core\Loader;
use test\dao\interfaces\ITestDao;

Loader::import('common.dao.CommonDao', IMPORT_APP);
Loader::import('test.dao.interfaces.ITestDao', IMPORT_APP);
/**
 * 测试(DAO)接口的通用实现
 * Class CommonDao
 * @package test\dao
 * @author yangjian102621@163.com
 */
class TestDao extends  CommonDao implements ITestDao {}

?>