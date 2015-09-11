<?php

namespace admin\service\interfaces;
use common\service\interfaces\ICommonService;
use herosphp\core\Loader;

Loader::import('common.service.interfaces.ICommonService', IMPORT_APP);

/**
 * 系统频道服务接口
 * Interface IRoleService
 */
interface IChanelService extends ICommonService {

    /**
     * 获取频道缓存
     * @param int $expr 缓存时间
     * @return mixed
     */
    public function getChanelCache($expr=7200);
}