<?php
namespace admin\action;

use herosphp\bean\Beans;
use herosphp\http\HttpRequest;
use herosphp\utils\AjaxResult;

/**
 * 用户 Action
 * @author          wangyanjun
 */
class UserGroupAction extends CommonAction {

    /**
     * 初始化方法
     */
    public function C_start() {
        parent::C_start();
        $this->setServiceBean('user.group.service');
    }

    /**
     * 用户列表
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {

        parent::index($request);
        $this->setView('user/userGroup_index');

    }

    /**
     * 添加会员
     * @param HttpRequest $request
     */
    public function add( HttpRequest $request ) {

        $this->setView('user/userGroup_add');

    }

    /**
     * 会员编辑
     * @param HttpRequest $request
     */
    public function edit( HttpRequest $request ) {

        parent::edit($request);
        $this->setView('user/userGroup_edit');
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
     * 更新会员分组
     * @param HttpRequest $request
     */
    public function update( HttpRequest $request ) {

        $data = $request->getParameter('data');
        $password = $request->getParameter('password', 'trim');
        if ( $password != '' ) {
            $password = md5(md5($password));
            $data['password'] = $password;
        }
        parent::update($data, $request);

    }

    /**
     * @param HttpRequest $request
     * 删除操作
     */
    public function delete( HttpRequest $request){
        $id=$request->getParameter("id");
        $service = Beans::get("user.group.service");
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
