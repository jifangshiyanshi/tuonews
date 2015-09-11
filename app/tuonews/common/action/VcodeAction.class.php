<?php
namespace common\action;

use herosphp\core\Controller;
use herosphp\http\HttpRequest;
use herosphp\session\Session;
use herosphp\utils\VerifyCode;

/**
 * 验证码 Action
 * @author          yangjian<yangjian102621@163.com>
 */
class VCodeAction extends Controller {

    /**
     * 显示验证码
     * @param HttpRequest $request
     */
    public function show(HttpRequest $request){

        $size = $request->getParameter('size', 'trim');
        $ext = $request->getParameter('ext', 'trim');
        $charNum = $request->getParameter('charnum', 'intval');
        if ( !$charNum ) $charNum = 4;
        if ( !$ext ) $ext = 'gif';
        $config = array('x'=>10, 'y'=>20, 'w'=>24*$charNum, 'h'=>30, 'f'=>18);
        if ( $size == 'big' ) {
            $config = array('x'=>15, 'y'=>30, 'w'=>26*$charNum, 'h'=>45, 'f'=>22);
        }

        $_verify = VerifyCode::getInstance();
        $_vcode = $_verify->configure($config)->generate($charNum);
        Session::start();
        $_SESSION['scode'] = strtoupper($_vcode);
        $_verify->show($ext);
        exit();
    }
}

