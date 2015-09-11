<?php
namespace media\action;


use herosphp\bean\Beans;
use herosphp\http\HttpRequest;
use herosphp\utils\AjaxResult;

/**
 * 媒体管理员 Action
 * @author          wangyanjun
 */
class ManagerAction extends MediaAction {

    public function C_start(){

        $this->setServiceBean("media.manager.service");
        parent::C_start();
    }
    /**
     * 媒体管理员列表
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {
        $service = Beans::get($this->getServiceBean());
        $items = $service->getItems("media_id=".$this->loginMedia["id"],"id,userid,media_id,role_id,status,email");
        $this->assign("items",$items);

        $this->assign("seoTitle","媒体中心后台管理-媒体管理员列表");
        $this->assign("seoDesc","媒体管理员");
        $this->assign("seoKwords","媒体中心后台管理 媒体管理员");

        $this->setView('manager/index');
    }

    /**
     * 添加媒体管理员
     * @param HttpRequest $request
     */
    public function add(HttpRequest $request) {

        $service = Beans::get("media.managerRole.service");
        $roles = $service->getItems("media_id=".$this->loginMedia["id"],"name,id");
        $this->assign("roles", $roles);

        $this->assign("seoTitle","媒体中心后台管理-媒体管理员");
        $this->assign("seoDesc","媒体管理员 - 添加媒体管理员");
        $this->assign("seoKwords","媒体中心后台管理 添加媒体管理员");

        $this->setView('manager/add');
    }

    /**
     * 添加媒体管理员角色操作
     * @param HttpRequest $request
     */
    public function insert(HttpRequest $request) {

        $data = $request->getParameter("data");
        $data["auth_time"] = time();
        $data["media_id"] = $this->loginMedia["id"];
        $data["status"] = 0;

        //如果邮箱已经注册过，则自动获取用户ID
        $userService = Beans::get('user.user.service');
        $user = $userService->getItem(array('email' => $data['email']), 'id');
        if ( $user ) {
            $data['userid'] = $user['id'];
        }

        $service = Beans::get($this->getServiceBean());
        $success = $service->add($data);
        if ( $success ) {

            //获取角色
            $roleService = Beans::get("media.managerRole.service");
            $role = $roleService->getItem($data['role_id']);
            $param = array(
                '{role}' => $role['name'],
                '{id}' => $success,
            );
            //发送邀请邀请邮件
            $emailService = Beans::get('common.email.service');
            $emailService->sendTemplateEmail($data['email'], 'manager_invitation_email', $param);
            AjaxResult::ajaxResult('ok', '已发送邮件到被邀请者邮箱中，请通知被邀请者2个小时内完成验证！');
        } else {
            AjaxResult::ajaxFailtureResult();
        }
    }

    /**
     * 编辑媒体管理员角色界面
     * @param HttpRequest $request
     */
    public function edit(HttpRequest $request) {

        //获取管理员角色
        $service = Beans::get("media.managerRole.service");
        $roles = $service->getItems("media_id=".$this->loginMedia["id"],"id,name");
        $this->assign("roles", $roles);
        parent::edit($request);

        $this->assign("seoTitle","媒体中心后台管理-媒体管理员");
        $this->assign("seoDesc","媒体管理员 - 编辑媒体管理员");
        $this->assign("seoKwords","媒体中心后台管理 编辑媒体管理员");

        $this->setView('manager/edit');

    }

    /**
     * @param HttpRequest $request
     */
    public function update(HttpRequest $request) {

        $data = $request->getParameter('data');
        parent::update($data, $request);

    }

}
?>
