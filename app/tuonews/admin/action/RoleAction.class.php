<?php
namespace admin\action;

use herosphp\bean\Beans;
use herosphp\core\Loader;
use herosphp\http\HttpRequest;
use herosphp\utils\AjaxResult;

/**
 * 管理员角色 Action
 * @author          yangjian<yangjian102621@163.com>
 */
class RoleAction extends CommonAction {

    /**
     * 初始化方法
     */
    public function C_start() {
        parent::C_start();
        $this->setServiceBean('admin.role.service');
    }

    /**
     * 角色列表
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {

        $this->setOrder('sort_num ASC');
        parent::index($request);
        $this->setView('admin/role_index');

    }

    /**
     * 添加角色
     * @param HttpRequest $request
     */
    public function add( HttpRequest $request ) {

        $this->setView('admin/role_add');

    }

    /**
     * 角色编辑
     * @param HttpRequest $request
     */
    public function edit( HttpRequest $request ) {

        parent::edit($request);
        $this->setView('admin/role_edit');
    }

    /**
     * 添加角色操作
     * @param HttpRequest $request
     */
    public function insert( HttpRequest $request ) {

        $data = $request->getParameter('data');
        $data['add_time'] = time();
        parent::insert($data);
    }

    /**
     * 更新角色操作
     * @param HttpRequest $request
     */
    public function update( HttpRequest $request ) {

        $data = $request->getParameter('data');
        parent::update($data, $request);

    }

    /**
     * 更改角色权限
     * @param HttpRequest $request
     */
    public function permission(HttpRequest $request) {

        $id = $request->getParameter('id', 'intval');
        if ( $id <= 0 ) {
            $this->showMessage('danger', '参数不合法！');
        }
        $service = Beans::get($this->getServiceBean());
        $item = $service->getItem($id);
        $permissions = cn_json_decode($item['permissions']);
        //加载权限选项
        $permissionOptions = Loader::config('admin', 'permission');

        $this->assign('permissions', $permissions);
        $this->assign('permissionOptions', $permissionOptions);
        $this->assign('item', $item);
        $this->setView('admin/role_permission');
    }

    /**
     * 更新权限
     * @param HttpRequest $request
     */
    public function updatePermission(HttpRequest $request) {

        $id = $request->getParameter('id', 'intval');
        $data = $request->getParameter('data');

        if ( $id <= 0 ) {
            AjaxResult::ajaxResult('error', INVALID_ARGS);
        }

        $service = Beans::get($this->getServiceBean());
        $data = cn_json_encode($data);

        if ( $service->set('permissions', $data, $id) ) {

            $adminService = Beans::get('admin.admin.service');
            $adminService->updateUserPermission($this->loginUser);
            AjaxResult::ajaxSuccessResult();

        } else {
            AjaxResult::ajaxFailtureResult();
        }
    }

}
?>
