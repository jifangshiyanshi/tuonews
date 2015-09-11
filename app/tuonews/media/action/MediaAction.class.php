<?php
namespace media\action;

use common\action\NeedLoginAction;
use herosphp\bean\Beans;
use herosphp\core\WebApplication;
use herosphp\http\HttpRequest;
use herosphp\utils\AjaxResult;

/**
 * 媒体模块通用 Action
 * @author          yangjian<yangjian102621@163.com>
 */
class MediaAction extends NeedLoginAction {

    /**
     * 当前注册的媒体信息
     * @var array
     */
    protected $loginMedia = null;

    /**
     * 当前使用的服务
     * @var string
     */
    private $serviceBean;

    /**
     * @return mixed
     */
    public function getServiceBean()
    {
        return $this->serviceBean;
    }

    /**
     * @param mixed $serviceBean
     */
    public function setServiceBean($serviceBean)
    {
        $this->serviceBean = $serviceBean;
    }

    public function C_start(){

        parent::C_start();

        $webApp = WebApplication::getInstance();
        $request = $webApp->getHttpRequest();
        $mediaService = Beans::get("media.media.service");
        $this->loginMedia = $mediaService->getLoginMedia();
        //获取当前操作
        $currentOpt = $request->getAction().'@'.$request->getMethod();
        $this->assign("currentOpt", $currentOpt);

        //如果不是注册登录媒体操作，则需要做权限判断
        if ( $currentOpt != 'media@index' ) {
            $managerService = Beans::get('media.manager.service');
            if ( !$managerService->hasPermission($currentOpt, $this->loginUser['id']) ) {
                //判断请求的类型,如果是ajax请求则使用ajax返回
                if ( strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {
                    AjaxResult::ajaxResult('error', "您没有权限进行该操作，请联系管理员添加权限！");
                } else {
                    $this->showMessage('error', '您没有权限进行该操作，请联系管理员添加权限！');
                }
            }
        }
        $mediaInfo = $mediaService->getLoginMedia();
        $this->assign("loginMedia", $mediaInfo);

    }

    /**
     * 媒体首页
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {

        $media_id = $request->getParameter("media_id", 'intval');
        $mediaService = Beans::get("media.media.service");
        //初始化当前管理员的操作权限菜单
        $managerService = Beans::get('media.manager.service');
        $menus = $managerService->getUserMenu($this->loginUser['id'], $media_id);
        //获取权限
        $permissions = $managerService->getUserPermission($this->loginUser['id'], $media_id);
        if ( $menus == false || empty($menus) ) {
            $this->showMessage('error', '警告，您正在非法操作！');
        }
        //注册当前登录媒体
        $this->loginMedia = $mediaService->getItem($media_id);
        $this->loginMedia['menus'] = $menus;
        $this->loginMedia['permission'] = $permissions;
        $this->loginMedia['configs'] = cn_json_decode($this->loginMedia['configs']);
        $mediaService->setLoginMedia($this->loginMedia);
        //获取菜单的第一个页面为默认页面
        $defaultUrl = null;
        foreach ( $menus as $value ) {

            if ( $defaultUrl != null ) break;

            if ( empty($value) ) continue;

            foreach ( $value['sub'] as $val ) {

                if ( $defaultUrl != null ) break;
                $defaultUrl = $val['url'];
            }
        }
        $this->location(url($defaultUrl));
    }
    /**
     * 编辑操作
     * @param HttpRequest $request
     * @return void
     */
    public function edit(HttpRequest $request) {

        $id = $request->getParameter('id', 'intval');
        if ( $id <= 0 ) {
            $this->showMessage('danger', INVALID_ARGS);
        } else {

            $service = Beans::get($this->getServiceBean());
            $item = $service->getItem($id);
            $this->assign('item', $item);

        }
    }

    /**
     * 插入数据
     * @param array $data
     */
    protected function insert( $data ) {

        $service = Beans::get($this->getServiceBean());

        if ( $service->add($data) ) {
            AjaxResult::ajaxSuccessResult();
        } else {
            AjaxResult::ajaxFailtureResult();
        }
    }

    /**
     * 更新数据
     * @param array $data
     * @param HttpRequest $request
     */
    protected function update( $data, HttpRequest $request ) {

        if ( !$data ) AjaxResult::ajaxFailtureResult();

        $id = $request->getParameter('id', 'intval');
        if ( $id <= 0 ) AjaxResult::ajaxResult('error', INVALID_ARGS);

        $service = Beans::get($this->getServiceBean());
        if ( $service->update($data, $id) ) {
            AjaxResult::ajaxSuccessResult();
        } else {
            AjaxResult::ajaxFailtureResult();
        }

    }

    /**
     * 删除数据
     * @param HttpRequest $request
     */
    public function delete( HttpRequest $request ) {

        $id = $request->getParameter('id', 'intval');
        if ( $id <= 0 ) AjaxResult::ajaxResult('error', INVALID_ARGS);
        $service = Beans::get($this->getServiceBean());

        if ( $service->delete($id)) {
            AjaxResult::ajaxSuccessResult();
        } else {
            AjaxResult::ajaxFailtureResult();
        }
    }

    /**
     * 更新当前登录媒体信息
     * @param $data
     */
    protected function updateLoginMedia($data) {

        if ( is_array($data) ) {
            $mediaService = Beans::get('media.media.service');
            $media = $mediaService->getLoginMedia();

            $media = array_merge($media, $data);
            $mediaService->setLoginMedia($media);
        }

    }

}
?>
