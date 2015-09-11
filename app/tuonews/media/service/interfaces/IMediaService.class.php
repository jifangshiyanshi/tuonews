<?php

namespace media\service\interfaces;

use common\service\interfaces\ICommonService;
use herosphp\core\Loader;

Loader::import('common.service.interfaces.ICommonService', IMPORT_APP);

/**
 * 媒体服务接口
 * Interface IMediaService
 */
interface IMediaService extends ICommonService {

    /**
     * 当前登录的媒体的session key
     * @var string
     */
    const SESSION_MEDIA_USER = 'tuonews_media_session_key';

    /**
     * 获取当前登录媒体
     * @return mixed
     */
    public function getLoginMedia();

    /**
     * 更新当前登录媒体
     * @param array $media
     * @return mixed
     */
    public function setLoginMedia($media);

    /**
     * 单独更新media_data表的某个字段的数据
     * 这种情况是如果你只想更新媒体数数据的固定某个字段，而不想更新整个媒体表和媒体数据表
     * @param string $field   要更新的字段
     * @param string $content  字段内容
     * @param int $id 字段ID
     * @return mixed
     */
    public function setMediaData($field, $content, $id);

    /**
     * 开通媒体站
     * @param $conditions
     * @return mixed
     */
    public function openSite($conditions);

    /**
     * 获取推荐位置的媒体
     * @param $rows
     * @param $position
     * @return mixed
     */
    public function getRecommendMedia($rows, $position, $fields=null);

    /**
     * 获取媒体站的首页轮播图
     * @param $mediaId
     * @return mixed
     */
    public function getMediaCarousel($rows, $mediaId);
}
?>
