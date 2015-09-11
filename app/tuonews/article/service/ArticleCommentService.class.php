<?php
/**
 * by jifangshiyanshi
 * Date: 2015/9/7
 * Time: 14:47
 */
namespace article\service;

use herosphp\core\Loader;
use common\service\CommonService;
use article\service\interfaces\IArticleCommentService;

Loader::import( 'article.service.interfaces.IArticleCommentService',IMPORT_APP);


class ArticleCommentService extends CommonService implements IArticleCommentService{


    /**
     * @param $aid  文章id
     * @return array
     */
    public function getComment( $aid ,$page = 1,$num = 10){
        //获取所有的评论 和它对应的回复 安装时间的顺序

        return $this->getModelDao()->getItems( 'aid = '.$aid,'*','createtime desc',$page, $num );
    }

    /**
     * 根据评论的id获取评论信息
     * @param $id
     * @return mixed
     */
    public function getCommentById( $id ){
        return $this->getModelDao()->getItem( 'id = '.$id );
    }

    /**
     * 根据评论的id获取评论信息
     * @param $id
     * @return mixed
     */
    public function getCommentsById( $id ){
        return $this->getModelDao()->getItems( $id );
    }

    /**
     * 插入一条新的评论
     * @param $data
     * @return  number
     */
    public function insertComment( $data ){
       return $this->getModelDao()->add($data);
    }


}