<?php include $this->getIncludePath('user.header')?>
<!--content start-->
<section class="content">
    <?php include $this->getIncludePath('user.module_info_top')?>
    <div class="layoutlm">
        <div class="layout-main">
            <!-- 密码修改-->
            <div class="user_right_layout">
                <ul class="user_right_menu">
                    <li class="current"><a href="">编辑资料</a></li>
                </ul>
                <div class="user_right_content user_right_content_form">
                    <div class="module_form ucenter">
                        <div class="ucenter_edit_box">
                            <div class="edit_btn">编辑<span class="icon icon_edit_down"></span></div>
                            <div class="input_wrap">
                                <span class="input_head">用户头像：</span>
                                <img class="lazy face_img user_head" src="<?php echo getImageThumb($loginUser[head], '106x106') ?>" alt="<?php echo $loginUser[username]?>"/>
                                <span class="tips" style="display:inline-block; width: 300px;">提示：上传图片时，双击裁剪框可以对图片进行裁剪</span>
                            </div>
                            <form class="edit_form" action="" id="update_head_form" autocomplete="off">

                                <div class="input_wrap" style="zoom: 1; overflow: hidden;">
                                    <div>
                                        <input type="hidden" name="data[head]" id="header" tip-text="logo" required/>
                                        <input type="file" id="user_logo"/>
                                        <input type="hidden" id="x" name="x" />
                                        <input type="hidden" id="y" name="y" />
                                        <input type="hidden" id="w" name="w" />
                                        <input type="hidden" id="h" name="h" />
                                        <div style="display: none;">
                                            <img src="" id="crop_target" style="max-width: 1920px;" />
                                        </div>
                                    </div>
                                </div>

                                <div id="preview_box" style="margin-top:10px; display: none; zoom:1; overflow: hidden; margin-bottom: 10px;">
                                    <div class="preview-container">
                                        <img class="preview" id="preview_1" style="max-width: 1920px;" />
                                    </div>

                                    <div class="preview-container" style="border-radius: 50%; margin-left: 10px !important;">
                                        <img class="preview" id="preview_2" style="max-width: 1920px;" />
                                    </div>
                                </div>


                                <button href="<?php echo url("/user_ucenter_update") ?>"  class=" ajaxproxy red_btn save_btn" style="display: none;" data-loading-text=""
                                        proxy='{"formId":"update_head_form", "method":"post", "location":"reload"}'>保存</button>
                            </form>

                        </div>
                        <div class="ucenter_edit_box">
                            <div class="edit_btn">编辑<span class="icon icon_edit_down"></span></div>
                            <div class="input_wrap">
                                <span class="input_head">用户名：</span>

                                <span><?php echo $loginUser['username']?></span>
                            </div>
                            <div class="input_wrap">
                                <span class="input_head">用户类型：</span>
                                <span><?php if ( empty($loginUser['group_id']) ) { ?>普通会员<?php } ?><?php if ( $loginUser['group_id']==1 ) { ?>普通会员<?php } ?><?php if ( $loginUser['group_id']==1 ) { ?>驼牛网认证会员<?php } ?></span>
                            </div>
                            <div class="input_wrap">
                                <span class="input_head">昵称：</span>

                                <span class="nickname" id="nickname"><?php echo $loginUser['nickname']?></span>
                            </div>

                            <form class="edit_form" id="nickname_form" autocomplete="off">
                                <div class="input_wrap">

                                    <label class="input_head input_head_user">昵称：</label>
                                    <input type="text" class="input" name="data[nickname]" value="<?php echo $loginUser[nickname]?>" required min-length="2" tip-text="昵称" max-length="20"/>
                                    <span class="tips">2-20个字，支持中英文和数字</span>
                                </div>

                                <button href="<?php echo url("/user_ucenter_update") ?>"  class=" ajaxproxy red_btn"
                                        proxy='{"formId":"nickname_form", "method":"post","location":"reload"}'>保存</button>
                            </form>

                        </div>

                        <div class="ucenter_edit_box">
                            <div class="edit_btn">编辑<span class="icon icon_edit_down"></span></div>
                            <div class="input_wrap">
                                <div class="input_wrap">
                                    <span class="input_head">绑定手机：</span>
                                    <span class="telephone"><?php echo $loginUser[mobile]?></span>
                                </div>
                            </div>
                            <form class="edit_form" id="bind_mobile_form" autocomplete="off">
                                <div class="des">绑定手机后，可作为驼牛网登录账号</div>
                                <div class="input_wrap">
                                    <span class="input_head" for="pass">驼牛网登录密码：</span>
                                    <input type="password" class="input mobile_pass" name="password" id="pass" tip-text="密码" required/>
                                </div>
                                <div class="input_wrap">
                                    <span class="input_head" for="mobile">手机号码：</span>
                                    <input type="text" class="input" name="mobile" id="mobile" tip-text="手机号码" dtype="mobile" required/>
                                </div>
                                <div class="input_wrap">
                                    <label class="input_head">短信验证码:</label>
                                    <input class="input small_input mobile_code" name="authcode" type="text" tip-text="验证码" dtype="number" required />
                                    <button style="padding: 8px 10px; margin: 0px 10px;" id="bind_mobile_btn" data-email="<?php echo $user[mobile]?>" data-template="bind_user_mobile">点击获取</button>
                                </div>
                                <div class="input_nohead_wrap">
                                    <button href="<?php echo url("/user_ucenter_bindMobile") ?>"  class="ajaxproxy red_btn"
                                            proxy='{"formId":"bind_mobile_form", "method":"post", "location":"reload"}'>保存</button>
                                </div>

                            </form>

                        </div>

                        <div class="ucenter_edit_box">
                            <div class="edit_btn">编辑<span class="icon icon_edit_down"></span></div>
                            <div class="input_wrap">
                                <span class="input_head">绑定邮箱：</span>
                                <span class="email"><?php echo $loginUser[email]?></span>
                            </div>


                            <form class="edit_form" id="bind_email_form" autocomplete="off">
                                <div class="des">绑定邮箱后，可作为驼牛网登录账号（邮箱验证后可使用）</div>
                                <div class="input_wrap">
                                    <span class="input_head">驼牛网登录密码：</span>
                                    <input type="password" class="input email_pass" name="password" value=""/>
                                </div>
                                <div class="input_wrap">
                                    <span class="input_head">输入邮箱：</span>
                                    <input type="text" name="email" id="bind_email" class="input "/>
                                </div>
                                <div class="input_wrap">
                                    <label class="input_head">邮箱验证码:</label>
                                    <input class="input small_input email_code" type="text" name="authcode" />
                                    <button style="padding: 8px 10px; margin: 0px 10px;" id="bind_email_btn" data-template="bind_user_email">点击获取</button>
                                </div>
                                <div class="input_nohead_wrap">
                                    <button href="<?php echo url("/user_ucenter_bindEmail") ?>"  class="ajaxproxy red_btn" data-loading-text=""
                                            proxy='{"formId":"bind_email_form", "method":"post","location":"reload"}'>保存</button>
                                </div>
                            </form>

                        </div>

                        <!--<div class="ucenter_edit_box">-->
                            <!--<div class="edit_btn">编辑<span class="icon icon_edit_down"></span></div>-->
                            <!--<div class="input_wrap input_wrap_bind">-->
                                <!--<span class="input_head">绑定第三方帐号：</span>-->
                                <!--<span class="icon icon_weibo"></span>-->
                                <!--<span class="icon icon_qq"></span>-->
                                <!--<span class="icon icon_weixin"></span>-->
                                <!--&lt;!&ndash;无绑定显示文字 未绑定&ndash;&gt;-->
                            <!--</div>-->
                            <!--<form class="edit_form" action="">-->
                                <!--<div class="des">绑定第三方帐号后，可直接登录驼牛网</div>-->
                                <!--<div class="bind_btn_box">-->
                                    <!--<span class="icon icon_weibo"></span><button class="bind_btn unbind_btn">已绑定</button>-->
                                <!--</div>-->
                                <!--<div class="bind_btn_box">-->
                                    <!--<span class="icon icon_qq"></span><button class="bind_btn">绑定微博</button>-->
                                <!--</div>-->
                                <!--<div class="bind_btn_box">-->
                                    <!--<span class="icon icon_weixin"></span><button class="bind_btn">绑定微信</button>-->
                                <!--</div>-->
                            <!--</form>-->
                        <!--</div>-->

                        <div class="ucenter_edit_box">
                            <div class="edit_btn">编辑<span class="icon icon_edit_down"></span></div>
                            <div class="input_wrap" style="width:640px;">
                                <span class="input_head fl">简介：</span>
                                <p class="fl m_textarea"><?php echo $loginUser['intro']?></p>
                            </div>

                            <form class="edit_form"  id="intro_form" autocomplete="off">
                                <div class="input_wrap">
                                    <label for="intro">请输入介绍：</label>
                                    <textarea class="" name="data[intro]" id="intro" style="width: 500px"><?php echo $loginUser['intro']?></textarea>
                                    <p style="padding: 10px;">请输入100个汉字以内</p>
                                </div>
                                <div class="input_nohead_wrap">
                                    <button href="<?php echo url("/user_ucenter_update") ?>"  class=" ajaxproxy red_btn" data-loading-text=""
                                            proxy='{"formId":"intro_form", "method":"post","location":"reload"}'>保存</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <!-- function_tab end-->
        </div>
        <div class="layout-left">
            <?php include $this->getIncludePath('user.module_aside')?>
        </div>
    </div>
</section>
<!--content end-->
<?php echo $this->importResource('gres', 'js', 'jcrop/js/jquery.Jcrop.min.js')?>
<?php echo $this->importResource('gres', 'js', 'uploadify/jquery.uploadify.min.js')?>
<script>
    __param = {
        userid : '<?php echo $loginUser?>'
    }
</script>
<?php echo $this->importResource('gres', 'js', 'UploadCrop.js')?>
<?php echo $this->importResource('res', 'js', 'user.js')?>

<?php include $this->getIncludePath('user.footer')?>

