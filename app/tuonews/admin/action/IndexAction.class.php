<?php
namespace admin\action;

use herosphp\http\HttpRequest;

/**
 * 后台管理中心首页Action
 * @author          yangjian<yangjian102621@163.com>
 */
class IndexAction extends CommonAction {

    /**
     * 首页方法
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {

        $this->setView('index');

    }

}
?>
