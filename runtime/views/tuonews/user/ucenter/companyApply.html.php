<?php include $this->getIncludePath('user.header')?>
<!--content start-->
<section class="content">
    <?php include $this->getIncludePath('user.module_info_top')?>
    <div class="layoutlm">
        <div class="layout-main">
            <!--动态-->
            <div class="user_right_layout function_tab">
                <ul class="user_right_menu " id="meida_Apply">
                    <!-- data-type-id 媒体id-->
                    <li <?php if ( ($id==1 || empty($id)) ) { ?>class='current' <?php } ?> data-type-id="1"><a href="<?php echo url("/user_ucenter_mediaApply/?id=1") ?>">媒体</a></li>
                    <li <?php if ( $id==2 ) { ?>class="current"<?php } ?> data-type-id="2"><a href="<?php echo url("/user_ucenter_mediaApply/?id=2") ?>">自媒体</a></li>
                    <li <?php if ( $id==3 ) { ?>class="current"<?php } ?> data-type-id="3"><a href="<?php echo url("/user_ucenter_mediaApply/?id=3") ?>">企业</a></li>
                    <li><a href="<?php echo url("/user_ucenter_mediaApplyList") ?>">申请列表</a></li>
                </ul>
                <div class="user_right_content user_right_content_form">

                    <form class="module_form mediaApply" id="content_add_form" action="">
                        <div class="input_wrap clearfix">
                            <label class="input_head fl" ><span class="red_star">*</span>企业logo:</label>
                            <p>提示：上传图片时双击裁剪框可以对图片进行裁剪， 建议图片的宽高比例为218x128，否则图片会被压缩</p>
                            <div class="fl">
                                <input type="hidden" name="data[logo]" id="media_logo" tip-text="企业logo" required/>
                                <input type="file" id="media_logo_upload"/>
                                <input type="hidden" id="img" name="img" />
                                <input type="hidden" id="x" name="x" />
                                <input type="hidden" id="y" name="y" />
                                <input type="hidden" id="w" name="w" />
                                <input type="hidden" id="h" name="h" />
                            </div>
                        </div>
                        <div class="input_nohead_wrap" id="preview-box">
                            <div class="row container">
                                <img src="" id="crop_target" />
                            </div>
                        </div>
                        <div class="input_nohead_wrap">
                            <div class="row container" id="preview_box" style="margin-top:10px; display: none; zoom:1; overflow: hidden;">
                                <div class="preview-container">
                                    <img class="preview" id="preview_1" style="max-width: 1920px;" />
                                </div>

                                <div class="preview-container" style="border-radius: 50%;">
                                    <img class="preview" id="preview_2" style="max-width: 1920px;" />
                                </div>
                            </div>
                        </div>

                        <div class="input_wrap">
                            <label class="input_head" >媒体类型：</label>
                            <span id="meida_Apply_text">媒体</span>
                            <input type="hidden" id="meida_Apply_type" name="data[media_type]" tip-text-name="媒体类型" tip-text="媒体类型" required/>
                        </div>
                        <div class="input_wrap">
                            <label class="input_head" ><span class="red_star">*</span>媒体名称/昵称：</label>
                            <input type="text" class="input m3_input" name="data[nickname]" min-length="1" max-length="20" tip-text="媒体名称" required/>
                            <span class="tips">1-20个中英文</span>
                        </div>
                        <div class="input_wrap">
                            <label class="input_head" ><span class="red_star">*</span>登记人姓名：</label>
                            <input type="text" class="input m3_input" name="data[reg_name]" tip-text="登记人姓名" required/>
                            <span class="tips">请填写正式姓名</span>
                        </div>
                        <div class="input_wrap">
                            <label class="input_head" ><span class="red_star">*</span>登记人身份证号：</label>
                            <input type="text" class="input m3_input" name="data[reg_id]" tip-text="登记人身份证号" dtype="idnum" required/>
                            <span class="tips">请填写正式身份证号</span>
                        </div>
                        <div class="input_wrap">
                            <label class="input_head" ><span class="red_star">*</span>身份证照片：</label>
                            <img src="<?php echo $appConfigs[default_logo]?>" id="id-preview" tip-text="身份证照片" required/>
                        </div>
                        <div class="input_tips_wrap">
                            <div class="file_upload_tips">半身手持身份证照，需看清号码 <br/>
                                支持.jpg .jpeg .bmp .gif格式照片，大小不超过2M。</div>
                            <span class="">
                                <input type="hidden" name="data[id_img]" id="id_img"/>
                                <input type="file" value="" id="id_src" />
                            </span>
                        </div>

                        <div class="input_wrap">
                            <label class="input_head" ><span class="red_star">*</span>公司全称：</label>
                            <input type="text" class="input m3_input" name="data[company]" min-length="4" max-length="20" tip-text="组织全称" required/>
                            <span class="tips">4-20字</span>
                        </div>
                        <div class="input_wrap">
                            <label class="input_head" ><span class="red_star">*</span>营业执照注册号：</label>
                            <input type="text" class="input m3_input" name="data[company_code]" tip-text="营业执照注册号" required/>
                            <span class="tips">请填写营业执照注册号</span>
                        </div>
                        <div class="input_wrap">
                            <label class="input_head" ><span class="red_star">*</span>营业执照：</label>
                            <img src="<?php echo $appConfigs[default_logo]?>" id="company-previw" tip-text="营业执照" required/>
                        </div>
                        <div class="input_tips_wrap">
                            <div class="file_upload_tips">支持.jpg .jpeg .bmp .gif格式照片，大小不超过2M。</div>
                            <span class="">
                                <input type="hidden" name="data[company_img]" id="company_img"/>
                                <input type="file" value="" id="company_src" />
                            </span>
                        </div>

                        <div class="input_wrap">
                            <label class="input_head" ><span class="red_star">*</span>邮箱：</label>
                            <input type="text" class="input m3_input" name="data[email]" dtype="email" tip-text="邮箱" required/>
                            <span class="tips">请填写正式邮箱</span>

                        </div>
                        <div class="input_wrap">
                            <label class="input_head" ><span class="red_star">*</span>手机号码：</label>
                            <input type="text" class="input m3_input" name="data[mobile]" dtype="mobile" tip-text="手机号码" required/>
                            <span class="tips">请填写手机号码</span>
                        </div>
                        <div class="input_wrap">
                            <label class="input_head" ><span class="red_star">*</span>QQ号：</label>
                            <input type="text" class="input m3_input" name="data[qq]" tip-text="QQ" required/>
                            <span class="tips">请填写QQ号</span>
                        </div>
                        <div class="input_wrap">
                            <label class="input_head" ><span class="red_star">*</span>所在地区：</label>
                            <div id="area-select-box"></div>
                        </div>
                        <div class="input_nohead_wrap">
                            <input type="text" class="input m3_input" name="data[address]" required tip-text="所在地区"/>
                            <span>&nbsp;&nbsp;&nbsp;请输入详细地址</span>
                        </div>
                        <div class="input_wrap">
                            <label class="input_head" ><span class="red_star">*</span>简介：</label>
                            <textarea class="textarea m_textarea" name="data[intro]" tip-text="简介" required></textarea>
                            <p class="tips" style="text-align: left;">60个字以内，支持中英文和数字</p>
                        </div>
                        <div class="input_nohead_wrap">
                            <button class="red_btn ajaxproxy"
                                    href="<?php echo url("/user_ucenter_mediaAdd") ?>"
                                    proxy='{"formId":"content_add_form",
                                    "method":"post",
                                    "callBack":"checkBack(data);"}'>提交</button>
                        </div>
                    </form>

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
<?php echo $this->importResource('gres', 'js', 'jcrop/js/jquery.Jcrop.min.js')?>
<?php echo $this->importResource('gres', 'js', 'uploadify/jquery.uploadify.min.js')?>
<?php echo $this->importResource('gres', 'js', 'JAreaData.js')?>
<?php echo $this->importResource('gres', 'js', 'JAreaSelect.js')?>

<script>

    var __params = {
        userid : '<?php echo $loginUser[id]?>',
        ids : [1]

    }
</script>
<?php echo $this->importResource('res', 'js', 'media@media.js')?>
<?php echo $this->importResource('gres', 'js', 'UploadCrop.js')?>
<script>

    function  checkBack(data){
        if(data.state == "ok"){
            JDialog.lock.work({opacity:0.5, timer:100000});
            JDialog.confirm.work({title:"提示信息",width:400,content:"已申请成功,请等待审核<a href='<?php echo url("/user_ucenter_mediaApplyList") ?>'>申请列表</a>",borderWidth:1,shadow:false,skin:"none",button:{
                '确认':function(){
                    location.href="<?php echo url("/user_ucenter_mediaApply/?id=1") ?>";
                },
                '取消':function(){
                    JDialog.confirm.hide();
                    location.replace('<?php echo url("/user_article_index") ?>');
                }
            }});
        } else if(data.state == 'bug') {
            JDialog.lock.work({opacity:0.5, timer:100000});
            JDialog.confirm.work({title:"提示信息",width:400,content:data.message,borderWidth:1,shadow:false,skin:"none",button:{
                '确认':function(){
                    location.href="<?php echo url("/user_ucenter_index") ?>";
                }
            }});
        } else {
            JDialog.tip.work({type:"error", content:data.message, timer:2000});
        }
    }
</script>

<!--footer end-->
<?php include $this->getIncludePath('user.footer')?>

