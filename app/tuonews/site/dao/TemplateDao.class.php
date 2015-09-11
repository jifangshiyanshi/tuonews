<?php

namespace site\dao;

use common\dao\CommonDao;
use herosphp\core\Loader;
use site\dao\interfaces\ITemplateDao;

Loader::import('site.dao.interfaces.ITemplateDao');
Loader::import('common.dao.CommonDao');

/**
 * 媒体站模板(DAO)接口实现
 * Class TemplateDao
 * @package site\dao
 * @author yangjian102621@163.com
 */
class TemplateDao extends CommonDao implements ITemplateDao {}