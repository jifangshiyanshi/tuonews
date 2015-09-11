<?php
namespace user\service;

use common\service\CommonService;
use herosphp\bean\Beans;
use herosphp\core\Loader;
use herosphp\session\Session;
use user\listener\UserListener;
use user\service\interfaces\IUserService;

Loader::import('user.service.interfaces.IUserService', IMPORT_APP);
Loader::import('user.listener.UserListener', IMPORT_APP);
Loader::import('common.service.CommonService', IMPORT_APP);

/**
 * 用户服务接口实现
 * Class UserService
 * @package user\service
 */
class UserService extends CommonService implements IUserService {


    /**
     * 用户监听器
     * @var array
     */
    private $listener = null;

    /**
     * 初始化监听器
     */
    public function __construct() {

        $this->listener = new UserListener();

    }

    /**
     * @see \user\service\interfaces\IUserService::login
     */
    public function login($username, $password, &$errorMsg) {

        //用户名登录
        $condiUser = array(
            'username' => $username,
            'password' => md5(md5($password))
        );
        $result = $this->getItem($condiUser);

        //如果用户绑定了邮箱可以使用邮箱登录
        if ( !$result ) {
            $condiEmail = array(
                'email' => $username,
                'email_check' => 1,
                'password' => md5(md5($password))
            );
            $result = $this->getItem($condiEmail);
        }

        //如果用户绑定了手机，则可以使用手机登录
        if ( !$result ) {
            $condiMobile = array(
                'mobile' => $username,
                'mobile_check' => 1,
                'password' => md5(md5($password))
            );
            $result = $this->getItem($condiMobile);
        }
        if ( $result ) {
            //触发用户登录监听事件
            if ( $this->listener instanceof UserListener ) {
                if ( method_exists($this->listener, 'login') ) {
                    $this->listener->login($result['id']);
                }
            }
        } else {
            $errorMsg = "登录密码错误！";
        }
        return $result;
    }

    /**
     * @see \user\service\interfaces\IUserService::register
     */
    public function register($data) {

        //1. 先到用户中心注册

        //2. 到驼牛注册
        $userid = $this->add($data);
        if ( $userid > 0 ) {
            //触发用户注册监听事件
            if ( $this->listener instanceof UserListener ) {
                if ( method_exists($this->listener, 'register') ) {
                    $this->listener->register($userid);
                }
            }
        }
        return $userid;
    }

    /**
     * @see \user\service\interfaces\IUserService::logout
     */
    public function logout() {

        //1. 先到用户中心退出

        //2. 本地退出
        Session::start();
        $_SESSION[IUserService::SESSION_FRONT_USER] = null;
        unset($_SESSION[IUserService::SESSION_FRONT_USER]);
        session_destroy();

    }

    /**
     * @see \user\service\interfaces\IUserService::checkField
     */
    public function checkField($field, $value) {

        //如果是验证用户名，则先到保留关键字库去过滤
        if ( $field == 'username' ) {

            $keywordsService = Beans::get('admin.keywords.service');
            $conditions = array(
                'type' => 1,
                'name' => $value
            );
            if ( $keywordsService->count($conditions) > 0 ) {
                return true;
            }

        }

        //2. 本地验证
        $conditions = array($field => $value);
        $num = $this->count($conditions);
        return ($num > 0);

        //2. 用户中心验证


    }

    /**
     * @see \user\service\interfaces\IUserService::getLoginUser
     */
    public function getLoginUser() {

        Session::start();
        return $_SESSION[IUserService::SESSION_FRONT_USER];
    }

    /**
     * @see \user\service\interfaces\IUserService::setLoginUser
     */
    public function setLoginUser($user) {

        Session::start();
        $_SESSION[IUserService::SESSION_FRONT_USER] = $user;

    }

    /**
     * @see \user\service\interfaces\IUserService::setUserData
     */
    public function setUserData($field, $content, $id) {

        return $this->getModelDao()->setUserData($field, $content, $id);

    }

    /**
     * @see \user\service\interfaces\IUserService::delete
     */
    public function delete($id) {

        //开启事务
        $this->beginTransaction();
        $result = $this->getModelDao()->delete($id);

        if ( $result == false ) {
            $this->rollback();
            return false;
        }

        //触发删除用户监听事件
        if ( $this->listener instanceof UserListener ) {
            if ( method_exists($this->listener, 'delete') ) {
                if ( !$this->listener->delete($id) ) {
                    //删除失败，回滚
                    $this->rollback();
                    return false;
                }
            }
        }
        $this->commit();
        return $result;

    }

    /**
     * @see \user\service\interfaces\IUserService::deletes
     */
    public function deletes($conditions) {

        $users = $this->getItems($conditions, 'id');
        $counter = 0;
        foreach ( $users as $value ) {
            if ( $this->delete($value['id']) ) {
                $counter++;
            }
        }

        return ($counter == count($users));
    }


    /**
     * 根据用户id数组获取用户的信息
     * by jifangshiyanshi 2015/9/8
     * @param $userId  数组
     * @return array
     */
    public function getUsers($userId){
        if( !$userId ) return array();
        return  $this->getModelDao()->getItems( $userId );
    }
}
