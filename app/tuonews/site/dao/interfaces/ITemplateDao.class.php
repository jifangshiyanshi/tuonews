<?php

namespace site\dao\interfaces;
use common\dao\interfaces\ICommonDao;
use herosphp\core\Loader;

Loader::import("common.dao.interfaces.ICommonDao", IMPORT_APP);
/**
 * 媒体站模板(DAO)接口
 * Interface ITemplateDao
 * @package site\dao\interfaces
 * @author yangjian102621@163.com
 */
interface ITemplateDao extends ICommonDao {}