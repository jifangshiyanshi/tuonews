<?php
namespace media\action;

use herosphp\bean\Beans;
use herosphp\http\HttpRequest;
use herosphp\utils\AjaxResult;

/**
 * 媒体配置信息 Action
 * @author          yangjian<yangjian102621@163.com>
 */
class ConfigAction extends MediaAction {

    public function C_start(){

        $this->setServiceBean("media.media.service");
        parent::C_start();
    }
    /**
     * 配置信息界面
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {

        $this->assign("siteInfo", $this->loginMedia["configs"]);
        $this->assign("seoTitle","媒体中心后台管理-系统配置");
        $this->assign("seoDesc","系统配置");
        $this->assign("seoKwords","媒体中心后台管理 系统配置");
        $this->setView('system/config_index');
    }

    /**
     * 更新配置信息
     * @param HttpRequest $request
     */
    public function update(HttpRequest $request) {

        $data = $request->getParameter('data');
        $mediaService = Beans::get($this->getServiceBean());

        $result = $mediaService->setMediaData('configs', cn_json_encode($data), $this->loginMedia['id']);

        //更新媒体信息
        if( $result ){
            $this->updateLoginMedia(array('configs' => $data));
            AjaxResult::ajaxSuccessResult();
        }else{
            AjaxResult::ajaxFailtureResult();
        }
    }

    /**
     * 独立域名绑定
     * @param HttpRequest $request
     */
    public function domain( HttpRequest $request ) {

        $this->assign("seoTitle","媒体中心后台管理-独立域名绑定");
        $this->assign("seoDesc","独立域名绑定");
        $this->assign("seoKwords","媒体中心后台管理 独立域名绑定");

        $this->setView('system/domain');
    }

    /**
     * @param HttpRequest $request
     */
    public function updateDomain(HttpRequest $request) {

        $domain = $request->getParameter('domain', 'trim');
        $domain = str_replace('www.', '', $domain);

        $mediaService = Beans::get($this->getServiceBean());
        $result = $mediaService->set('domain', $domain, $this->loginMedia['id']);

        //更新媒体信息
        if( $result ){

            $this->updateLoginMedia(array('domain' => $domain));
            AjaxResult::ajaxSuccessResult();
        }else{
            AjaxResult::ajaxFailtureResult();
        }
    }

}
?>
