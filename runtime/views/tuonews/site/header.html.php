<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title><?php if ( $seoTitle ) { ?><?php echo $seoTitle?><?php } else { ?>驼牛网-产业文化与媒体影响力传播交流平台<?php } ?></title>
    <meta name="description" content="<?php echo $seoDesc?>" />
    <meta name="keywords" content="<?php echo $seoKwords?>" />
    <?php include $this->getIncludePath('site.site')?>
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
            <div class="top_text fl">
                <a class="link" href="<?php echo url("/site_index_index/?media_id=$loginMedia[id]") ?>"><?php echo $mediaConfigs[sitename]?></a> — <?php echo $mediaConfigs[sitetitle]?></div>
            <ul class="control" style="display: none;">
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
    <div class="head">
        <div class="maxWidth">
            <div class="logo fl"><a href="<?php echo url("/site_index_index/?media_id=$loginMedia[id]") ?>" title="<?php echo $mediaConfigs[sitename]?>">
                <img alt="<?php echo $mediaConfigs[sitename]?>" src="<?php if ( $loginMedia[logo] ) { ?><?php echo $loginMedia[logo]?><?php } else { ?>/res/global/images/default8.png<?php } ?>" /></a></div>
            <!-- 导航栏 -->
            <ul class="nav">
                <li <?php if ( empty($chanelId) ) { ?> class="current" <?php } ?>><a href="<?php echo url("/site_index_index/?media_id=$loginMedia[id]") ?>">首页</a></li>
                <?php foreach ( $chanels as $val ) { ?>
                <li <?php if ( $val[id]== $chanelId ) { ?> class="current" <?php } ?>><a href="<?php echo url("/site_article_index/?id=$val[id]&media_id=$loginMedia[id]") ?>"><?php echo $val[name]?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</header>
<!--header end-->
