<?php

namespace image\dao\interfaces;
use common\dao\interfaces\ICommonDao;
use herosphp\core\Loader;

Loader::import("common.dao.interfaces.ICommonDao", IMPORT_APP);
/**
 * 图片空间(DAO)接口
 * Interface IImageDao
 * @package image\dao\interfaces
 * @author yangjian102621@163.com
 */
interface IImageDao extends ICommonDao {}