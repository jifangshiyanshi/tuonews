<?php
/**
 * Created by jifangshiyanshi.
 * User: Administrator
 * Date: 2015/9/10
 * Time: 10:36
 */
namespace common\dao;

use common\dao\CommonDao;
use herosphp\core\Loader;

Loader::import('common.dao.CommonDao');

class FinanceDao extends CommonDao {

    public function __construct($financeModel, $commentAssoc=null) {

        $this->setModelDao(Loader::model($financeModel));

    }

}