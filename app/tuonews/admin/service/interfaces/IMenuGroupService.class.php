<?php

namespace admin\service\interfaces;
use common\service\interfaces\ICommonService;
use herosphp\core\Loader;

Loader::import('common.service.interfaces.ICommonService', IMPORT_APP);

/**
 * 后台菜单分组服务接口
 * Interface IMenuService
 */
interface IMenuGroupService extends ICommonService {

    /**
     * 获取分组缓存
     * @return mixed
     */
    public function getGroupCache();
}
?>