<?php

namespace media\dao\interfaces;
use common\dao\interfaces\ICommonDao;
use herosphp\core\Loader;

Loader::import("common.dao.interfaces.ICommonDao", IMPORT_APP);
/**
 * 媒体文章推荐位(DAO)接口
 * Interface IMediaArticleRecDao
 * @package media\dao\interfaces
 * @author yangjian102621@163.com
 */
interface IMediaArticleRecDao extends ICommonDao {}
