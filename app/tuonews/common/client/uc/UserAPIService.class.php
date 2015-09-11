<?php
namespace api\uc;
use api\uc\interfaces\IUserAPIService;

include __DIR__.'/AbstractService.class.php';
include __DIR__.'/interfaces/IUserAPIService.class.php';

/**
 * 会员服务实现
 * Class AbstractService
 * @package common\client
 * @author yangjian102621@163.com
 * @since 2015-03-17
 */
class UserAPIService extends AbstractService implements IUserAPIService {

    /**
     * @see \api\uc\interfaces\IUserAPIService::login()
     */
    public function login($account, $password)
    {
        if ( !$account  || !$password ) return false;
        $params['name'] = $account;
        $params['password'] = $password;
        $params['appKey'] = self::APP_KEY;

        $apiURI = '/ucLogin';
        return $this->servicePost($apiURI, $params);
    }

    /**
     * @see \api\uc\interfaces\IUserAPIService::register()
     */
    public function register($data)
    {
        if ( !$data ) return false;
        $params = $data;
        $params['appKey'] = self::APP_KEY;

        $apiURI = '/register';
        return $this->servicePost($apiURI, $params);
    }


    /**
     * @see \api\uc\interfaces\IUserAPIService::update()
     */
    public function update($data, $username)
    {
        if ( !$data  || !$username ) return false;
        $params = $data;
        $params['name'] = $username;
        $params['appKey'] = self::APP_KEY;

        $apiURI = '/ucEdit';
        return $this->servicePost($apiURI, $params);
    }

    /**
     * @see \api\uc\interfaces\IUserAPIService::delete()
     */
    public function delete($username)
    {
        if ( !$username ) return false;
        $params['name'] = $username;
        $params['appKey'] = self::APP_KEY;

        $apiURI = '/ucDelete';
        return $this->servicePost($apiURI, $params);
    }

    /**
     * @see \api\uc\interfaces\IUserAPIService::checkUsername()
     */
    public function checkUsername($username)
    {
        if ( !$username ) return false;
        $params['name'] = $username;
        $params['appKey'] = self::APP_KEY;

        $apiURI = '/ucCheck';
        return $this->servicePost($apiURI, $params);
    }

    /**
     * @see \api\uc\interfaces\IUserAPIService::checkEmail()
     */
    public function checkEmail($email)
    {
        if ( !$email ) return false;
        $params['email'] = $email;
        $params['appKey'] = self::APP_KEY;

        $apiURI = '/ucCheck';
        return $this->servicePost($apiURI, $params);
    }

    /**
     * @see \api\uc\interfaces\IUserAPIService::checkMobile()
     */
    public function checkMobile($mobile)
    {
        if ( !$mobile ) return false;
        $params['mobile'] = $mobile;
        $params['appKey'] = self::APP_KEY;

        $apiURI = '/ucCheck';
        return $this->servicePost($apiURI, $params);
    }
}

?>