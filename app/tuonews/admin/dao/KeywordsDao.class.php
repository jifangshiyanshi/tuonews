<?php

namespace admin\dao;

use admin\dao\interfaces\IKeywordsDao;
use common\dao\CommonDao;
use herosphp\core\Loader;

Loader::import('admin.dao.interfaces.IKeywordsDao');
Loader::import('common.dao.CommonDao');

/**
 * 系统保留字(DAO)接口实现
 * Class DomainDao
 * @package admin\dao
 * @author wangyanjun
 */
class KeywordsDao extends CommonDao implements IKeywordsDao {}

?>
