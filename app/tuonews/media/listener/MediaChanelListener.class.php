<?php

namespace media\listener;
use herosphp\bean\Beans;

/**
 * 媒体频道监听服务
 * Class MediaChanelListener
 * @package media\listener
 */
class MediaChanelListener {

    /**
     * 媒体频道删除操作监听
     * @param int $chanelId 媒体频道ID
     * @param boolean $status 操作的结果，默认操作是成功的
     * @return boolean
     */
    public function delete($chanelId, $status=true) {

        if ( $status && $chanelId > 0 ) {

            $conditions = array('media_chanel' => $chanelId);
            //1. 删除当前媒体频道的所有文章
            $articleService = Beans::get('article.article.service');
            return $articleService->deletes($conditions);

        } else {
            return false;
        }

    }

}
