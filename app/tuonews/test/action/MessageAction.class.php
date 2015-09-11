<?php
namespace test\action;

use common\action\CommonAction;
use herosphp\bean\Beans;
use herosphp\cache\CacheFactory;
use herosphp\http\HttpRequest;

/**
 * 手机短信测试
 * @author          yangjian<yangjian102621@163.com>
 */
class MessageAction extends CommonAction {

    /**
     * @param HttpRequest $request
     */
    public function index(HttpRequest $request) {

        $service = Beans::get('common.mobileMessage.service');
        //发送普通短信
        //$result = $service->sendMessage('18575670125', '驼牛网测试短信');
        //发送模板短信
        $result = $service->sendTemplateMessage('18575670125', 'mobile_reset_password');
        if ( $result ) {
            __print('短信发送成功');
        } else {
            __print($service->getMessage());
        }
        die();
    }

}
?>
