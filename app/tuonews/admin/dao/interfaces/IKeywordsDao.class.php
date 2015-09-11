<?php

namespace admin\dao\interfaces;
use common\dao\interfaces\ICommonDao;
use herosphp\core\Loader;

Loader::import("common.dao.interfaces.ICommonDao", IMPORT_APP);
/**
 * 系统保留字接口
 * Interface IDomainDao
 * @package admin\dao\interfaces
 * @author wangyanjun
 */
interface IKeywordsDao extends ICommonDao {}
