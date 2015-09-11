<?php
namespace test\action;

use common\action\CommonAction;
use herosphp\bean\Beans;
use herosphp\core\Controller;
use herosphp\core\Debug;
use herosphp\http\HttpRequest;

/**
 * 测试 Action
 * @author          yangjian<yangjian102621@163.com>
 */
class TestAction extends Controller {

    /**
     * 加载编辑器
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {

        __print($request->getParameters());
        die();

    }

}
?>
