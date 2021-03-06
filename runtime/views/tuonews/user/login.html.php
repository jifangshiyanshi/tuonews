<?php include $this->getIncludePath('common.header')?>
<!--content end-->
<section class="content">
    <div class="login_tab account_manage">
        <ul class="tab_menu">
            <li class="current">
                登录
                <div class="border_top"></div>
                <div class="border_bottom"></div>
            </li>
        </ul>
        <div class="tab_content">
            <ul class="tab_con">
                <li class="tab_conItem">
                    <div class="login_form">
                        <form method="post" autocomplete="off">
                            <div class="input_wrap">
                                <label class="input_head" for="account">账号:</label>
                                <input class="input" type="text" name="username" id="account" autofocus/>
                            </div>
                            <div class="input_wrap">
                                <label class="input_head" for="pass">密码:</label>
                                <input class="input" type="password" name="password" id="pass"/>
                            </div>
                            <div class="input_wrap control_wrap">
                                <label class="input_head"></label>
                                <label class="auto"><input type="checkbox"/> 两周自动登录</label>
                                <a class="link forget" href="<?php echo url("/user_resetPass_index") ?>">忘记密码？</a>
                            </div>

                            <div style="padding-left:100px; padding-bottom: 10px; font-size: 14px; display: none;">您的帐号没有激活，请狠狠的戳
                                <a href="<?php echo url("/user_register_emailActive/?email=(email)") ?>" id="send_active_email" style="color: #0000cc">发送激活邮件</a></div>
                            <div class="input_wrap">
                                <label class="input_head"></label>
                                <button class="red_btn" type="button" url="<?php echo url("/user_login_signin") ?>"  id="user_login_btn">登录</button>
                            </div>
                        </form>
                    </div>
                    <div class="quick">
                        <div class="link_box">
                            <a class="link" href="<?php echo url("/user_register_index") ?>">注册</a>未有账号？
                        </div>
                        <p class="btn_text">可使用以下账号一键登录</p>
                        <div class="btn_box">
                            <a href="https://api.weibo.com/oauth2/authorize?client_id=1725858045&redirect_uri=http://www.tuonews.com/user_register_wbLogin&response_type=code"><span class="icon icon_weibo"></span></a>
                            <a href="http://openapi.qzone.qq.com/oauth/show?which=ConfirmPage&display=pc&client_id=101219507&redirect_uri=http://www.tuonews.com/user_register_qqLogin?response_type=code&state=aa418fb0b8148a18ab7d20637f070933&scope=get_user_info"><span class="icon icon_qq"></span></a>
                            <a href="https://open.weixin.qq.com/connect/qrconnect?appid=wx7d39eff604ea2001&redirect_uri=http%3A%2F%2Fwww.tuonews.com%2Fuser_register_wxLogin&response_type=code&scope=snsapi_login&state=STATE#wechat_redirect"><span class="icon icon_weixin"></span></a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</section>
<!--content end-->
<?php include $this->getIncludePath('common.footer')?>
