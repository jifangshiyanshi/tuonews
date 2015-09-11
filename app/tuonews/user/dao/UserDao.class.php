<?php

namespace user\dao;

use common\dao\CommonDao;
use herosphp\core\Loader;
use user\dao\interfaces\IUserDao;

Loader::import('user.dao.interfaces.IUserDao');
Loader::import('common.dao.CommonDao');

/**
 * 用户(DAO)接口实现
 * Class UserDao
 * @package user\dao
 * @author yangjian102621@163.com
 */
class UserDao extends CommonDao implements IUserDao {

    /**
     * 用户数据表dao
     * @var \herosphp\model\C_Model
     */
    private  $userDataDao = null;


    public function __construct($userModel, $userDataModel) {

        $this->userDataDao = Loader::model($userDataModel);
        $this->setModelDao(Loader::model($userModel));

    }



    /**
     * 添加用户
     * @see \user\dao\interfaces\IUserDao::add
     */
    public function add($data) {
        //开启事务
        $this->beginTransaction();
        $result = $this->getModelDao()->insert($data);

        if ( $result != false ) {

            $data['userid'] = $result;
            if ( $this->userDataDao->insert($data) ) {
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
     * 更新用户
     * @see \user\dao\interfaces\IUserDao::update
     */
    public function update($data, $id) {
        //开启事务
        $this->beginTransaction();
        $result = $this->getModelDao()->update($data, $id);
        if ( $result != false ) {

            if ( $this->userDataDao->update($data, $id) ) {
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
    public function setUserData($field, $content, $id) {

        return $this->userDataDao->set($field, $content, $id);

    }

    /**
     * @see \user\dao\interfaces\IUserDao::getItem
     */
    public function getItem($conditions, $fields, $order, $group, $having) {

        //获取用户基本信息
        $item = $this->getModelDao()->getItem($conditions, $fields, $order, $group, $having);
        //获取用户详细数据
        $data = $this->userDataDao->getItem($item['id']);
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

            if ( $this->userDataDao->delete($id) ) {
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