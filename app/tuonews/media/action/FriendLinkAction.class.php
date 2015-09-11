<?php
namespace media\action;

use herosphp\bean\Beans;
use herosphp\http\HttpRequest;

/**
 * 友情链接 Action
 * @author          wangyanjun
 */
class FriendLinkAction extends MediaAction {

    public function C_start(){

        $this->setServiceBean("media.friendlink.service");
        parent::C_start();
    }
    /**
     * 友情链接列表
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {

        $service = Beans::get($this->getServiceBean());
        $items = $service->getItems("media_id=".$this->loginMedia["id"],"id,ishow,add_time,name");
        $this->assign("items",$items);

        $this->assign("seoTitle","媒体中心后台管理-友情链接列表");
        $this->assign("seoDesc","友情链接");
        $this->assign("seoKwords","媒体中心后台管理 友情链接");

        $this->setView('system/friendLink_list');
    }

    /**
     * 添加友情链接界面
     * @param HttpRequest $request
     */
    public function add(HttpRequest $request) {

        $this->assign("seoTitle","媒体中心后台管理-添加友情链接");
        $this->assign("seoDesc","友情链接 - 添加友情链接");
        $this->assign("seoKwords","媒体中心后台管理 添加友情链接");
        $this->setView('system/friendLink_form');
    }

    /**
     * 添加友情链接操作
     * @param HttpRequest $request
     */
    public function insert(HttpRequest $request) {

        $data=$request->getParameter("data");
        $data["add_time"] = time();
        $data["userid"] = $this->loginUser["id"];
        $data["media_id"] = $this->loginMedia['id'];
        parent::insert($data);
    }

    /**
     * 编辑友情链接界面
     * @param HttpRequest $request
     */
    public function edit(HttpRequest $request) {

        parent::edit($request);

        $this->assign("seoTitle","媒体中心后台管理-编辑友情链接");
        $this->assign("seoDesc","友情链接 - 编辑友情链接");
        $this->assign("seoKwords","媒体中心后台管理 编辑友情链接");

        $this->setView("system/friendLink_form");
    }

    /**
     * 更新友情链接操作
     * @param HttpRequest $request
     */
    public function update(HttpRequest $request) {

        $data = $request->getParameter("data");
        parent::update($data,$request);
    }

}
?>
