<?php include $this->getIncludePath('user.header')?>
<!--content start-->
<section class="content">
    <?php include $this->getIncludePath('user.module_info_top')?>
    <div class="layoutlm">
        <div class="layout-main">
            <!-- 入驻列表 媒体列表-->
            <div class="user_right_layout function_tab">
                <ul class="user_right_menu">
                    <li class="current"><a href="">入驻列表</a></li>
                </ul>
                <div class="user_right_content user_right_content_media">
                    <?php if ( !empty($medias[qunmei]) ) { ?>
                    <div class="list_itl_head">媒体列表</div>
                    <div class="list_itl">
                        <?php foreach ( $medias[qunmei] as $value ) { ?>
                        <dl class="item">
                            <dd class="img">
                                <a href="<?php echo url("/media_media_index/?media_id=$value[id]") ?>">
                                    <img class="lazy" src="<?php echo $appConfigs[image_block]?>" data-original="<?php echo $value[logo]?>" alt="<?php echo $value[name]?>"/>
                                </a>
                            </dd>
                            <dt class="title_box">
                                <a class="link" href="<?php echo url("/media_media_index/?media_id=$value[id]") ?>">进入媒体后台</a>
                            <div class="title"><?php echo $value[name]?></div>
                            </dt>
                        </dl>
                        <?php } ?>
                    </div>
                    <?php } ?>

                    <?php if ( !empty($medias[zimei]) ) { ?>
                    <div class="list_itl_head">自媒体列表</div>
                    <div class="list_itl">
                        <?php foreach ( $medias[zimei] as $value ) { ?>
                        <dl class="item">
                            <dd class="img">
                                <a href="<?php echo url("/media_media_index/?media_id=$value[id]") ?>">
                                    <img class="lazy" src="<?php echo $appConfigs[image_block]?>" data-original="<?php echo $value[logo]?>" alt="<?php echo $value[name]?>"/>
                                </a>
                            </dd>
                            <dt class="title_box">
                                <a class="link" href="<?php echo url("/media_media_index/?media_id=$value[id]") ?>">进入自媒体后台</a>
                            <div class="title"><?php echo $value[name]?></div>
                            </dt>
                        </dl>
                        <?php } ?>
                    </div>
                    <?php } ?>

                    <?php if ( !empty($medias[qiye]) ) { ?>
                    <div class="list_itl_head">企业列表</div>
                    <div class="list_itl">
                        <?php foreach ( $medias[qiye] as $value ) { ?>
                        <dl class="item">
                            <dd class="img">
                                <a href="<?php echo url("/media_media_index/?media_id=$value[id]") ?>">
                                    <img class="lazy" src="<?php echo $appConfigs[image_block]?>" data-original="<?php echo $value[logo]?>" alt="<?php echo $value[name]?>"/>
                                </a>
                            </dd>
                            <dt class="title_box">
                                <a class="link" href="<?php echo url("/media_media_index/?media_id=$value[id]") ?>">进入企业后台</a>
                            <div class="title"><?php echo $value['name']?></div>
                            </dt>
                        </dl>
                        <?php } ?>
                    </div>
                    <?php } ?>
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
<?php include $this->getIncludePath('user.footer')?>
