<?php
namespace site\action;

use herosphp\bean\Beans;
use herosphp\http\HttpRequest;
use herosphp\core\Loader;
Loader::import('site.action.CommonAction', IMPORT_APP);
/**
 * 媒体服务 Action
 * @author          yangjian<yangjian102621@163.com>
 */
class MediaAction extends CommonAction {

    public function index( HttpRequest $request) {

        $id = $request->getParameter("id", "intval");

        $url = url("/site_service_index/?id={$id}&media_id=".$this->loginMedia['id']);
        page301($url);

    }

}
