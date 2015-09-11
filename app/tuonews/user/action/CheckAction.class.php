<?php
namespace user\action;

use common\action\NeedLoginAction;
use herosphp\http\HttpRequest;

/**
 * 用户验证 Action
 * 处理用户的手机邮箱验证逻辑操作
 * @author          yangjian<yangjian102621@163.com>
 */
class CheckAction extends NeedLoginAction {

    /**
     * 邮箱验证页面
     * @param HttpRequest $request
     */
    public function email( HttpRequest $request ) {

    }

    /**
     * 邮箱绑定操作
     * @param HttpRequest $request
     */
    public function bindEmail(HttpRequest $request) {

    }

    /**
     * 手机验证页面
     * @param HttpRequest $request
     */
    public function mobile(HttpRequest $request) {

    }

    /**
     * 绑定手机操作
     * @param HttpRequest $request
     */
    public function bindMobile(HttpRequest $request) {

    }

}
?>
