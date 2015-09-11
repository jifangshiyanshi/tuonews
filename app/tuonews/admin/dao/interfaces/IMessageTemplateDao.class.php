<?php

namespace admin\dao\interfaces;
use common\dao\interfaces\ICommonDao;
use herosphp\core\Loader;

Loader::import("common.dao.interfaces.ICommonDao", IMPORT_APP);
/**
 * 消息模板dao接口
 * Interface IMessageTemplateDao
 * @package admin\dao\interfaces
 * @author yangjian102621@163.com
 */
interface IMessageTemplateDao extends ICommonDao {}