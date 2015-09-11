<?php
namespace media\action;

use herosphp\bean\Beans;
use herosphp\http\HttpRequest;
use herosphp\utils\AjaxResult;

/**
 * 导航 Action
 */
class NavAction extends MediaAction {

    public function C_start(){

        $this->setServiceBean("media.chanel.service");
        parent::C_start();
    }
    /**
     * 导航列表
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {

        $service = Beans::get($this->getServiceBean());
        $conditions = array('media_id' => $this->loginMedia['id'],"id,name,sort_num,add_time");
        $navList = $service->getItems($conditions);
        $this->assign("items",$navList);

        $this->assign("seoTitle","媒体中心后台管理-导航栏列表");
        $this->assign("seoDesc","导航栏");
        $this->assign("seoKwords","媒体中心后台管理 导航栏");

        $this->setView('system/nav_list');
    }

    /*
    * 添加导航
    *@param HttpRequest $request
    */
    public function navAdd( HttpRequest $request ) {

        $this->assign("seoTitle","媒体中心后台管理-添加导航栏");
        $this->assign("seoDesc","导航栏 - 添加导航栏");
        $this->assign("seoKwords","媒体中心后台管理 添加导航栏");

        $this->setView('system/nav_form');
    }

    /**
     * 添加数据
     * @param HttpRequest $request
     */
    public function insert( HttpRequest $request){

        $data=$request->getParameter("data");
        $data["add_time"] = time();
        $data["userid"] = $this->loginUser["id"];
        $data["media_id"] = $this->loginMedia["id"];
        $data["isystem"] = 0;

        parent::insert($data,$request);
    }
    /*
    * 修改导航
    *@param HttpRequest $request
    */
    public function navEdit( HttpRequest $request ) {

        parent::edit($request);

        $this->assign("seoTitle","媒体中心后台管理-编辑导航栏");
        $this->assign("seoDesc","导航栏 编辑导航栏");
        $this->assign("seoKwords","媒体中心后台管理 编辑导航栏");

        $this->setView('system/nav_form');
    }

    /*
    * 删除导航
    *@param HttpRequest $request
    */
    public function del( HttpRequest $request ) {

        parent::delete($request);
    }

    /**
     * 快速保存
     * @param HttpRequest $request
     */
    public function update ( HttpRequest $request){
        $data = $request->getParameter("data");
        $ids = $request->getParameter("ids");
        $edit_id = $request->getParameter("edit_id","intval");
        $service = Beans::get($this->getServiceBean());
        $counter = 0;
        if(empty($edit_id)){
            foreach($ids as $key=>$val){
                if ( $service->update($data[$val], $val) ) {
                    $counter++;
                }
            }
        }else{
            $service->update($data, $edit_id);
            $counter++;
        }

        //只要一条数据保存成功，则该操作成功
        if ( $counter > 0 ) {
            AjaxResult::ajaxResult('ok', '保存成功！');
        } else {
            AjaxResult::ajaxResult('error', '保存失败！');
        }
    }
     /*
    * 导航详细信息
    *@param HttpRequest $request
    */
    public function navDetail( HttpRequest $request ) {

        parent::edit($request);

        $this->assign("seoTitle","媒体中心后台管理-查看导航栏");
        $this->assign("seoDesc","导航栏 查看导航栏");
        $this->assign("seoKwords","媒体中心后台管理 查看导航栏");

        $this->setView('system/nav_detail');
    }

}
?>
