<?php
namespace admin\action;

use herosphp\bean\Beans;
use herosphp\http\HttpRequest;
use herosphp\utils\AjaxResult;

/**
 * 用户 Action
 * @author
 * @modify          wangyanjun
 */
class mediaTypeAction extends CommonAction {

    /**
     * 初始化方法
     */
    public function C_start() {
        parent::C_start();
        $this->setServiceBean('media.type.service');
    }

    /**
     * 用户列表
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {

        parent::index($request);
        $this->setView('media/mediaType_index');

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
     * 添加会员
     * @param HttpRequest $request
     */
    public function add( HttpRequest $request ) {

        $this->setView('media/mediaType_add');

    }

    /**
     * 会员编辑
     * @param HttpRequest $request
     */
    public function edit( HttpRequest $request ) {

        parent::edit($request);
        $this->setView('media/mediaType_edit');
    }

    /**
     * 添加会员操作
     * @param HttpRequest $request
     */
    public function insert( HttpRequest $request ) {

        $data = $request->getParameter('data');
        $data['add_time'] = time();

        parent::insert($data);
    }

    /**
     * 更新会员操作
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
}
?>
