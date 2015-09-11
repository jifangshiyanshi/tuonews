<?php
namespace admin\action;

use herosphp\bean\Beans;
use herosphp\http\HttpRequest;
use herosphp\utils\AjaxResult;
use herosphp\utils\ArrayUtils;

/**
 * 用户 Action
 * @author          wangyanjun
 */
class FriendlinkAction extends CommonAction {

    private $friendlink;
    /**
     * 初始化方法
     */
    public function C_start() {
        parent::C_start();
        $this->setServiceBean('admin.friendlink.service');
        $this->friendlink = Beans::get('admin.friendlink.service');
    }

    /**
     * 频道列表
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {

        $chanelService=Beans::get("admin.chanel.service");
        $chanels = $chanelService->getItems(null, "id,name");
        $this->assign("chanels", ArrayUtils::changeArrayKey($chanels, 'id'));
        $this->setOrder('sort_num ASC');
        parent::index($request);
        $this->setView('admin/friendlink_index');

    }

    /**
     * 添加友情链接
     * @param HttpRequest $request
     */
    public function add( HttpRequest $request ) {

        $friendlinks=$this->friendlink->getItems("id = 0","id,name");
        $chanelService=Beans::get("admin.chanel.service");
        $chanels=$chanelService->getItems("pid = 0","id,name");
        $strIds="";
        foreach($chanels as $key=>$val){
            $strIds .= $val["id"].",";
        }
        $str=trim($strIds,",");
        $subChanels=$chanelService->getItems("pid in ({$str})","id,pid,name");
        $this->assign("sub",$subChanels);
        $this->assign("friendlinks",$friendlinks);
        $this->setView('admin/friendlink_add');
    }
    /**
     * 添加频道操作
     * @param HttpRequest $request
     */
    public function insert( HttpRequest $request ) {

        $data = $request->getParameter('data');
        $service = Beans::get($this->getServiceBean());

        if ( $service->add($data) ) {
            AjaxResult::ajaxSuccessResult();
        } else {
            AjaxResult::ajaxFailtureResult();
        }

    }

    /**
     * 频道编辑
     * @param HttpRequest $request
     */
    public function edit( HttpRequest $request ) {
        $fid=$request->getParameter("id","trim");
        parent::edit($request);
        $chanelService=Beans::get("admin.chanel.service");
        $friendlink=$this->friendlink->getItem("id={$fid}","chanel_id");
        $chanels=$chanelService->getItems("pid = 0","id,name");
        $strIds="";
        foreach($chanels as $key=>$val){
            $strIds .= $val["id"].",";
        }
        $str=trim($strIds,",");
        $subChanels=$chanelService->getItems("pid in ({$str})","id,pid,name");
        $this->assign("subChanels",$subChanels);
        $this->assign("friendlink",$friendlink);
        $this->setView('admin/friendlink_edit');
    }

    /**
     * 更新频道操作
     * @param HttpRequest $request
     */
    public function update( HttpRequest $request ) {

        $data = $request->getParameter('data');

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
     * 批量删除友情链接
     * @param HttpRequest $request
     */
    public function deletes( HttpRequest $request ) {

        $ids = $request->getParameter('ids');
        if ( count($ids) == 0 ) {
            AjaxResult::ajaxResult('error', '您没有删除任何记录！');
        }

        $service = Beans::get($this->getServiceBean());
        if ( $service->deletes($ids) ) {
            AjaxResult::ajaxSuccessResult();
        } else {
            AjaxResult::ajaxFailtureResult();
        }

    }
}
?>
