<!--info_top--->
<div class="info_top user_info">
    <div class="face">
        <img class="lazy"  src="<?php echo getImageThumb($loginUser[head], '106x106') ?>" alt="<?php echo $loginUser['username']?>"/>
    </div>
    <div class="info">
        <p class="name"><?php echo $loginUser[nickname]?$loginUser[nickname]:$loginUser[username]; ?></p>
        <p class="type">会员类型：<?php if ( empty($loginUser['group_id']) ) { ?>普通会员<?php } ?><?php if ( $loginUser['group_id']==1 ) { ?>普通会员<?php } ?><?php if ( $loginUser['group_id']==1 ) { ?>驼牛网认证会员<?php } ?></p>
        <p class="des"><?php echo $loginUser['intro']?></p>
    </div>
    <div class="user_enter">
        <span class="icon icon_enter_big"></span>
        <a class="gray_radius_btn mediaApply_popup_btn" href="<?php echo url("/user_ucenter_mediaApply") ?>">入驻</a>
    </div>
</div>
<!--info_top--->
