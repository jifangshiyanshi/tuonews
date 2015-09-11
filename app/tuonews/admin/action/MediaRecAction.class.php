<?php
namespace admin\action;

use herosphp\bean\Beans;
use herosphp\http\HttpRequest;
use herosphp\utils\AjaxResult;

/**
 * 用户 Action
 * @author          wangyanjun
 *
 */
class mediarecAction extends CommonAction {

    /**
     * 初始化方法
     */
    public function C_start() {
        parent::C_start();
        $this->setServiceBean('media.rec.service');
    }

    /**
     * 用户列表
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {

        parent::index($request);
        $this->setView('media/mediaRec_index');

    }

    /**
     * 快速保存
     * @param HttpRequest $request
     */
    public function quicksave( HttpRequest $request ) {

        $hids = $request->getParameter('hids');
        $datas = $request->getParameter('data');
        $service = Beans::get($this->getServiceBean());
        $counter = 0;
        // 保存数据
        foreach ( $hids as $key => $id ) {
            if ( $service->update($datas[$key], $id) ) {
                $counter++;
            }
        }

        //只要一条数据保存成功，则该操作成功
        if ( $counter > 0 ) {
            AjaxResult::ajaxResult('ok', '保存成功！');
        } else {
            AjaxResult::ajaxResult('error', '保存失败！');
        }
    }

    /**
     * 添加媒体推荐位
     * @param HttpRequest $request
     */
    public function add( HttpRequest $request ) {

        $this->setView('media/mediaRec_add');

    }

    /**
     * 媒体推荐位编辑
     * @param HttpRequest $request
     */
    public function edit( HttpRequest $request ) {

        parent::edit($request);
        //获取推荐位置的媒体
        $item = $this->getTemplateVar('item');
        if ( $item['media_ids'] ) {
            $service = Beans::get('media.media.service');
            $medias = $service->getItems(explode(',', $item['media_ids']), 'id,name');
            $this->assign('medias', $medias);
            //组建js对象
            $data = "{";
            foreach ( $medias as $value ) {
                if ( $data == '{' ) {
                    $data .= "'{$value['id']}' : '{$value['name']}'";
                } else {
                    $data .= ", '{$value['id']}' : '{$value['name']}'";
                }
            }
            $data .= '}';
            $this->assign('data', $data);
        }

        $this->setView('media/mediaRec_edit');
    }

    /**
     * 添加媒体推荐位操作
     * @param HttpRequest $request
     */
    public function insert( HttpRequest $request ) {

        $data = $request->getParameter('data');
        $data['add_time'] = time();
        if(strlen($data['sort_num']) > 3) AjaxResult::ajaxResult("error","参数错误");
        parent::insert($data);
    }

    /**
     * 更新媒体推荐位操作
     * @param HttpRequest $request
     */
    public function update( HttpRequest $request ) {

        $data = $request->getParameter('data');

        parent::update($data, $request);

    }

    /**
     * @param HttpRequest $request
     * 删除操作
     */
    public function delete( HttpRequest $request){
        $id=$request->getParameter("id");
        $service = Beans::get($this->getServiceBean());
        if($service->delete($id)){
            AjaxResult::ajaxSuccessResult();
        }else{
            AjaxResult::ajaxFailtureResult();
        }
    }

    /**
     * @param HttpRequest $request
     * 批量删除
     */
    public function deletes(HttpRequest $request){
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

    /**
     * 媒体推荐位管理
     * @param HttpRequest $request
     */
    public function manager( HttpRequest $request ) {

        $id=$request->getParameter("recid","trim");
        $recService=Beans::get($this->getServiceBean());
        //获取所有推荐位的所有推荐媒体id
        $MediaPositions=$recService->getItems("media_ids != '' ",$this->getFields(), $this->getOrder(),
            $this->getPage(), $this->getPagesize(), $this->getGroup(), $this->getHaving());
        $arr=array();
        foreach($MediaPositions as $key=> $val){
            $arr[]=$val["media_ids"];
        }
        $allids=implode(",",$arr);
        //获取某一个推荐位的所有媒体id
        if(!empty($id))
            $MediaIds=$recService->getItem("media_ids != '' AND id=".$id,$this->getFields(), $this->getOrder(),
                $this->getPage(), $this->getPagesize(), $this->getGroup(), $this->getHaving());

        $mediaService=Beans::get("media.media.service");
        //获取媒体列表
        $Ids=empty($MediaIds)?$allids:$MediaIds["media_ids"];
        $items=$mediaService->getItems("id in (".$Ids.")",$this->getFields(), $this->getOrder(),
            $this->getPage(), $this->getPagesize(), $this->getGroup(), $this->getHaving());

        $this->assign("items",$items);
        $this->assign("MediaPositions",$MediaPositions);
        $this->assign('params', $request->getParameters());
        $this->setView('media/mediaRec_manager');


    }
}
?>
