<?php

namespace article\dao\interfaces;
use common\dao\interfaces\ICommonDao;
use herosphp\core\Loader;

Loader::import("common.dao.interfaces.ICommonDao", IMPORT_APP);
/**
 * ����(DAO)�ӿ�
 * Interface IArticleDao
 * @package article\dao\interfaces
 * @author jifangshiyanshi
 */
interface IArticleCommentDao extends ICommonDao {}