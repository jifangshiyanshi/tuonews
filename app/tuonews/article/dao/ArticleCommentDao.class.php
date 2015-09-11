<?php
/**
 * Created by jifangshiyanshi
 * User: Administrator
 * Date: 2015/9/7
 * Time: 15:08
 */
namespace article\dao;

use article\service\interfaces\IArticleCommentService;
use common\dao\CommonDao;
use herosphp\bean\Beans;
use herosphp\core\Loader;
use article\dao\interfaces\IArticleCommentDao;


Loader::import('article.dao.interfaces.IArticleCommentDao');
Loader::import('common.dao.CommonDao');


class ArticleCommentDao extends CommonDao implements IArticleCommentDao{

    private $commentAssocDao = null;

    public function __construct($articleCommentModel, $commentAssoc=null) {

        $this->setModelDao(Loader::model($articleCommentModel));

    }

    public function add($data){
        return $this->getModelDao()->insert($data);
    }
}