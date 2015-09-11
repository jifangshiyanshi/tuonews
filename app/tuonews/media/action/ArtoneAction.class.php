<?php
namespace media\action;

use herosphp\bean\Beans;
use herosphp\http\HttpRequest;
use herosphp\utils\AjaxResult;

/**
 * 媒体单文章 Action
 * 关于我们 | 联系我们 | 广告服务共享此Action
 * @author          yangjian<yangjian102621@163.com>
 */
class ArtoneAction extends MediaAction {

    public function C_start(){

        $this->setServiceBean("artone.artone.service");
        parent::C_start();
    }
    /**
     * 单文章列表
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {

        $service = Beans::get($this->getServiceBean());
        $media_id = $this->loginMedia["id"];

        $items = $service->getItems("media_id=".$media_id,"id,title,add_time,sort_num");
        $this->assign("items",$items);

        $this->assign("seoTitle","媒体中心后台管理 - 单文章");
        $this->assign("seoDesc","媒体中心后台管理 单文章列表");
        $this->assign("seoKwords","媒体中心后台管理 单文章列表");

        $this->setView('article/artone_list');
    }

    /**
     * 添加单文章界面
     * @param HttpRequest $request
     */
    public function add(HttpRequest $request) {

        $this->assign("seoTitle","媒体中心后台管理 - 添加单文章");
        $this->assign("seoDesc","媒体中心后台管理 - 添加单文章");
        $this->assign("seoKwords","媒体中心后台管理 添加单文章");

        $this->setView('article/artone_form');
    }

    /**
     * 添加单文章操作
     * @param HttpRequest $request
     */
    public function insert(HttpRequest $request) {

        $data = $request->getParameter("data");
        $data["add_time"]    = time();
        $data["media_id"]    = $this->loginMedia["id"];
        $data["update_time"] = time();
        parent::insert($data);
    }

    /**
     * 编辑单文章界面
     * @param HttpRequest $request
     */
    public function edit(HttpRequest $request) {

        parent::edit($request);

        $this->assign("seoTitle","媒体中心后台管理 - 编辑单文章");
        $this->assign("seoDesc","媒体中心后台管理 - 编辑单文章");
        $this->assign("seoKwords","媒体中心后台管理 编辑单文章");

        $this->setView("article/artone_form");
    }

    /**
     * 更新单文章操作
     * @param HttpRequest $request
     */
    public function update(HttpRequest $request) {

        $id = $request->getParameter("id","intval");
        $data = $request->getParameter("data");
        $data["update_time"] = time();

        parent::update($data,$request);
    }
    /**
     * 快速保存单文章
     * @param HttpRequest $request
     */
    public function quicksave(HttpRequest $request) {

        $ids = $request->getParameter("ids");
        $data = $request->getParameter("data");
        $service = Beans::get($this->getServiceBean());

        $c=0;
        $data["update_time"] = time();
        foreach($ids as $key=>$val){
            $service->update($data[$val],$val);
            $c++;
        }
        //只要一条数据保存成功，则该操作成功
        if ( $c > 0 ) {
            AjaxResult::ajaxResult('ok', '保存成功！');
        } else {
            AjaxResult::ajaxResult('error', '保存失败！');
        }

    }

}
?>
