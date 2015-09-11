<?php
namespace test\action;

use common\action\CommonAction;
use herosphp\bean\Beans;
use herosphp\http\HttpRequest;
use herosphp\utils\Smtp;

/**
 * 邮件测试
 * @author          yangjian<yangjian102621@163.com>
 */
class EmailAction extends CommonAction {

    /**
     * @param HttpRequest $request
     */
    public function index(HttpRequest $request) {

        $emailService = Beans::get('common.email.service');

        //$email = new Smtp('smtp.163.com', 25, 'tuoniuwang@163.com', 'tuoniu123WANG', $_auth = true, $time_out = 30);
        //$result = $email->Send_Mail('906388445@qq.com', 'tuoniuwang@163.com', '测试邮件', '<h1 style="color: #ff0000">HTML测试邮件。Fuck it</h1>', 'html');
        //$result = $emailService->sendEmail('yangjian102621@163.com', '测试邮件', '<h1 style="color: #ff0000">来自驼牛的测试邮件。Fuck it</h1>', 'html');
        $result = $emailService->sendTemplateEmail('yangjian102621@163.com', 'email_reset_password');
        var_dump($result);
        die();

    }

}
?>
