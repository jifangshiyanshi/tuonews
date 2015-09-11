<?php
namespace admin\action;

use herosphp\bean\Beans;
use herosphp\http\HttpRequest;
use herosphp\utils\AjaxResult;
use herosphp\utils\ArrayUtils;

/**
 * 系统保留关键字 Action
 * @author          wangyanjun
 * @modify          wangyanjun
 */
class KeywordsAction extends CommonAction {

    /**
     * 初始化方法
     */
    public function C_start() {

        parent::C_start();
        $this->setServiceBean('admin.keywords.service');

        $types = getConfig('system.keywords.type');
        $this->assign('types', $types);

    }

    /**
     * 保留字列表
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {

        $name=$request->getParameter("name");

        //标题筛选
        if ( $name != '' ) {
            $conditions['name'] = '%' . $name . '%';
        }
        $this->setConditions($conditions);
        parent::index($request);

        $adminService = Beans::get('admin.admin.service');
        $admins = $adminService->getItems();

        $admins = ArrayUtils::changeArrayKey($admins, 'id');

        $this->assign("admins", $admins);
        $this->assign('params', $request->getParameters());
        $this->setView('system/keywords_index');

    }

    /**
     * 添加保留字
     * @param HttpRequest $request
     */
    public function add( HttpRequest $request ) {

        $this->setView('system/keywords_add');

    }

    /**
     * 编辑保留字
     * @param HttpRequest $request
     */
    public function edit( HttpRequest $request ) {

        parent::edit($request);
        $this->setView('system/keywords_edit');

    }

    /**
     * 添加保留字操作
     * @param HttpRequest $request
     */
    public function insert( HttpRequest $request ) {

        $data = $request->getParameter('data');
        $data['add_time'] = time();
        $data['userid'] = $this->loginUser["id"];
        parent::insert($data);
    }

    /**
     * 更新保留字操作
     * @param HttpRequest $request
     */
    public function update( HttpRequest $request ) {

        $data = $request->getParameter('data');
        $data['edit_time'] = time();
        $data['edit_user'] = $this->loginUser["id"];
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
