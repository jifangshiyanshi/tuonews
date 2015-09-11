<?php
namespace media\action;


use herosphp\bean\Beans;
use herosphp\http\HttpRequest;
use herosphp\utils\AjaxResult;
use herosphp\utils\ArrayUtils;

/**
 * 媒体资料 Action
 * @author          wangyanjun
 */
class ProfileAction extends MediaAction {

    public function C_start() {

        parent::C_start();
        $this->setServiceBean("media.media.service");

    }
    /**
     * 媒体信息修改页面
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {

        //获取媒体类型
        $mediaTypeService = Beans::get('media.type.service');
        $mediaTypes = $mediaTypeService->getItems(null, 'id,name');
        $this->assign('__mediaTypes', ArrayUtils::changeArrayKey($mediaTypes, 'id'));

        $this->assign("seoTitle","媒体中心后台管理-媒体信息");
        $this->assign("seoDesc","媒体信息");
        $this->assign("seoKwords","媒体中心后台管理 媒体信息");

        if ( $this->loginMedia['media_type'] == 1 ) {
            $logoWidth = 218;
        } else {
            $logoWidth = 128;
        }
        $this->assign('logoWidth', $logoWidth);

        $this->setView('media_profile');

    }

    /**
     * 重新绑定手机
     * @param HttpRequest $request
     */
    public  function bindMobile(HttpRequest $request) {

        $mobile = $request->getParameter('mobile', 'trim');
        $password = $request->getParameter('password', 'trim');
        $authcode = $request->getParameter('authcode', 'trim');

        //验证登录密码
        $userService = Beans::get('user.user.service');
        $conditions = array(
            'username' => $this->loginUser['username'],
            'password' => md5(md5($password))
        );
        if ( $userService->count($conditions) == 0 ) {
            AjaxResult::ajaxResult('error', '登录密码错误！');
        }

        //验证授权码
        $__authcode = getMobileCode($mobile, 600);
        if ( $__authcode != $authcode ) {
            AjaxResult::ajaxResult('error', '授权码错误！');
        }

        $mediaService = Beans::get('media.media.service');
        $data = array('mobile' => $mobile);
        if ( $mediaService->update($data, $this->loginUser['id']) ) {
            $this->updateLoginMedia($data);
            AjaxResult::ajaxSuccessResult();
        } else {
            AjaxResult::ajaxFailtureResult();
        }

    }

    /**
     * 重新绑定邮箱
     * @param HttpRequest $request
     */
    public  function bindEmail(HttpRequest $request) {

        $email = $request->getParameter('email', 'trim');
        $password = $request->getParameter('password', 'trim');
        $authcode = $request->getParameter('authcode', 'trim');

        //验证登录密码
        $userService = Beans::get('user.user.service');
        $conditions = array(
            'username' => $this->loginUser['username'],
            'password' => md5(md5($password))
        );
        if ( $userService->count($conditions) == 0 ) {
            AjaxResult::ajaxResult('error', '登录密码错误！');
        }

        //验证授权码
        $__authcode = getEmailCode($email, 1800);
        if ( $__authcode != $authcode ) {
            AjaxResult::ajaxResult('error', '授权码错误！');
        }

        $mediaService = Beans::get('media.media.service');
        $data = array('email' => $email);
        if ( $mediaService->update($data, $this->loginUser['id']) ) {
            $this->updateLoginMedia($data);
            AjaxResult::ajaxSuccessResult();
        } else {
            AjaxResult::ajaxFailtureResult();
        }

    }

    /**
     * 更新媒体信息操作
     * @param HttpRequest $request
     */
    public function update(HttpRequest $request) {

        $data = $request->getParameter("data");
        $provinceId = $request->getParameter("province_id_0", 'intval');
        $cityId = $request->getParameter("city_id_0", 'intval');

        $service = Beans::get($this->getServiceBean());
        if( $cityId ){
            $data["city_id"] = $cityId;
            $data["province_id"] = $provinceId;
        }

        $result = $service->update($data, $this->loginMedia["id"]);
        if( $result ) {
            $this->updateLoginMedia($data);
            AjaxResult::ajaxSuccessResult();
        }else{
            AjaxResult::ajaxFailtureResult();
        }
    }


}
?>
