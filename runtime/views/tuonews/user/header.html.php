<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title><?php if ( $seoTitle ) { ?><?php echo $seoTitle?><?php echo $title?> <?php } else { ?>驼牛网-产业文化与媒体影响力传播交流平台<?php } ?></title>
    <meta name="description" content="<?php echo $seoDesc?>" />
    <meta name="keywords" content="<?php echo $seoKwords?>" />
    <meta name="renderer" content="webkit">
    <?php echo $this->importResource('gres', 'css', 'JDialog-custom.css')?>
    <?php echo $this->importResource('cres', 'css', '/app/tuonews/user/default/skin/default/css/tuonews_user_center.min.css')?>
    <?php echo $this->importResource('cres', 'css', '/app/tuonews/user/default/skin/default/css/custom_fixed.css')?>
    <?php echo $this->importResource('gres', 'js', 'jquery-1.11.2.min.js')?>
    <?php echo $this->importResource('gres', 'js', 'jquery.lazyload.min.js')?>
    <?php echo $this->importResource('gres', 'js', 'JDialog.js')?>
	<?php echo $this->importResource('gres', 'js', 'JForm.js')?>
    <?php echo $this->importResource('gres', 'js', 'AjaxProxy.js')?>
    <?php echo $this->importResource('gres', 'js', 'AutoSave.js')?>
    <?php echo $this->importResource('cres', 'js', '/app/tuonews/user/default/js/common.js')?>
    <?php echo $this->importResource('cres', 'css', 'global/js/uploadify/uploadify.min.css')?>
    <?php echo $this->importResource('cres', 'css', 'global/js/jcrop/css/jquery.Jcrop.min.css')?>
    <!--[if lt IE 9]>
    <?php echo $this->importResource('gres', 'js', 'html5shiv.js')?>
    <![endif]-->
</head>
<body>
<!--header start-->
<header class="header">
    <div class="header_box">
        <nav class="head_nav">
            <ul class="list">
                <li class="item"><a href="/">首页</a></li>
                <?php foreach ( $__chanels as $chanelsOne ) { ?>
                <li class="item">
                    <a href="<?php echo url("/article_article_index/?id=$chanelsOne[id]") ?>"><?php echo $chanelsOne[name]?></a>
                    <?php if ( $chanelsOne[sub] ) { ?>
                    <ul class="sublist">
                        <?php foreach ( $chanelsOne[sub] as $value ) { ?>
                        <li><a href="<?php echo url("/article_article_index/?id=$value[id]") ?>"><?php echo $value[name]?></a></li>
                        <?php } ?>
                    </ul>
                    <?php } ?>
                </li>
                <?php } ?>
                <li class="item">
                    <a href="<?php echo url("/article_media_index") ?>">牛媒</a>
                    <ul class="sublist">
                        <?php foreach ( $mediaTypes as $value ) { ?>
                        <li><a href="<?php echo $value[url]?>"><?php echo $value[name]?></a></li>
                        <?php } ?>
                    </ul>
                </li>
            </ul>
        </nav>
        <div class="head_right">
            <div class="item"><a href="<?php echo url("/user_article_add") ?>">我要投稿</a></div>
            <div class="item"><a href="<?php echo url("/article_artone_service/?id=5") ?>">寻求报道</a></div>
            <div class="item user_item">
                <a href="<?php echo url("/user_ucenter_index") ?>"><?=$loginUser[nickname]?$loginUser[nickname]:$loginUser[username]?></a>
                <ul class="sublist">
                    <li><a href="<?php echo url("/user_message_index") ?>">消息</a></li>
                    <li><a href="<?php echo url("/user_article_add") ?>">发稿</a></li>
                    <li><a href="<?php echo url("/user_tipoff_index") ?>">爆料</a></li>
                    <li><a href="<?php echo url("/user_ucenter_mediaApply") ?>">申请入驻</a></li>
                    <li><a href="<?php echo url("/user_login_logout/?op=logout") ?>">退出</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>
<!--header end-->
