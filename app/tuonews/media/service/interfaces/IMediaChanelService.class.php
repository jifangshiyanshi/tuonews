<?php

namespace media\service\interfaces;

use common\service\interfaces\ICommonService;
use herosphp\core\Loader;

Loader::import('common.service.interfaces.ICommonService', IMPORT_APP);

/**
 * 媒体频道服务接口
 * Interface IMediaChanelService
 */
interface IMediaChanelService extends ICommonService {

    /**
     * 获取频道缓存
     * @param $mediaId
     * @return mixed
     */
    public function getChanelCache($mediaId);
}
?>
