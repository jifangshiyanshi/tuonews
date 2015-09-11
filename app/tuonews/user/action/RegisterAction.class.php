<?php
namespace user\action;

use common\action\CommonAction;
use herosphp\bean\Beans;
use herosphp\cache\CacheFactory;
use herosphp\core\Debug;
use herosphp\http\HttpClient;
use herosphp\http\HttpRequest;
use herosphp\session\Session;
use herosphp\utils\AjaxResult;

/**
 * 用户注册 Action
 * @author          yangjian<yangjian102621@163.com>
 */
class RegisterAction extends CommonAction {

    /**
     * 用户注册界面
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {

        //获取友情链接
        $friendLinkService = Beans::get('admin.friendlink.service');
        $friendLinks = $friendLinkService->getFootLinks(40);
        $this->assign('friendLinks', $friendLinks);
        
        //获取底部导航
        $artoneService = Beans::get('artone.artone.service');
        $footNavis = $artoneService->getFootNavis(6, 'site_bottom', 'sort_num ASC');
        $this->assign('footNavis', $footNavis);        
        
        $this->assign('seoTitle', '驼牛网-用户注册');
	$this->setView('reg');
    }

    /**
     * 邮件注册操作
     * @param HttpRequest $request
     */
    public function emailReg(HttpRequest $request) {

        $scode = $request->getParameter('scode', 'trim');
        $data = $request->getParameter('data');
        $repass = $request->getParameter('repass', 'trim');
        //邀请注册的用户的授权码
        $authcode = $request->getParameter('authcode', 'trim');

        if ( $repass != trim($data['password']) ) {
            AjaxResult::ajaxResult('error', '两次输入密码不一致！');
        }

        if ( strlen($data['password']) > 20 || strlen($data['password']) < 6 ) {
            AjaxResult::ajaxResult('error', '密码的长度必须在6-20位之间！');
        }
        //验证码验证
        Session::start();
        if ( $_SESSION['scode'] != strtoupper($scode) ) {
            AjaxResult::ajaxResult('error', '验证码错误!');
        }

        $userService = Beans::get('user.user.service');
        //验证邮箱
        if ( $userService->checkField('email', trim($data['email'])) ) {
            AjaxResult::ajaxResult('error', '注册邮箱已经存在，请更换注册邮箱！');
        }

        //验证用户名
        if ( $userService->checkField('username', trim($data['username'])) ) {
            AjaxResult::ajaxResult('error', '用户名已经存在，请更换用户名！');
        }

        //授权码验证
        if ( $authcode != '' ) {
            $__authcode = getEmailCode($data['email']);
            if ( $__authcode != $authcode ) {
                AjaxResult::ajaxResult('error', '授权不正确，请查看邮件重新输入！');
            } else {
                //邮箱验证通过
                $data['email_check'] = 1;
            }
        }

        //初始化信息
        $data['password'] = md5(md5($data['password']));
        $data['nickname'] = $data['username'];
        $data['ischeck'] = 1;
        //分配默认头像
        $data['head'] = '/res/global/images/default_face.jpg';
        $data['add_time'] = time();
        $data['update_time'] = time();
        $data['group_id'] = 1;

        $success = $userService->register($data);
        if ( $success ) {

            //1. 如果是邀请的管理员，则激活管理员
            if ( $authcode != '' ) {

                $managerService = Beans::get('media.manager.service');
                //接收管理员ID
                $mid = $request->getParameter('mid', 'intval');
                $data = array('status' => 1, 'userid' => $success);
                $managerService->update($data, $mid);

                AjaxResult::ajaxResult('ok', url('/user_login_index'));
            } else {

                AjaxResult::ajaxResult('ok', url('/user_register_emailActive/?email='.$data['email']));
            }

        } else {
            AjaxResult::ajaxResult('error', '注册失败');
        }
    }

    /**
     * 手机用户注册
     * @param HttpRequest $request
     */
    public function mobileReg(HttpRequest $request) {

        $authcode = $request->getParameter('authcode', 'trim');
        $data = $request->getParameter('data');
        $repass = $request->getParameter('repass', 'trim');

        if ( $authcode == '' ) {
            AjaxResult::ajaxResult('error', '请输入手机授权码！');
        }

        if ( $repass != trim($data['password']) ) {
            AjaxResult::ajaxResult('error', '两次输入密码不一致！');
        }

        if ( strlen($data['password']) > 20 || strlen($data['password']) < 6 ) {
            AjaxResult::ajaxResult('error', '密码的长度必须在6-20位之间！');
        }

        //获取手机发送的授权码
        $__authcode = getMobileCode($data['mobile']);
        if ( $__authcode != $authcode ) {
            AjaxResult::ajaxResult('error', '手机授权码错误!');
        }

        $userService = Beans::get('user.user.service');
        //验证手机号码
        if ( $userService->checkField('mobile', trim($data['mobile'])) ) {
            AjaxResult::ajaxResult('error', "手机号码{$data['mobile']}已被注册，请更换手机号！");
        }

        //验证用户名
        if ( $userService->checkField('username', trim($data['username'])) ) {
            AjaxResult::ajaxResult('error', '用户名已经存在，请更换用户名！');
        }

        //初始化信息
        $data['password'] = md5(md5($data['password']));
        $data['nickname'] = $data['username'];
        $data['add_time'] = time();
        $data['update_time'] = time();
        $data['group_id'] = 1;
        //手机验证通过
        $data['mobile_check'] = 1;
        $data['ischeck'] = 1;

        $success = $userService->register($data);
        if ( $success ) {
            AjaxResult::ajaxResult('ok', url('/user_login_index'));
        } else {
            AjaxResult::ajaxResult('error', '注册失败');
        }
    }

    /**
     * 第三方注册绑定的时候进行邮箱或者
     * @param HttpRequest $request
     */
    public  function checkThird( HttpRequest $request){

        $username = $request->getParameter("username","trim");
        $userService = Beans::get('user.user.service');
        //验证用户名
        if ( $userService->checkField('username', trim($username)) ) {
            AjaxResult::ajaxResult('error', '用户名已经存在，请更换用户名！');
        }
        AjaxResult::ajaxSuccessResult();
    }

    /**
     *
     * 第三方注册操作
     */
    public function thirdRegister( HttpRequest $request){
        $data = $request->getParameter("data");
        $userService = Beans::get('user.user.service');
        //验证用户名是否存在且为当前第三方绑定
        if ( $userService->checkField('username', trim($data['username'])) ) {
            AjaxResult::ajaxResult('error', '用户名已经存在，请更换用户名或绑定已有账号！');
        }
        //验证邮箱是否存在且为当前第三方绑定
        if ( !empty($data['email']) && $userService->checkField('email', trim($data['email'])) ) {
            AjaxResult::ajaxResult('error', '邮箱已经存在，请更换邮箱或绑定已有账号！');
        }
        //如果已绑定，则直接跳转到登录页面
        if( !empty($data["qq_openid"]) && $userService->checkField("qq_openid",trim($data["qq_openid"]))){
            AjaxResult::ajaxResult('ok', '您已经注册过该账号，请直接登录！');
        }
        if( !empty($data["wx_openid"]) && $userService->checkField("wx_openid",trim($data["wx_openid"]))){
            AjaxResult::ajaxResult('ok', '您已经注册过该账号，请直接登录！');
        }
        if( !empty($data["wb_openid"]) && $userService->checkField("wb_openid",trim($data["wb_openid"]))){
            AjaxResult::ajaxResult('ok', '您已经注册过该账号，请直接登录！');
        }

        //初始化信息
        $data['password'] = md5(md5($data['password']));
        $data['add_time'] = time();
        $data['update_time'] = time();
        $data['mobile_check'] = 0;
        $data['email_check'] = 0;
        $data['ischeck'] = 1;
        $success = $userService->register($data);
        if ( $success ) {
            AjaxResult::ajaxResult('ok',"操作成功");
        } else {
            AjaxResult::ajaxResult('error', '操作失败');
        }
    }


    /**
     * 第三方帐号qq登录返回的信息补全页面
     * @param HttpRequest $request
     */
    public function qqLogin(HttpRequest $request) {
        //应用的APPID
        $app_id = "101219507";
        //应用的APPKEY
        $app_secret = "ac409e266d345dd6c0aa865fbf71ef73";
        //成功授权后的回调地址
        $my_url = "http://www.tuonews.com/user_register_qqLogin";

        //Step1：获取Authorization Code
        $code = $request->getParameter("code","trim");
        $state = $request->getParameter("state","trim");
        $stat = "aa418fb0b8148a18ab7d20637f070933";
        //state参数用于防止CSRF攻击，成功授权后回调时会原样带回
        if(empty($code))
        {
            //拼接URL
            $dialog_url = "https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=".$app_id."&redirect_uri=".urlencode($my_url)."&state=".$stat;
            echo("<script> top.location.href='".$dialog_url."'</script>");
        }
        //Step2：通过Authorization Code获取Access Token
        if($state == $stat)
        {
            //拼接URL
            $token_url = "https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&"
                . "client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url)
                . "&client_secret=" . $app_secret . "&code=" . $code;
            $response = file_get_contents($token_url);
            if (strpos($response, "callback") !== false)
            {
                $lpos = strpos($response, "(");
                $rpos = strrpos($response, ")");
                $response  = substr($response, $lpos + 1, $rpos - $lpos -1);
                $msg = json_decode($response);
                if (isset($msg->error))
                {
                    echo "<h3>error:</h3>" . $msg->error;
                    echo "<h3>msg  :</h3>" . $msg->error_description;
                    exit;
                }
            }

            //Step3：使用Access Token来获取用户的OpenID
            $params = array();
            parse_str($response, $params);
            $graph_url = "https://graph.qq.com/oauth2.0/me?access_token=".$params['access_token'];
            $str  = file_get_contents($graph_url);
            if (strpos($str, "callback") !== false)
            {
                $lpos = strpos($str, "(");
                $rpos = strrpos($str, ")");
                $str  = substr($str, $lpos + 1, $rpos - $lpos -1);
            }
            $user = json_decode($str);
            if (isset($user->error))
            {
                echo "<h3>error:</h3>" . $user->error;
                echo "<h3>msg  :</h3>" . $user->error_description;
                exit;
            }
            $url_openid="https://graph.qq.com/user/get_user_info?access_token=".$params['access_token']."&oauth_consumer_key=101219507&openid=".$user->openid;
            $userTmpInfo = file_get_contents($url_openid);
            $userqqInfo=json_decode($userTmpInfo,true);
            $userqqInfo["openid"]=$user->openid;
            //如果openid在数据库中存在，则说明已经用这个账号注册过，直接跳转到登陆页面即可
            $userService = Beans::get('user.user.service');
            $openInfo=$userService->getItem("qq_openid = '{$user->openid}'","*");

            if(!empty($openInfo)){
                //登录成功，清空登录失败的记录
                if ( $openInfo['ischeck'] == 2 ) {
                    AjaxResult::ajaxResult('error', '您的帐号被封号，请联系管理员！');
                }
                $userService->setLoginUser($openInfo);
                $this->location(url('/user_ucenter_profile'));
            }
            $this->assign("qqsign",true);
            $this->assign("userqqInfo",$userqqInfo);
            $this->setView("login_other");
        }else{
            echo("The state does not match. You may be a victim of CSRF.");
        }
    }

    /**
     * 第三方帐号微信登录返回的信息补全页面
     * @param HttpRequest $request
     */
    public function wxLogin(HttpRequest $request) {
        $code = $request->getParameter("code");
        if (isset($code)){
            //获取token
            $url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx7d39eff604ea2001&secret=25c4b7ba487bd16e8419c2a94f5cebba&code=".$code."&grant_type=authorization_code";
            $res = file_get_contents($url);
            $res = json_decode($res, true);
            $token  = $res["access_token"];
            $openid = $res['openid'];
        }else{
            echo "NO CODE";
        }

        $url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$token."&openid=".$openid;
        $res = file_get_contents($url);
        $row=json_decode($res, true);
        if ($row['openid']) {
            $userService = Beans::get('user.user.service');
            $openInfo=$userService->getItem("wx_openid = '{$openid}'","*");

            if(!empty($openInfo)){
                //登录成功，清空登录失败的记录
                if ( $openInfo['ischeck'] == 2 ) {
                    AjaxResult::ajaxResult('error', '您的帐号被封号，请联系管理员！');
                }
                $userService->setLoginUser($openInfo);
                $this->location(url('/user_ucenter_profile'));
            }
            $this->assign("wxsign",true);
            $this->assign("userwxInfo",$row);
            $this->setView("login_other");
        }else{
            die('授权出错,请重新授权');
        }
    }

    /**
     * 第三方帐号微博登录返回的信息补全页面
     * @param HttpRequest $request
     */
    public function wbLogin(HttpRequest $request) {

        $code = $request->getParameter("code");
        if(!empty($code)){
            //$url = "https://api.weibo.com/oauth2/access_token";
            $url = "https://api.weibo.com/oauth2/access_token?client_id=1725858045&client_secret=9ebb3937eefbb4cdeaf446a31e21b979&grant_type=authorization_code&redirect_uri=http://www.tuonews.com/wbLogin.php&code=".$code;
            $httpWb = new HttpClient();
            $tokens = $httpWb->post($url);
            $tokenTmp = json_decode($tokens,true);
            $token  = $tokenTmp["access_token"];
            //获取用户uid
            $url_uid = "https://api.weibo.com/oauth2/get_token_info";
            $uidds = $httpWb->post($url_uid,array("access_token" => $token));
            $uidtmp = json_decode($uidds,true);
            $uid = $uidtmp["uid"];
            //获取用户信息
            $url_user = "https://api.weibo.com/2/users/show.json?access_token=".$token."&uid=".$uid;
            $usertmp  = file_get_contents($url_user);
            $userInfo=json_decode($usertmp,true);
            //如果openid在数据库中存在，则说明已经用这个账号注册过，直接跳转到登陆页面即可
            $userService = Beans::get('user.user.service');
            $openInfo=$userService->getItem("wb_openid = '{$userInfo["id"]}'","*");

            if(!empty($openInfo)){
                //登录成功，清空登录失败的记录
                if ( $openInfo['ischeck'] == 2 ) {
                    AjaxResult::ajaxResult('error', '您的帐号被封号，请联系管理员！');
                }
                $userService->setLoginUser($openInfo);
                $this->location(url('/user_ucenter_profile'));
            }
            $this->assign("wbsign",true);
            $this->assign("userwbInfo",$userInfo);
            $this->setView("login_other");
        }else{
            echo "授权出错，请重新授权";
        }

    }


    /**
     * 邮箱激活界面
     * @param HttpRequest $request
     */
    public function emailActive(HttpRequest $request) {

        //接收邮箱地址
        $email = $request->getParameter('email', 'trim');

        $userService = Beans::get('user.user.service');
        $user = $userService->getItem("email='{$email}'");
        //缓存需要发送邮件的信息
        $CACHER = CacheFactory::create('file');
        $key = 'register_'.trim($email);
        $CACHER->set($key, $user);

        $this->assign('email', $email);
        $this->assign('template', 'register_email_active');
        $this->setView('email_active');

    }

    /**
     * 邮箱激活页面验证
     * @param HttpRequest $request
     */
    public function emailActiveCheck(HttpRequest $request) {

        $userid = $request->getParameter('userid', 'intval');
        $authcode = $request->getParameter('authcode', 'trim');

        $userService = Beans::get('user.user.service');
        $user = $userService->getItem($userid);

        $__authcode = getEmailCode($user['email']);
        if ( $__authcode != $authcode ) {
            $this->assign('message', '您的激活链接已失效，请重新发送激活邮箱');
        } else {

            if ( $userService->set('email_check', 1, $userid) ) {
                $this->assign('message', '您的邮箱已经成功激活！ <a class="red_btn" href="'.url('/user_login_index').'">马上登录</a>');
            }
        }
        $this->setView('email_active_check');
    }

}
?>
