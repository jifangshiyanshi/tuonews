<?php

namespace media\service\interfaces;

use common\service\interfaces\ICommonService;
use herosphp\core\Loader;

Loader::import('common.service.interfaces.ICommonService', IMPORT_APP);

/**
 * 媒体友情链接服务接口
 * Interface IMediaFriendLinkService
 */
interface IMediaFriendLinkService extends ICommonService {

    /**
     * 获取媒体的友情链接(带缓存)
     * @param $mediaId
     * @return mixed
     */
    public function getMediaFriendLinks($mediaId);
}
?>
