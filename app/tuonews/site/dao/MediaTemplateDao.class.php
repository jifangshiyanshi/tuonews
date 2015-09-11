<?php

namespace site\dao;

use common\dao\CommonDao;
use herosphp\core\Loader;
use site\dao\interfaces\IMediaTemplateDao;

Loader::import('site.dao.interfaces.IMediaTemplateDao');
Loader::import('common.dao.CommonDao');

/**
 * 媒体站模板关联表(DAO)接口实现
 * Class MediaTemplateDao
 * @package site\dao
 * @author yangjian102621@163.com
 */
class MediaTemplateDao extends CommonDao implements IMediaTemplateDao {}