<?php include $this->getIncludePath('user.header')?>
<!--content start-->
<section class="content">
    <?php include $this->getIncludePath('user.module_info_top')?>
    <div class="layoutlm">
        <div class="layout-main">
            <!--动态-->
            <div class="user_right_layout function_tab">
                <ul class="user_right_menu">
                    <li><a href="<?php echo url("/user_ucenter_mediaApply/?id=1") ?>">媒体</a></li>
                    <li><a href="<?php echo url("/user_ucenter_mediaApply/?id=2") ?>">自媒体</a></li>
                    <li><a href="<?php echo url("/user_ucenter_mediaApply/?id=3") ?>">企业</a></li>
                    <li class="current"><a href="">申请列表</a></li>
                </ul>
                <div class="user_right_content user_right_content_form">
                    <div class="goback_head"><a href="javascript:history.go(-1)" class="icon icon_go_back"></a>申请列表/申请详情</div>
                    <div class="media_apply_head">审核状态</div>
                    <div class="media_apply_text"><?php echo $item['ischeck']?></div>
                    <div class="media_apply_head">审核反馈</div>
                    <div class="media_apply_textarea"><?php echo $item['check_note']?></div>
                    <div class="media_apply_head">申请资料</div>
                    <div class="module_form module_form_show" action="" method="post">
                        <div class="input_wrap">
                            <label class="input_head" ><span class="red_star">*</span>媒体logo:</label>
                            <img src="<?php echo $item[logo]?>" alt=""/>
                        </div>
                        <div class="input_wrap">
                            <label class="input_head" >用户名：</label>
                            <span class="input_show"><?php echo $item['reg_name']?></span>
                        </div>
                        <div class="input_wrap">
                            <label class="input_head" >媒体类型：</label>
                            <span class="input_show"><?php echo $item['mediaType']?></span>
                        </div>
                        <div class="input_wrap">
                            <label class="input_head" ><span class="red_star">*</span>媒体名称/昵称：</label>
                            <span class="input_show"><?php echo $item['name']?></span>
                        </div>
                        <div class="input_wrap">
                            <label class="input_head" ><span class="red_star">*</span>登记人姓名：</label>
                            <span class="input_show"><?php echo $item['reg_name']?></span>
                        </div>
                        <div class="input_wrap">
                            <label class="input_head" ><span class="red_star">*</span>登记人身份证号：</label>
                            <span><?php echo $item['reg_id']?></span>
                        </div>
                        <div class="input_wrap">
                            <label class="input_head" ><span class="red_star">*</span>身份证照片：</label>
                            <img src="<?php echo $item[id_img]?>" alt=""/>
                        </div>

                        <?php if ( $item[media_type] == 1 ) { ?>
                            <div class="input_wrap">
                                <label class="input_head" ><span class="red_star">*</span>组织全称：</label>
                                <span class="input_show"><?php echo $item['company']?></span>
                            </div>
                            <div class="input_wrap">
                                <label class="input_head" ><span class="red_star">*</span>组织机构代码：</label>
                                <span class="input_show"><?php echo $item['company_code']?></span>
                            </div>
                            <div class="input_wrap">
                                <label class="input_head" ><span class="red_star">*</span>组织机构代码扫描件：</label>
                                <img src="<?php echo $item[company_img]?>" alt=""/>
                            </div>
                            <div class="input_wrap">
                                <label class="input_head" ><span class="red_star">*</span>固定电话：</label>
                                <span class="input_show"><?php echo $item['telephone']?></span>
                            </div>
                        <?php } ?>

                        <?php if ( $item[media_type] == 2 ) { ?>
                            <div class="input_wrap">
                                <label class="input_head" ><span class="red_star">*</span>辅助材料：</label>
                                <span class="input_show"><?php echo $item['help_txt']?></span>
                            </div>
                        <?php } ?>

                        <?php if ( $item[media_type] == 3 ) { ?>
                            <div class="input_wrap">
                                <label class="input_head" ><span class="red_star">*</span>公司全称：</label>
                                <span class="input_show"><?php echo $item['company']?></span>
                            </div>
                            <div class="input_wrap">
                                <label class="input_head" ><span class="red_star">*</span>营业执照注册号：</label>
                                <span class="input_show"><?php echo $item['company_code']?></span>
                            </div>
                            <div class="input_wrap">
                                <label class="input_head" ><span class="red_star">*</span>营业执照：</label>
                                <img src="<?php echo $item[company_img]?>" alt=""/>
                            </div>
                        <?php } ?>


                        <div class="input_wrap">
                            <label class="input_head" ><span class="red_star">*</span>邮箱：</label>
                            <span class="input_show"><?php echo $item['email']?></span>
                        </div>
                        <div class="input_wrap">
                            <label class="input_head" ><span class="red_star">*</span>手机号码：</label>
                            <span class="input_show"><?php echo $item['mobile']?></span>
                        </div>
                        <div class="input_wrap">
                            <label class="input_head" ><span class="red_star">*</span>QQ号：</label>
                            <span class="input_show"><?php echo $item['qq']?></span>
                        </div>
                        <div class="input_wrap">
                            <label class="input_head" ><span class="red_star">*</span>所在地区：</label>
                            <span class="input_show"><?php echo $item['address']?></span>
                        </div>
                        <div class="input_wrap">
                            <label class="input_head" ><span class="red_star">*</span>简介：</label>
                            <span class="input_show"><?php echo $item['intro']?></span>
                        </div>
                    </div>
                    <!--判断状态-->
                    <!--<button class="red_btn">重新申请</button>-->
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
<!--footer end-->
<?php include $this->getIncludePath('user.footer')?>

