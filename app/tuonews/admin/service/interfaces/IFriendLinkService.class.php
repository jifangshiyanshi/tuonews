<?php

namespace admin\service\interfaces;
use common\service\interfaces\ICommonService;
use herosphp\core\Loader;

Loader::import('common.service.interfaces.ICommonService', IMPORT_APP);

/**
 * 系统友情链接服务接口
 * Interface IRoleService
 */
interface IFriendLinkService extends ICommonService {

    const FOOT_LINK_CACHE = 'web_foot_link';

    /**
     * 获取网站底部的友情链接
     * @param int $rows
     * @param string $order
     * @return mixed
     */
    public function getFootLinks($rows=10, $order='sort_num ASC');

    /**
     * 删除底部链接的缓存
     * @return mixed
     */
    public function deleteFootLinkCache();
}
