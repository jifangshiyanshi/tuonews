<?php

namespace user\listener;
use herosphp\bean\Beans;
use herosphp\utils\WebUtils;

/**
 * 用户监听服务
 * Class UserListener
 * @package user\listener
 */
class UserListener {

    /**
     * 用户登录操作监听
     * @param int $userid 用户ID
     * @param boolean $status 操作的结果，默认操作是成功的
     */
    public function login($userid, $status=true) {

        //登录成功
        if ( $status ) {
            //记录最后一次登录ip和登录时间
            $data = array(
                'last_login_ip' => WebUtils::getClientIP(),
                'last_login_time' => time()
            );
            $userService = Beans::get('user.user.service');
            $userService->update($data, $userid);
        }
        //do something after the user has logined
    }

    /**
     * 用户注册操作监听
     * @param int $userid 用户ID
     * @param boolean $status 操作的结果，默认操作是成功的
     */
    public function register($userid, $status=true) {

    }

    /**
     * 用户删除操作监听
     * @param int $userid 用户ID
     * @param boolean $status 操作的结果，默认操作是成功的
     * @return boolean
     */
    public function delete($userid, $status=true) {

        if ( $status && $userid > 0 ) {
            $conditions = array('userid' => $userid);
            //1.删除用户添加的媒体
            $mediaService = Beans::get('media.media.service');
            $opt_1 = $mediaService->deletes($conditions);

            //2.删除用户的爆料
            $tipoffService = Beans::get('tipoff.tipoff.service');
            $opt_2 = $tipoffService->deletes($conditions);

            //3.删除用户图片
            $imageService = Beans::get('image.image.service');
            $opt_3 = $imageService->deletes($conditions);

            //4.删除用户所有的短消息
            $messageService = Beans::get('user.message.service');
            $opt_4 = $messageService->deletes(array('receiver' => $userid));

            //5.删除所有的用户收藏文章
            $collectService = Beans::get('user.collect.service');
            $opt_5 = $collectService->deletes($conditions);

            //4. 删除当前媒体所有的管理员管用户
            $managerService = Beans::get('media.manager.service');
            $opt_6 = $managerService->deletes($conditions);

            //所头操作成功后才算成功
            return ($opt_1 && $opt_2 && $opt_3 && $opt_4 && $opt_5 && $opt_6);

        } else {
            return false;
        }
    }

}