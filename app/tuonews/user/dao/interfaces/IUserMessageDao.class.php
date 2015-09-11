<?php

namespace user\dao\interfaces;
use common\dao\interfaces\ICommonDao;
use herosphp\core\Loader;

Loader::import("common.dao.interfaces.ICommonDao", IMPORT_APP);
/**
 * 用户站内信(DAO)接口
 * Interface IUserMessageDao
 * @package user\dao\interfaces
 * @author yangjian102621@163.com
 */
interface IUserMessageDao extends ICommonDao {}