<?php include $this->getIncludePath('common.header')?>
<!--content end-->
<section class="content">
    <div class="reg_tab account_manage">
        <ul class="tab_menu">
            <li class="current">
                邮箱注册
                <div class="border_top"></div>
                <div class="border_bottom"></div>
            </li>
            <li>
                手机
                <div class="border_top"></div>
                <div class="border_bottom"></div>
            </li>
        </ul>
        <div class="tab_content">
            <ul class="tab_con">
                <!-- 邮箱注册 -->
                <li class="tab_conItem">
                    <div class="reg_form">
                        <form action="<?php echo url("/user_register_emailReg") ?>" method="post" id="email_reg_form" autocomplete="off">
                            <div class="input_wrap">
                                <label class="input_head" for="email">邮箱:</label>
                                <input class="input" type="text" name="data[email]" tiptxt="邮箱" dtype="email" id="email" autofocus/>
                            </div>
                            <div class="input_wrap">
                                <label class="input_head" for="ename">用户名:</label>
                                <input class="input" type="text" name="data[username]" tiptxt="用户名" dtype="username" id="ename"/>
                                <span class="tips">4-20位，英文字母、下划线或数字的组合</span>
                            </div>
                            <div class="input_wrap">
                                <label class="input_head" for="epass">密码 </label>
                                <input class="input" type="password" id="epass" tiptxt="密码" name="data[password]"/>
                                <span class="tips">6-20位字母、数字或英文符号，区分大小写</span>
                            </div>
                            <div class="input_wrap">
                                <label class="input_head" for="enotpass">确认密码:</label>
                                <input class="input" type="password" name="repass" tiptxt="确认密码" id="enotpass"/>
                            </div>
                            <div class="input_wrap input_code_wrap">
                                <label class="input_head" for="ecode">验证码:</label>
                                <input class="input small_input" type="text" name="scode" tiptxt="验证码" id="ecode"/>
                                <img src="<?php echo url("/common_vcode_show") ?>" onclick="this.src='<?php echo url("/common_vcode_show") ?>?run='+Math.random();" alt="验证码"/>
                            </div>
                            <div class="input_wrap">
                                <label class="input_head"></label>
                                <button class="red_btn user-reg" data-form="email_reg_form" onclick="return false;">注册</button>
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

                <!-- 手机注册 -->
                <li class="tab_conItem">
                    <div class="reg_form">
                        <form action="<?php echo url("/user_register_mobileReg") ?>" method="post" id="mobile_reg_form" autocomplete="off">
                            <div class="input_wrap">
                                <label class="input_head" for="mobile">手机号:</label>
                                <input class="input" type="text" name="data[mobile]" tiptxt="手机号" dtype="mobile" id="mobile"/>
                            </div>
                            <div class="input_wrap">
                                <label class="input_head" for="msg">短信验证码:</label>
                                <input class="input small_input" type="text" name="authcode" tiptxt="短信验证码" id="msg"/>
                                <button class="gray_btn_fb msg_btn" id="send_mobile_message">点击获取</button>
                            </div>
                            <div class="input_wrap">
                                <label class="input_head" for="tname">用户名:</label>
                                <input class="input" type="text" name="data[username]" tiptxt="用户名" dtype="username" id="tname"/>
                                <span class="tips">6-20位，英文字母、下划线或数字的组合</span>
                            </div>
                            <div class="input_wrap">
                                <label class="input_head" for="tpass">密码 </label>
                                <input class="input" type="password" name="data[password]" tiptxt="密码" id="tpass"/>
                                <span class="tips">6-20位字母、数字或英文符号，区分大小写</span>
                            </div>
                            <div class="input_wrap">
                                <label class="input_head" for="tnotpass">确认密码:</label>
                                <input class="input" type="password" name="repass" tiptxt="确认密码" id="tnotpass"/>
                            </div>
                            <div class="input_wrap">
                                <label class="input_head"></label>
                                <button class="red_btn user-reg" type="submit" data-form="mobile_reg_form" onclick="return false;">注册</button>
                            </div>
                        </form>
                    </div>
                    <div class="quick">
                        <div class="link_box">
                            <a class="link" href="">注册</a>未有账号？
                        </div>
                        <p class="btn_text">可使用以下账号一键登录</p>
                        <div class="btn_box">
                            <a href=""><span class="icon icon_weibo"></span></a>
                            <a href=""><span class="icon icon_qq"></span></a>
                            <a href=""><span class="icon icon_weixin"></span></a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</section>
<!--content end-->
<?php include $this->getIncludePath('common.footer')?>
