<?php
namespace test\action;

use common\action\CommonAction;
use herosphp\bean\Beans;
use herosphp\core\Debug;
use herosphp\http\HttpRequest;

/**
 * 数据库测试
 * @author          yangjian<yangjian102621@163.com>
 */
class DbAction extends CommonAction {

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

        $service = Beans::get('test.test.service');
        $data = array(
            'name' => 'zhangsan',
            'mobile' => '18575670125',
            'email' => '906388445@qq.com'
        );
        $service->beginTransaction();
        $service->beginTransaction();
        $service->beginTransaction();
        $result = $service->add($data);
        $service->commit();
        $service->rollback();
        $service->commit();
        //Debug::printMessage();
        var_dump($result);
        die();

    }

}
?>
