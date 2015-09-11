<?php

namespace media\service\interfaces;

use common\service\interfaces\ICommonService;
use herosphp\core\Loader;

Loader::import('common.service.interfaces.ICommonService', IMPORT_APP);

/**
 * 媒体管理员服务接口
 * Interface IMediaTypeService
 */
interface IMediaManagerService extends ICommonService {

    /**
     * 获取管理员用户在某个媒体中的菜单
     * @param int $userid 用户ID
     * @param int $mediaId 媒体ID
     * @return mixed
     */
    public function getUserMenu($userid, $mediaId);

    /**
     * 获取指定用户在指定媒体中的权限
     * @param $userid 用户ID
     * @param $mediaId 媒体ID
     * @return mixed
     */
    public function getUserPermission($userid, $mediaId);

    /**
     * 判断某个操作是否有权限
     * @param $opt
     * @param $userid
     * @return mixed
     */
    public function hasPermission($opt, $userid);
}