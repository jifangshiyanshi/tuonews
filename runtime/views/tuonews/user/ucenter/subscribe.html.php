<?php include $this->getIncludePath('user.header')?>
<!--content start-->
<section class="content">
    <?php include $this->getIncludePath('user.module_info_top')?>
    <div class="layoutlm">
        <div class="layout-main">
            <!-- 文章列表-->
            <div class="user_right_layout">
                <ul class="user_right_menu">
                    <li class="current"><a href="<?php echo url("/user_ucenter_subscribe") ?>">订阅</a></li>
                    <li><a href="<?php echo url("/user_ucenter_collection") ?>">收藏</a></li>
                </ul>
                <div class="user_right_content">
                    <div class="user_list">
                        <div class="top_goback_link clearfix">
                            <a class="fr" href="<?php echo url("/user_ucenter_subscribeMedia") ?>">查看订阅列表</a>
                        </div>
                        <!-- 文章列表 start-->
                        <div class="list_hidt">
                            <?php foreach ( $articles as $value ) { ?>
                            <dl class="item">
                                <dt class="head">
                                    <a href="<?php echo url("/article_article_detail/?id=$value[id]") ?>"><?php echo $value['title']?></a>
                                </dt>
                                <dd class="info">
                                    <div class="tag">
                                        <?php foreach ( $value[tags] as $vTags ) { ?>
                                        <a href="<?php echo url("/article_tags_detail/?id=$vTags") ?>"><?php echo $tags[$vTags]?></a>
                                        <?php } ?>
                                    </div>
                                    <?php if ( $value[source_url] !== '' ) { ?>
                                    <a href="<?php echo $value['source_url']?>" target="_blank"><?php echo $value['source']?></a>
                                    <?php } ?>
                                    <?php if ( $value[source_url] == '' ) { ?>
                                    <a href="#"><?php echo $value['source']?></a>
                                    <?php } ?>
                                    <span class="date">时间：<?=date('m-d H:i', $value[add_time]);?></span>
                                    <a href="<?php echo url("/article_article_index/?id=$value[chanel_id]") ?>"><?php echo $chanels[$value[chanel_id]]?></a>
                                </dd>
                            </dl>
                            <?php } ?>
                        </div>
                        <!-- 文章列表 end-->
                    </div>
                    <?php include $this->getIncludePath('common.module_page')?>
                </div>
            </div>
        </div>
        <div class="layout-left">
            <?php include $this->getIncludePath('user.module_aside')?>
        </div>
    </div>
</section>
<!--content end-->
<?php include $this->getIncludePath('user.footer')?>
