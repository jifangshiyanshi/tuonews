<?php

namespace media\dao;

use common\dao\CommonDao;
use herosphp\core\Loader;
use media\dao\interfaces\IMediaArticleRecDao;

Loader::import('media.dao.interfaces.IMediaArticleRecDao');
Loader::import('common.dao.CommonDao');

/**
 * 媒体文章推荐位(DAO)接口实现
 * Class MediaArticleRecDao
 * @package media\dao
 * @author yangjian102621@163.com
 */
class MediaArticleRecDao extends CommonDao implements IMediaArticleRecDao {}
