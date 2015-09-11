<?php
namespace admin\action;

use herosphp\bean\Beans;
use herosphp\http\HttpRequest;
use herosphp\utils\AjaxResult;
use herosphp\utils\ArrayUtils;

/**
 * 管理员 Action
 * @author          yangjian<yangjian102621@163.com>
 */
class AdminAction extends CommonAction {

    /**
     * 初始化方法
     */
    public function C_start() {
        parent::C_start();
        $this->setServiceBean('admin.admin.service');
    }

    /**
     * 管理员列表
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {
        parent::index($request);
        $this->setView('admin/admin_index');
        $this->assginRoles();

    }

    /**
     * 添加管理员
     * @param HttpRequest $request
     */
    public function add( HttpRequest $request ) {

        $this->setView('admin/admin_add');
        $this->assginRoles();

    }

    /**
     * 管理员编辑
     * @param HttpRequest $request
     */
    public function edit( HttpRequest $request ) {

        parent::edit($request);
        $this->setView('admin/admin_edit');
        $this->assginRoles();
    }

    /**
     * 添加管理员操作
     * @param HttpRequest $request
     */
    public function insert( HttpRequest $request ) {

        $data = $request->getParameter('data');
        $data['add_time'] = time();
        $data['password'] = md5(md5($data['password']));
        parent::insert($data);
    }

    /**
     * 更新管理员操作
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
     * 注册所有的管理员角色
     */
    private function assginRoles() {

        $service = Beans::get('admin.role.service');
        $roles = $service->getItems(null,'id,name');
        $this->assign('roles', ArrayUtils::changeArrayKey($roles, 'id'));

    }

    /**
     * 修改密码
     * @param HttpRequest $request
     */
    public function password( HttpRequest $request ) {

        $oldpass = $request->getParameter('oldpass', 'trim');
        $password = $request->getParameter('password', 'trim');
        $repass = $request->getParameter('repass', 'trim');

        $adminService = Beans::get($this->getServiceBean());
        if ( $password != $repass ) {
            AjaxResult::ajaxResult('error', '两次输入的密码不一致！');
        }

        //确认原密码是否正确
        $item = $adminService->getItem("password='".md5(md5($oldpass))."'");
        if ( !$item ) {
            AjaxResult::ajaxResult('error', '原密码错误！');
        }

        //更新密码
        $data = array('password' => md5(md5($password)));
        if ( $adminService->update($data, $this->loginUser['id']) ) {
            AjaxResult::ajaxSuccessResult();
        } else {
            AjaxResult::ajaxFailtureResult();
        }
    }

}
?>
