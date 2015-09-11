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
     * @param $aid  ����id
     * @return array
     */
    public function getComment( $aid ,$page = 1,$num = 10){
        //��ȡ���е����� ������Ӧ�Ļظ� ��װʱ���˳��

        return $this->getModelDao()->getItems( 'aid = '.$aid,'*','createtime desc',$page, $num );
    }

    /**
     * �������۵�id��ȡ������Ϣ
     * @param $id
     * @return mixed
     */
    public function getCommentById( $id ){
        return $this->getModelDao()->getItem( 'id = '.$id );
    }

    /**
     * �������۵�id��ȡ������Ϣ
     * @param $id
     * @return mixed
     */
    public function getCommentsById( $id ){
        return $this->getModelDao()->getItems( $id );
    }

    /**
     * ����һ���µ�����
     * @param $data
     * @return  number
     */
    public function insertComment( $data ){
       return $this->getModelDao()->add($data);
    }


}