<?php

namespace admin\service\interfaces;
use common\service\interfaces\ICommonService;
use herosphp\core\Loader;

Loader::import('common.service.interfaces.ICommonService', IMPORT_APP);

/**
 * 后台菜单服务接口
 * Interface IMenuService
 */
interface IMenuService extends ICommonService {

    /**
     * 获取菜单缓存
     * @return mixed
     */
    public function getMenuCache();

    /**
     * 更新菜单缓存
     * @return mixed
     */
    public function updateMenuCache();

    /**
     * 根据用户获取菜单
     * @param $user
     * @return mixed
     */
    public function getMenuByUser($user);
}
?>