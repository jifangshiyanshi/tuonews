<?php
namespace media\action;

use common\action\CommonAction;
use herosphp\bean\Beans;
use herosphp\http\HttpRequest;

/**
 * 媒体管理员邀请激活 Action
 * @author          yangjian<yangjian102621@163.com>
 */
class InviteAction extends CommonAction {

    /**
     * 邀请回调处理页面
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {

        $id = $request->getParameter('id', 'intval');
        $managerService = Beans::get('media.manager.service');
        $manager = $managerService->getItem($id);
        if ( !$manager ) {
            $this->showMessage('warn', '您的邀请链接已失效，请通知媒体管理员重新发送邀请邮件！');
        }

        if ( $manager['status'] != 0 ) {
            $this->showMessage('warn', '您的媒体管理员已经被激活或者被禁用，邀请链接已失效！');
        }

        //__print($manager);die();
        //判断这个管理员的邮箱是否已经注册
        $userService = Beans::get('user.user.service');
        $user = $userService->getItem("email='".trim($manager['email'])."'");

        //获取媒体信息
        $mediaService = Beans::get('media.media.service');
        $media = $mediaService->getItem($manager['media_id'], "name");
        $this->assign('media', $media);

        //如果没有注册，则进入注册模板
        if ( !$user ) {
            $this->setView('media_invite_reg');
        } else {
            //如果用户已经登录，则直接验证
//            $loginUser = $userService->getLoginUser();
//            if ( $loginUser['email'] == $manager['email'] ) {
//                $managerService->set('status', 1, $manager['id']);
//                $this->assign('checked', 1);
//            }
            //否则进入登录认证模板
            $this->setView('media_invite_login');
        }
        $this->assign('mid', $manager['id']);
        $this->assign('email', $manager['email']);
        $this->assign('title', '媒体管理员邀请验证');
    }

}
