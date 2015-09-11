<?php
namespace common\action;

use herosphp\http\HttpRequest;

/**
 * 提示信息 Action
 * @author          yangjian<yangjian102621@163.com>
 */
class MessageAction extends CommonAction {

    /**
     * 显示提示信息
     * @param HttpRequest $request
     */
    public function show( HttpRequest $request ) {

        $this->assign('type', $request->getParameter('type'));
        $this->assign('message', $request->getParameter('message', 'base64_decode'));
        $this->assign('url', $request->getParameter('url', 'urldecode'));
        $this->setView('message');

    }

}
?>
