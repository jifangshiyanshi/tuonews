<?php

namespace article\dao;

use article\dao\interfaces\IArtoneDao;
use common\dao\CommonDao;
use herosphp\core\Loader;

Loader::import('article.dao.interfaces.IArtoneDao');
Loader::import('common.dao.CommonDao');

/**
 * 单文章(DAO)接口实现
 * Class ArtoneDao
 * @package article\dao
 * @author yangjian102621@163.com
 */
class ArtoneDao extends CommonDao implements IArtoneDao {

    /**
     * 单文章内容dao
     * @var \herosphp\model\C_Model
     */
    private  $dataDao = null;


    public function __construct($articleModel, $dataModel) {

        $this->setModelDao(Loader::model($articleModel));
        $this->dataDao = Loader::model($dataModel);

    }

    /**
     * 添加文章
     * @see \article\dao\interfaces\IArtoneDao::add()
     */
    public function add($data) {
        //开启事务
        $this->beginTransaction();
        $result = $this->getModelDao()->insert($data);

        if ( $result != false ) {

            $data['aid'] = $result;
            if ( $this->dataDao->insert($data) ) {
                $this->commit();
            } else {
                $this->rollback();
            }

        } else {
            //操作失败，回滚
            $this->rollback();
        }

        return $result;

    }

    /**
     * 更新文章
     * @see \article\dao\interfaces\IArtoneDao::update()
     */
    public function update($data, $id) {
        //开启事务
        $this->beginTransaction();
        $result = $this->getModelDao()->update($data, $id);

        if ( $result != false ) {

            if ( $this->dataDao->update($data, $id) ) {
                $this->commit();
                return true;
            } else {
                $this->rollback();
                return false;
            }
        } else {
            //操作失败，回滚
            $this->rollback();
            return false;
        }

    }

    /**
     * 获取文章
     * @see \article\dao\interfaces\IArtoneDao::getItem()
     */
    public function getItem($conditions, $fields, $order, $group, $having) {

        //获取文章基本信息
        $item = $this->getModelDao()->getItem($conditions, $fields, $order, $group, $having);
        //获取问行内容
        $data = $this->dataDao->getItem($item['id']);
        //删除data表主键
        unset($data['id']);
        return array_merge($item, $data);

    }

    /**
     * @see \article\dao\interfaces\IArtoneDao::delete()
     */
    public function delete($id) {

        $this->beginTransaction();
        $result = $this->getModelDao()->delete($id);
        if ( $result ) {

            if ( $this->dataDao->delete($id) ) {
                $this->commit();
            } else {
                $this->rollback();
            }

        } else {
            //删除失败，回滚
            $this->rollback();
        }
        return $result;

    }

    /**
     * @see \article\dao\interfaces\IArtoneDao::deletes()
     */
    public function deletes($conditions) {

        $items = $this->getModelDao()->getItems($conditions, 'id');
        $counter = 0;
        foreach ( $items as $value ) {
            if ( $this->delete($value['id']) ) {
                $counter++;
            }
        }

        //只要删除了一条则就认为该操作是成功的。
        return ($counter > 0);
    }

    /**
     * 获取文章内容表的dao实例
     * @return \herosphp\model\C_Model
     */
    public function getDataDao() {

        return $this->dataDao;
    }

}

?>