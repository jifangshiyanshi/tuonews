<?php

namespace media\listener;
use herosphp\bean\Beans;

/**
 * 媒体监听服务
 * Class MediaListener
 * @package media\listener
 */
class MediaListener {

    /**
     * 开通媒体站
     * @param array $media 媒体
     * @param bool $status 操作的结果，默认操作是成功的
     * @return bool
     */
    public function openSite($media, $status=true) {

        if ( !$status ) return false;
        //1. 创建默认的媒体频道，牛讯，牛稿，牛说
        $mediaChanelService = Beans::get('media.chanel.service');
        $data = array(
            'pid' => 0,
            'name' => '牛讯',
            'userid' => $media['userid'],
            'media_id' => $media['id'],
            'isystem' => 1,
            'add_time' => time(),
            'sort_num' => 1,
        );
        $opt_1 = $mediaChanelService->add($data);

        $data['name'] = '牛稿';
        $data['sort_num'] = 2;
        $opt_2 = $mediaChanelService->add($data);

        $data['name'] = '牛说';
        $data['sort_num'] = 3;
        $opt_3 = $mediaChanelService->add($data);

        //2. 创建媒体的默认超级管理员
        $managerService = Beans::get('media.manager.service');
        $data = array(
            'userid' => $media['userid'],
            'media_id' => $media['id'],
            'role_id' => 0,
            'auth_time' => time(),
            'status' => 1
        );
        $opt_4 = $managerService->add($data);

        return ($opt_2 && $opt_2 && $opt_3 && $opt_4);
    }

    /**
     * 媒体删除操作监听
     * @param int $mediaId 媒体ID
     * @param bool $status 操作的结果，默认操作是成功的
     * @return bool
     */
    public function delete($mediaId, $status=true) {

        if ( $status && $mediaId > 0 ) {
            $conditions = array('media_id' => $mediaId);
            //1. 删除当前媒体的所有频道
            $mediaChanelService = Beans::get('media.chanel.service');
            $opt_1 = $mediaChanelService->deletes($conditions);

            //2. 删除当前媒体的所有的友情链接
            $friendLinkService = Beans::get('media.friendlink.service');
            $opt_2 = $friendLinkService->deletes($conditions);

            //3. 删除当前媒体用户所有的管理员角色
            $managerRoleService = Beans::get('media.managerRole.service');
            $opt_3 = $managerRoleService->deletes($conditions);

            //4. 删除当前媒体所有的管理员管用户
            $managerService = Beans::get('media.manager.service');
            $opt_4 = $managerService->deletes($conditions);

            //5. 删除媒体模板安装记录
            $templateService = Beans::get('media.template.service');
            $opt_5 = $templateService->deletes($conditions);

            //6. 删除媒体订阅
            $orderService = Beans::get('media.order.service');
            $orderService->deletes($conditions);

            //所有的操作都成功了则返回成功
            return ($opt_1 && $opt_2 && $opt_3 && $opt_4 && $opt_5);

        } else {
            return false;
        }

    }

}