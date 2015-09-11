<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title><?php echo $seoTitle?></title>
    <meta name="description" content="<?php echo $seoDesc?>" />
    <meta name="keywords" content="<?php echo $seoKwords?>" />
    <meta name="renderer" content="webkit">
    <meta property="qc:admins" content="35002502726457657363757" />
    <?php echo $this->importResource('gres', 'css', 'JDialog-custom.css')?>
    <?php echo $this->importResource('cres', 'css', 'app/tuonews/reception/default/skin/default/css/tuonews.min.css')?>
    <?php echo $this->importResource('cres', 'css', 'app/tuonews/reception/default/skin/default/css/pinlun_style.css')?>
    <script src="/res/global/js/sea/seajs/sea.js" id="seajsnode"></script>
    <?php echo $this->importResource('gres', 'js', 'sea/seajs/config.js')?>
    <?php echo $this->importResource('gres', 'js', 'sea/plug-in/jquery-1.11.2.min.js')?>
    <?php echo $this->importResource('gres', 'js', 'sea/plug-in/pinglun.js')?>
    <script>
        seajs.use(['jquery', 'tuonews_reception/reception'], function($) {
            //页面js请写在这里
        });
    </script>
    <!--[if lt IE 9]>
    <?php echo $this->importResource('gres', 'js', 'html5shiv.js')?>
    <![endif]-->
</head>
<body>
<!-- [if lt IE 8]>
为了保证用户良好的用户体验,请使用极速模式或者升级浏览器
<![endif]-->
<noscript>为了保证用户良好的用户体验,请开启javascript</noscript>
<!--header start-->
<header class="header">
    <div class="top">
        <div class="top_wrap">
            <div class="top_text fl"><a class="link" href="/">驼牛网</a> — 产业文化与媒体影响力传播交流平台！</div>
            <ul class="control">
                <li><a href="<?php echo url("/user_article_add") ?>">我要投稿</a></li>
                <li><a href="<?php echo url("/article_artone_service/?id=5") ?>">寻求报道</a></li>
                <?php if ( !$loginUser ) { ?>
                <li class="login" id="login_popup_btn"><a href="<?php echo url("/user_login_index") ?>">登录</a></li>
                <li><a href="<?php echo url("/user_register_index") ?>">立即注册</a></li>
                <?php } ?>
                <?php if ( $loginUser ) { ?>
                <li class="user_item">
                    <a href="<?php echo url("/user_ucenter_index") ?>"><?php echo $loginUser[nickname]?$loginUser[nickname]:$loginUser[username] ?></a>
                    <ul class="sublist">
                        <li><a href="<?php echo url("/user_message_index") ?>">消息</a></li>
                        <li><a href="<?php echo url("/user_article_add") ?>">发稿</a></li>
                        <li><a href="<?php echo url("/user_tipoff_index") ?>">爆料</a></li>
                        <li><a href="<?php echo url("/user_ucenter_mediaApply") ?>">申请入驻</a></li>
                        <li><a href="<?php echo url("/user_login_logout/?op=logout") ?>">退出</a></li>
                    </ul>
                </li>
                <?php } ?>

            </ul>
        </div>
    </div>
    <div class="main">
        <div class="logo">
            <a href="/"><img class="lazy" src="<?php echo $appConfigs['res_url']?>/res/global/images/reception/block.gif" data-original="<?php echo $appConfigs['res_url']?>/res/global/images/reception/logo143x74.jpg" alt="驼牛网-产业文化与媒体影响力传播交流平台"/></a>
        </div>
        <div class="ads_wrap">
            <div class="ads_460x67">
                <!--ads_460x47-->
                <a href="/topic/apply/activity_pc.html"><img class="lazy" src="<?php echo $appConfigs['res_url']?>/res/global/images/reception/block.gif" data-original="<?php echo $appConfigs['res_url']?>/res/app/tuonews/reception/default/skin/default/images/temp/top_ad460x67.jpg" alt="ads_460x67"/></a>

            </div>
            <div class="ads_300x67">
                <a href="/topic/apply/index.html"><img class="lazy" src="<?php echo $appConfigs['res_url']?>/res/global/images/reception/block.gif" data-original="<?php echo $appConfigs['res_url']?>/res/app/tuonews/reception/default/skin/default/images/temp/top_ad300x67.jpg" alt="ads_300x67"/></a>
                <!--&lt;!&ndash;ads_300x47&ndash;&gt;-->
                <!--<script type="text/javascript">
                    /*300*70 创建于 2015-06-15*/
                    var cpro_id = "u2157115";
                </script>
                <script src="http://cpro.baidustatic.com/cpro/ui/c.js" type="text/javascript"></script>-->
            </div>
        </div>

    </div>
    <!--nav start-->
    <nav class="nav" id="nav">
        <ul class="nav_list">
            <li class="nav_item"><a href="/">首页</a></li>
            <?php foreach ( $__chanels as $chanelsOne ) { ?>
            <li class="nav_item">
                <a href="<?php echo url("/article_article_index/?id=$chanelsOne[id]") ?>"><?php echo $chanelsOne[name]?></a>
                <?php if ( $chanelsOne[sub] ) { ?>
                <ul class="nav_sublist">
                    <?php foreach ( $chanelsOne[sub] as $value ) { ?>
                    <li><a href="<?php echo url("/article_article_index/?id=$value[id]") ?>"><?php echo $value[name]?></a></li>
                    <?php } ?>
                </ul>
                <?php } ?>
            </li>
            <?php } ?>
            <li class="nav_item">
                <a href="<?php echo url("/article_media_index") ?>">牛媒</a>
                <ul class="nav_sublist">
                    <?php foreach ( $mediaTypes as $value ) { ?>
                    <li><a href="<?php echo $value[url]?>"><?php echo $value[name]?></a></li>
                    <?php } ?>
                </ul>
            </li>
        </ul>
    </nav>
    <!--nav end-->
</header>
<!--header end-->
<script id="login_template" type="text/html">
    <div class="account_manage">
        <div class="tab_conItem ">
            <div class="login_form">
                <form action="<?php echo url("/user_login_signin") ?>" method="post" autocomplete="off">
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
                        <label class="auto"><input type="checkbox"/>两周自动登录</label>
                        <a class="link forget" href="<?php echo url("/user_resetPass_index") ?>">忘记密码？</a>
                    </div>

                    <div style="padding-left:100px; padding-bottom: 10px; font-size: 14px; display: none;">您的帐号没有激活，请狠狠的戳
                        <a href="<?php echo url("/user_register_emailActive/?email=(email)") ?>" id="__send_active_email" style="color: #0000cc">发送激活邮件</a></div>

                    <div class="input_wrap">
                        <label class="input_head"></label>
                        <button class="red_btn_popup" id="login_submit_popup" type="submit">登录</button>
                    </div>
                </form>
            </div>
            <div class="quick">
                <div class="link_box">
                    <a class="link" href="<?php echo url("/user_register_index") ?>">注册</a>未有账号？
                </div>
                <p class="btn_text">可使用以下账号一键登录</p>
                <div class="btn_box clearfix">
                    <a href="https://api.weibo.com/oauth2/authorize?client_id=1725858045&redirect_uri=http://www.tuonews.com/user_register_wbLogin&response_type=code"><span class="icon icon_weibo"></span></a>
                    <a href="http://openapi.qzone.qq.com/oauth/show?which=ConfirmPage&display=pc&client_id=101219507&redirect_uri=http://www.tuonews.com/user_register_qqLogin?response_type=code&state=aa418fb0b8148a18ab7d20637f070933&scope=get_user_info"><span class="icon icon_qq"></span></a>
                    <a href="https://open.weixin.qq.com/connect/qrconnect?appid=wx7d39eff604ea2001&redirect_uri=http%3A%2F%2Fwww.tuonews.com%2Fuser_register_wxLogin&response_type=code&scope=snsapi_login&state=STATE#wechat_redirect"><span class="icon icon_weixin"></span></a>
                </div>
            </div>
        </div>
    </div>
</script>
