<?php
namespace user\action;

use common\action\CommonAction;
use common\action\NeedLoginAction;
use herosphp\bean\Beans;
use herosphp\core\WebApplication;
use herosphp\http\HttpRequest;

/**
 * 用户站内信 Action
 * @author          yangjian<yangjian102621@163.com>
 */
class MessageAction extends NeedLoginAction {

    private $messageService = null;

    public function C_start() {
        parent::C_start();

        $webApp = WebApplication::getInstance();
        $request = $webApp->getHttpRequest();
        $currentOpt = $request->getAction().'@'.$request->getMethod();
        $this->assign("currentOpt", $currentOpt);

        $this->messageService = Beans::get('user.message.service');
    }

    /**
     * 站内信列表
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {
        $conditions = array('receiver'=>$this->loginUser['id']);
        $items = $this->messageService->getitems($conditions);
        $this->assign('items', $items);
        $this->setView('message/index');
    }
    /**
     * 评论回复通知列表
     * @param HttpRequest $request
     */
    public function comment( HttpRequest $request ) {
        $this->setView('message/comment');
    }

    /**
     * 站内信详情
     * @param HttpRequest $request
     */
    public function detail(HttpRequest $request) {

    }

}
?>
