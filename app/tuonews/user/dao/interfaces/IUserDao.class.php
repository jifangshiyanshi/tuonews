<?php

namespace user\dao\interfaces;
use common\dao\interfaces\ICommonDao;
use herosphp\core\Loader;

Loader::import("common.dao.interfaces.ICommonDao", IMPORT_APP);
/**
 * 用户(DAO)接口
 * Interface IUserDao
 * @package user\dao\interfaces
 * @author yangjian102621@163.com
 */
interface IUserDao extends ICommonDao {

    /**
     * 单独更新User_data表的某个字段的数据
     * 这种情况是如果你只想更新用户数数据的固定某个字段，而不想更新整个用户表和用户数据表
     * @param string $field   要更新的字段
     * @param string $content  字段内容
     * @param int $id 字段ID
     * @return mixed
     */
    public function setUserData($field, $content, $id);

}