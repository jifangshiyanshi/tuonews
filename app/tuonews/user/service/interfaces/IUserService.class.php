<?php

namespace user\service\interfaces;
use common\service\interfaces\ICommonService;
use herosphp\core\Loader;

Loader::import('common.service.interfaces.ICommonService', IMPORT_APP);

/**
 * 用户服务接口
 * Interface IUserService
 */
interface IUserService extends ICommonService {

    /**
     * 登陆后的信息保存到session的key
     * @var string
     */
    const SESSION_FRONT_USER = 'tuonews_user_session_key';

    /**
     * 用户登录服务
     * @param string $username 用户名
     * @param string $password 密码
     * @param string $errorMsg 错误信息
     * @return mixed
     */
    public function login($username, $password, &$errorMsg);

    /**
     * 用户注册服务
     * @param array $data 注册数据
     * @return mixed
     */
    public function register($data);

    /**
     * 登出服务
     * @return mixed
     */
    public function logout();

    /**
     * 获取当前登录用户
     * @return mixed
     */
    public function getLoginUser();

    /**
     * 更新当前登录用户
     * @param array $user
     * @return mixed
     */
    public function setLoginUser($user);

    /**
     * 单独更新User_data表的某个字段的数据
     * 这种情况是如果你只想更新用户数数据的固定某个字段，而不想更新整个用户表和用户数据表
     * @param string $field   要更新的字段
     * @param string $content  字段内容
     * @param int $id 字段ID
     * @return mixed
     */
    public function setUserData($field, $content, $id);

    /**
     * 检测某一字段的用户是否存在，如用户名，邮箱，手机...
     * @param $field
     * @param $value
     * @return mixed
     */
    public function checkField($field, $value);
}
?>