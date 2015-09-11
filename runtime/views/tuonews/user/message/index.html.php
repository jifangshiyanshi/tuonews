<?php include $this->getIncludePath('user.header')?>
<!--content start-->
<section class="content">
    <?php include $this->getIncludePath('user.module_info_top')?>
    <div class="layoutlm">
        <div class="layout-main">
            <!--消息-->
            <div class="user_right_layout function_tab">
                <ul class="user_right_menu">
                    <li class="current"><a href="<?php echo url("/user_message_index") ?>">系统</a></li>
                    <!--<li><a href="<?php echo url("/user_message_comment") ?>">回复我的</a></li>-->
                </ul>
                <div class="user_right_content user_right_content_form">
                    <!-- list start-->
                    <!--还没有发表过文章--->
                    <div class="list_tsd">
                        <?php foreach ( $items as $value ) { ?>
                        <div class="item">
                            <div class="date"><?=date("Y-m-d   H:i")?></div>
                            <span><?php echo $value['content']?></span>
                        </div>
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
