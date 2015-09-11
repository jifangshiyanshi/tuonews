<?php
namespace api\uc\interfaces;

/**
 * 用户服务接口
 * interface IUserService
 * @package common\client\interfaces
 * @author yangjian102621@163.com
 * @since 2015-03-17
 */
interface IUserAPIService {

    /**
     * 应用的app key
     */
    const APP_KEY = '5c6fc68d0441dfee5dd5ac795ae278bc';

	/**
	 *  用户登陆
	 * @param string $account
	 * @param string $password
	 * @return \api\tools\result\AbstractResult
	 */
	public function login($account, $password);

    /**
     * 用户注册
     * @param $data
     * @return \api\tools\result\AbstractResult
     */
    public function register($data);

    /**
     * 更新用户数据
     * @param $data
     * @param $username
     * @return \api\tools\result\AbstractResult
     */
    public function update($data, $username);

    /**
     * 删除用户
     * @param $username
     * @return \api\tools\result\AbstractResult
     */
    public function delete($username);

    /**
     * 检验用户名是否存在
     * @param $username
     * @return \api\tools\result\AbstractResult
     */
    public function checkUsername($username);

    /**
     * 检验邮箱是否存在
     * @param $email
     * @return \api\tools\result\AbstractResult
     */
    public function checkEmail($email);

    /**
     * 检验手机号码是否存在
     * @param $mobile
     * @return \api\tools\result\AbstractResult
     */
    public function checkMobile($mobile);
}

?>