<?php
/**
 * Created by jifangshiyanshi
 * User: Administrator
 * Date: 2015/9/10
 * Time: 10:27
 */
namespace common\service;

use common\service\CommonService;

class financeService extends  CommonService{


   public function add($data){

      return  $this-> getModelDao() -> add($data);

   }

   public function get($conditions, $fields, $order, $page, $pagesize, $group, $having){
      return $this->getModelDao() ->getItems($conditions, $fields, $order, $page, $pagesize, $group, $having);
   }

   public function count($condi){
      return $this->getModelDao()->count($condi);
   }
}