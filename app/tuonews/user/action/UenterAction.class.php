<?php
/**
 * Created by jifangshiyanshi.
 * User: Administrator
 * Date: 2015/9/9
 * Time: 16:32
 */

namespace user\action;

use common\action\NeedLoginAction;
use herosphp\bean\Beans;
use herosphp\core\Debug;
use herosphp\core\WebApplication;
use herosphp\http\HttpRequest;
use herosphp\utils\AjaxResult;
use herosphp\utils\Page;
use herosphp\core\Controller;

class UenterAction extends Controller{

    public function mediaApply(){

        $this->setView('uenter/uenter_mediaApply');
    }

}