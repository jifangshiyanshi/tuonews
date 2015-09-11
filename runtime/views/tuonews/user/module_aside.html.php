<!--user_aside start-->
<ul class="user_aside">
    <li class="item <?php if ( $currentOpt == 'ucenter@index' ) { ?>current<?php } ?>">
        <a href="<?php echo url("/user_ucenter_index") ?>">后台管理中心</a>
    </li>
    <li class="item <?php if ( $currentOpt == 'ucenter@profile' ) { ?>current<?php } ?>">
        <a href="<?php echo url("/user_ucenter_profile") ?>">编辑资料</a>
    </li>
    <li class="item <?php if ( $currentOpt == 'ucenter@password' ) { ?>current<?php } ?>">
        <a href="<?php echo url("/user_ucenter_password") ?>">密码修改</a>
    </li>
    <li class="item <?php if ( $currentOpt == 'ucenter@subscribe' || $currentOpt == 'ucenter@collection' ) { ?>current<?php } ?>">
        <a href="<?php echo url("/user_ucenter_subscribe") ?>">订阅收藏</a>
    </li>
    <li class="item <?php if ( $currentOpt == 'article@add' ) { ?>current<?php } ?>">
        <a href="<?php echo url("/user_article_add") ?>">发稿</a>
    </li>
    <li class="item <?php if ( $currentOpt == 'tipoff@index' || $currentOpt == 'tipoff@lists' ) { ?>current<?php } ?>">
        <a href="<?php echo url("/user_tipoff_index") ?>">爆料</a>
    </li>
    <li class="item <?php if ( $currentOpt == 'article@index' ) { ?>current<?php } ?>">
        <a href="<?php echo url("/user_article_index") ?>">动态</a>
    </li>
    <li class="item <?php if ( $currentOpt == 'message@index' ) { ?>current<?php } ?>">
        <a href="<?php echo url("/user_message_index") ?>">消息</a>
    </li>
    <li class="item enter_item <?php if ( $currentOpt == 'ucenter@mediaApply' || $currentOpt == 'ucenter@mediaApplyList' ) { ?>current<?php } ?>">
        <a href="<?php echo url("/user_ucenter_mediaApply") ?>" class="mediaApply_popup_btn"><span class="icon icon_enter_small"></span>申请入驻</a>
    </li>
</ul>
<!--user_aside end-->
<?php include $this->getIncludePath('user.module_mediaApply_popup')?>
