<?php
namespace article\service;

use article\service\interfaces\IArticleRecService;
use common\service\CommonService;
use herosphp\core\Loader;

Loader::import('article.service.interfaces.IArticleRecService', IMPORT_APP);
Loader::import('common.service.CommonService', IMPORT_APP);

/**
 * 文章推荐位置接口实现
 * Class ArticleRecService
 * @package article\service
 */
class ArticleRecService extends CommonService implements IArticleRecService {}