<?php

namespace article\dao;

use article\dao\interfaces\IArticleTagDao;
use common\dao\CommonDao;
use herosphp\core\Loader;

Loader::import('article.dao.interfaces.IArticleTagDao');
Loader::import('common.dao.CommonDao');

/**
 * 文章标签(DAO)接口实现
 * Class ArticleTagDao
 * @package article\dao
 * @author yangjian102621@163.com
 */
class ArticleTagDao extends CommonDao implements IArticleTagDao {

    /**
     * 文章标签关联dao
     * @var \herosphp\model\C_Model
     */
    private $tagAssocDao = null;

    /**
     * @param $tagModel
     * @param $tagAssoc
     */
    public function __construct($tagModel, $tagAssoc) {


        $this->setModelDao(Loader::model($tagModel));
        $this->tagAssocDao = Loader::model($tagAssoc);
    }

    /**
     * 添加标签
     * @see \article\dao\interfaces\IArticleTagDao::add
     */
    public function add($data) {

        //如果标签已经存在则直接返回标签ID
        $item = $this->getModelDao()->getItem("name='{$data['name']}'", 'id');
        if ( $item ) {
            return $item['id'];
        }
        else {
            return $this->getModelDao()->insert($data);
        }
    }

    /**
     * 删除标签
     * @see \article\dao\interfaces\IArticleTagDao::delete()
     */
    public function delete($id) {

        $result = $this->getModelDao()->deletes($id);
        if ( $result ) {
            //删除标签关联数据
            $this->tagAssocDao->deletes("tagid={$id}");
        }
        return $result;
    }

}

?>
