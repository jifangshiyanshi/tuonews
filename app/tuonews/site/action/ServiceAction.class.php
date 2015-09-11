<?php
namespace site\action;

use herosphp\bean\Beans;
use herosphp\http\HttpRequest;
use herosphp\core\Loader;
Loader::import('site.action.CommonAction', IMPORT_APP);
/**
 * 媒体站服务 Action
 * @author          yangjian<yangjian102621@163.com>
 */
class ServiceAction extends CommonAction {

    public function index( HttpRequest $request) {

        $id = $request->getParameter("id", "intval");
        if ( $id <= 0 ) page404();

        $artoneService = Beans::get("artone.artone.service");
        $condi = array('id' => $id, 'media_id' => $this->loginMedia['id']);
        $item = $artoneService->getItem($condi);

        $this->assign('item', $item);
        $this->setView("service");
    }

}
