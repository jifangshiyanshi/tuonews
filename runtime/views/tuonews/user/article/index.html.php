<?php include $this->getIncludePath('user.header')?>
<!--content start-->
<section class="content">
    <?php include $this->getIncludePath('user.module_info_top')?>
    <div class="layoutlm">
        <div class="layout-main">
            <!--动态-->
            <div class="user_right_layout function_tab">
                <ul class="user_right_menu">
                    <li class="current"><a href="<?php echo url("/user_article_index") ?>">文章</a></li>
                    <!--<li><a href="<?php echo url("/user_article_comment") ?>">评论</a></li>-->
                </ul>
                <div class="user_right_content user_right_content_form">
                    <!-- list start-->
                    <div class="list_hdc">
                        <?php foreach ( $articles as $value ) { ?>
                        <dl class="item">
                            <dt class="head">
                            <div class="date"><?php echo $this->getDate($value[add_time], " m-d H：i") ?></div>
                            <a href="<?php echo url("/user_article_edit/?id=$value[id]") ?>"><?php echo $value[title]?></a>
                            </dt>
                            <dd class="context">
                                <?php echo $value[bcontent]?>
                            </dd>
                        </dl>
                        <?php } ?>
                    </div>
                    <!-- list end-->
                    <?php include $this->getIncludePath('common.module_page')?>
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
