<?php
namespace admin\service;

use admin\service\interfaces\IConfigService;
use common\service\CommonService;
use herosphp\core\Loader;

Loader::import('admin.service.interfaces.IConfigService', IMPORT_APP);
Loader::import('common.service.CommonService', IMPORT_APP);

/**
 * 系统配置服务接口实现
 * Class AdminService
 * @package admin\service
 */
class ConfigService extends CommonService implements IConfigService {


    /**
     * @see \admin\service\interfaces\IConfigService::getGroupConfigs()
     */
    public function getGroupConfigs( $groupKey ) {

        $items = $this->getItems("groupkey='{$groupKey}'");
        $result = array();
        foreach ( $items as $value ) {
            $result[$value['varname']] = $value['varval'];
        }

        return $result;

    }

    /**
     * @see \admin\service\interfaces\IConfigService::getVarValue()
     */
    public function getVarValue( $groupKey, $varName ) {

        $item = $this->getItem("groupkey='{$groupKey}' AND varname='{$varName}'", 'varval');
        if ( !$item ) {
            return false;
        } else {
            return $item['varval'];
        }
    }

} 