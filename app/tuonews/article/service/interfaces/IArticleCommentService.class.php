<?php

namespace article\service\interfaces;

use common\service\interfaces\ICommonService;
use herosphp\core\Loader;

Loader::import('common.service.interfaces.ICommonService', IMPORT_APP);

/**
 * �����Ƽ�λ�÷���ӿ�
 * Interface IArticleRecService
 */
interface IArticleCommentService extends ICommonService {}
?>