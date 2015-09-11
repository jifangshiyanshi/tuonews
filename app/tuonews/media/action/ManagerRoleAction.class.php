<?php
namespace media\action;


use herosphp\bean\Beans;
use herosphp\core\Loader;
use herosphp\http\HttpRequest;

/**
 * 媒体管理员角色 Action
 * @author          yangjian<yangjian102621@163.com>
 */
class ManagerRoleAction extends MediaAction {

    public function C_start(){

        $this->setServiceBean("media.managerRole.service");
        parent::C_start();
    }
    /**
     * 媒体管理员角色列表
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {
        $service = Beans::get($this->getServiceBean());
        $items = $service->getItems("media_id=".$this->loginMedia["id"]);
        $this->assign("items",$items);

        $this->assign("seoTitle","媒体中心后台管理-角色管理");
        $this->assign("seoDesc","角色管理");
        $this->assign("seoKwords","媒体中心后台管理 角色管理");

        $this->setView('role/index');
    }

    /**
     * 添加媒体管理员角色界面
     * @param HttpRequest $request
     */
    public function add(HttpRequest $request) {

        $this->assign("seoTitle","媒体中心后台管理-角色添加");
        $this->assign("seoDesc","角色管理-角色添加");
        $this->assign("seoKwords","媒体中心后台管理 角色管理 角色添加");

        $this->setView('role/add');
    }

    /**
     * 添加媒体管理员角色操作
     * @param HttpRequest $request
     */
    public function insert(HttpRequest $request) {

        $data=$request->getParameter("data");
        $data["name"]=$data["name"];
        $data["add_time"]=time();
        $data["add_userid"]=$this->loginUser["id"];
        $data["media_id"]=$this->loginMedia["id"];
        parent::insert($data);
    }

    /**
     * 编辑媒体管理员角色界面
     * @param HttpRequest $request
     */
    public function edit(HttpRequest $request) {

        parent::edit($request);
        $item = $this->getTemplateVar('item');
        //获取媒体类型
        $mediaTypeService = Beans::get('media.type.service');
        $mediaType = $mediaTypeService->getItem($item['media_type']);
        $permissionTpl = $mediaType['permission_tpl'];

        //加载权限选项
        $permissions = Loader::config($permissionTpl, 'permission');

        $this->assign('permissions', $permissions);
        $item['permission'] = cn_json_decode($item['permission']);
        $this->assign('item', $item);

        $this->assign("seoTitle","媒体中心后台管理-角色编辑");
        $this->assign("seoDesc","角色管理-角色编辑");
        $this->assign("seoKwords","媒体中心后台管理 角色管理 角色编辑");

        $this->setView('role/add');
    }

    /**
     * 更新媒体管理员角色操作
     * @param HttpRequest $request
     */
    public function update(HttpRequest $request) {

        $data = $request->getParameter('data');
        $data['permission'] = cn_json_encode($data['permission']);
        parent::update($data,$request);

    }

}
?>
