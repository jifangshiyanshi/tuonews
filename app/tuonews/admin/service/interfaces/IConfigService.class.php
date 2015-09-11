<?php

namespace admin\service\interfaces;
use common\service\interfaces\ICommonService;
use herosphp\core\Loader;

Loader::import('common.service.interfaces.ICommonService', IMPORT_APP);
/**
 * 配置服务接口
 * Interface IConfigService
 */
interface IConfigService extends ICommonService {

    /**
     * 获取指定分组配置，将获取的数据放在一个key=>value数组中返回
     * @param $groupKey
     * @return mixed
     */
    public function getGroupConfigs($groupKey);

    /**
     * 获取指定的配置key的value
     * @param $groupKey
     * @param $varName
     * @return mixed
     */
    public function getVarValue($groupKey, $varName);
}
?>