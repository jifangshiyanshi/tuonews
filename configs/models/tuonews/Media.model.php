<?php
/**
 * 媒体用户Model
 * @author  yangjian <yangjian102621@163.com>
 */

namespace models;

use herosphp\core\Loader;
use herosphp\model\C_Model;

Loader::import('filter.Filter', IMPORT_FRAME);

class MediaModel extends C_Model {

    public function __construct() {

        parent::__construct('media');
        $this->setPrimaryKey('id');

        //初始化数据模型过滤器
        $filterMap = array(
            'name' => array(DFILTER_STRING, array(1, 20), DFILTER_SANITIZE_TRIM, '媒体名称'),
            'nickname' => array(DFILTER_STRING, array(1, 20), DFILTER_SANITIZE_TRIM, '媒体昵称'),
            'reg_name' => array(DFILTER_STRING, array(1, 20), DFILTER_SANITIZE_TRIM, '登记人'),
            'reg_id' => array(DFILTER_IDENTIRY, null, DFILTER_SANITIZE_TRIM, '登记人身份证号码'),
            'company' => array(null, array(1, 20), DFILTER_SANITIZE_TRIM, '组织机构全称'),
            'company_code' => array(null, array(1, 30), DFILTER_SANITIZE_TRIM, '组织机构代码'),
            'address' => array(null, array(1, 50), DFILTER_SANITIZE_TRIM, '公司地址'),
            'telephone' => array(null, array(1, 20), DFILTER_SANITIZE_TRIM, '固定电话'),
            'mobile' => array(DFILTER_MOBILE, null, DFILTER_SANITIZE_TRIM, '手机号码'),
            'domain' => array(null, null, DFILTER_SANITIZE_TRIM, '独立域名'),
            'intro' => array(DFILTER_STRING, array(0,60), DFILTER_MAGIC_QUOTES, '媒体简介'),
            'email' => array(DFILTER_EMAIL, array(1,30), DFILTER_SANITIZE_TRIM, '电子邮箱'),
        );
        $this->setFilterMap($filterMap);
    }
}
