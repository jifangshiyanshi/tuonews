<?php

namespace admin\dao;

use admin\dao\interfaces\IMessageTemplateDao;
use common\dao\CommonDao;
use herosphp\core\Loader;

Loader::import('admin.dao.interfaces.IMessageTemplateDao');
Loader::import('common.dao.CommonDao');

/**
 * 消息模板dao接口实现
 * Class MessageTemplateDao
 * @package admin\dao
 * @author yangjian102621@163.com
 */
class MessageTemplateDao extends CommonDao implements IMessageTemplateDao {}

?>