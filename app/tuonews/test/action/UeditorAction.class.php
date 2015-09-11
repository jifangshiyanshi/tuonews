<?php
namespace test\action;

use common\action\CommonAction;
use herosphp\http\HttpRequest;

/**
 * 百度编辑器测试
 * @author          yangjian<yangjian102621@163.com>
 */
class UeditorAction extends CommonAction {

    /**
     * 初始化方法
     */
    public function C_start() {
        parent::C_start();
    }

    /**
     * 加载编辑器
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {

    }

    /**
     * 提交表单处理
     * @param HttpRequest $request
     */
    public function action(HttpRequest $request) {

        $content = $request->getParameter('content', 'trim');
        __print($content);die();
    }

    /**
     * 代码高亮显示
     * @param HttpRequest $request
     */
    public function code( HttpRequest $request ) {

    }

}
?>
