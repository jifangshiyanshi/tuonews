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
class ChanelAction extends CommonAction {

    private $chanelService;
    /**
     * 初始化方法
     */
    public function C_start() {
        parent::C_start();
        $this->setServiceBean('admin.chanel.service');
        $this->chanelService = Beans::get('admin.chanel.service');
    }

    /**
     * 频道列表
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {

        $result=$this->chanelService->getItems("","id,name,pid,sort_num,add_time","sort_num ASC");
        //提取一级频道
        $topChanels = ArrayUtils::filterArrayByKey('pid', 0, $result);
        foreach ( $topChanels as $key => $value ) {
            $topChanels[$key]['sub'] = ArrayUtils::filterArrayByKey('pid', $value['id'], $result);
        }
        $this->assign("items",$topChanels);
        $this->setView('admin/chanel_index');

    }

    /**
     * 添加频道
     * @param HttpRequest $request
     */
    public function add( HttpRequest $request ) {
        $pid=$request->getParameter("pid","trim");
        if(!empty($pid)){
            $this->assign("pid",$pid);
        }
        $chanels=$this->chanelService->getItems("pid = 0","id,name");

        $this->assign("chanels",$chanels);
        $this->setView('admin/chanel_add');

    }
    /**
     * 添加频道操作
     * @param HttpRequest $request
     */
    public function insert( HttpRequest $request ) {

        $data = $request->getParameter('data');
        $data['add_time']=time();
        parent::insert($data);

    }

    /**
     * 频道编辑
     * @param HttpRequest $request
     */
    public function edit( HttpRequest $request ) {
        $id=$request->getParameter("id","trim");
        parent::edit($request);
        $chanels=$this->chanelService->getItems("pid = 0","id,name");
        if(!empty($id)){
            $sub=$this->chanelService->getItem("id={$id}","id,pid,name");
            $this->assign("pid",$sub["pid"]);
        }
        $this->assign("chanels",$chanels);
        $this->setView('admin/chanel_edit');
    }

    /**
     * 更新频道操作
     * @param HttpRequest $request
     */
    public function update( HttpRequest $request ) {

        $data = $request->getParameter('data');
        $data["add_time"]=time();
        parent::update($data, $request);

    }

}
?>
