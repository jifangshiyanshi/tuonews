<?php
/**
 * Created by jifangshiyangshi.
 * User: Administrator
 * Date: 2015/9/10
 * Time: 10:42
 */


namespace models;

use herosphp\model\C_Model;

class FinanceModel extends  C_Model{

    public function __construct(){
        parent::__construct('finance');
    }

}