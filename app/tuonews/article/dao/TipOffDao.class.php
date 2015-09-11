<?php

namespace article\dao;

use article\dao\interfaces\ITipOffDao;
use common\dao\CommonDao;
use herosphp\core\Loader;

Loader::import('article.dao.interfaces.ITipOffDao');
Loader::import('common.dao.CommonDao');

/**
 * 用户爆料(DAO)接口实现
 * Class TipOffDao
 * @package article\dao
 * @author yangjian102621@163.com
 */
class TipOffDao extends CommonDao implements ITipOffDao {}

?>