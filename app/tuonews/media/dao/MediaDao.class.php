<?php

namespace media\dao;

use common\dao\CommonDao;
use herosphp\core\Loader;
use media\dao\interfaces\IMediaDao;

Loader::import('media.dao.interfaces.IMediaDao');
Loader::import('common.dao.CommonDao');

/**
 * 媒体媒体(DAO)接口实现
 * Class MediaDao
 * @package media\dao
 * @author yangjian102621@163.com
 */
class MediaDao extends CommonDao implements IMediaDao {



    /**
     * 媒体数据表dao
     * @var \herosphp\model\C_Model
     */
    private  $mediaDataDao = null;


    public function __construct($mediaModel, $mediaDataModel) {

        $this->mediaDataDao = Loader::model($mediaDataModel);
        $this->setModelDao(Loader::model($mediaModel));

    }



    /**
     * 添加媒体
     * @see \user\dao\interfaces\IUserDao::add
     */
    public function add($data) {
        //开启事务
        $this->beginTransaction();
        $result = $this->getModelDao()->insert($data);

        if ( $result != false ) {

            $data['media_id'] = $result;
            if ( $this->mediaDataDao->insert($data) ) {
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
     * 更新媒体
     * @see \user\dao\interfaces\IUserDao::update
     */
    public function update($data, $id) {
        //开启事务
        $this->beginTransaction();
        $result = $this->getModelDao()->update($data, $id);

        if ( $result != false ) {

            if ( $this->mediaDataDao->update($data, $id) ) {
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
     * @see \user\dao\interfaces\IUserDao::userDataSet
     */
    public function setMediaData($field, $content, $id) {

        return $this->mediaDataDao->set($field, $content, $id);

    }

    /**
     * @see \user\dao\interfaces\IUserDao::getItem
     */
    public function getItem($conditions, $fields, $order, $group, $having) {

        //获取媒体基本信息
        $item = $this->getModelDao()->getItem($conditions, $fields, $order, $group, $having);
        //获取媒体详细数据
        $data = $this->mediaDataDao->getItem($item['id']);
        //删除数据表的id
        unset($data['id']);
        return array_merge($item, $data);

    }

    /**
     * @see \user\dao\interfaces\IUserDao::delete
     */
    public function delete($id) {

        $this->beginTransaction();
        $result = $this->getModelDao()->delete($id);
        if ( $result ) {

            if ( $this->mediaDataDao->delete($id) ) {
                $this->commit();
            } else {
                $this->rollback();
                return false;
            }

        } else {
            //删除失败，回滚
            $this->rollback();
        }
        return $result;

    }
}

?>