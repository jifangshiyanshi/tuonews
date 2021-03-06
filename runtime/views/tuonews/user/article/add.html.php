<?php include $this->getIncludePath('user.header')?>
<!--content start-->
<section class="content">
    <?php include $this->getIncludePath('user.module_info_top')?>
    <div class="layoutlm">
        <div class="layout-main">
            <!--动态-->
            <div class="user_right_layout function_tab">
                <ul class="user_right_menu">
                    <li class="current"><a href="">发稿</a></li>
                </ul>
                <div class="user_right_content user_right_content_form">
                    <form class="module_form" action="" id="article_add_form">
                        <div class="input_wrap">
                            <label class="input_head" for="title"><span class="red_star">*</span>文章标题:</label>
                            <input class="input m_input" type="text" name="data[title]" max-legng id="title" autofocus tip-text="文章标题" required/>
                        </div>
                        <div class="clearfix">
                            <label class="input_head fl" ><span class="red_star">*</span>文章缩略图：</label>
                            <input type="hidden" name="data[thumb]" id="logo" class="input m_input" value="" tip-text="文章缩略图" required/>
                            <div class="fl">
                                <input  id="thumb_upload" type="file" value=""/>
                                <input type="hidden" id="img" name="img" />
                                <input type="hidden" id="x" name="x" />
                                <input type="hidden" id="y" name="y" />
                                <input type="hidden" id="w" name="w" />
                                <input type="hidden" id="h" name="h" />
                            </div>
                            <span class="tips">提示：上传图片时，双击裁剪框可以对图片进行裁剪</span>
                        </div>
                        <div class="row img_nohead container hidden">
                            <img src="" id="crop_target" />
                        </div>
                        <div class="input_wrap img_nohead clearfix ">
                            <div class="row container clearfix hidden" id="preview_box">
                                <div>
                                    <img class="preview" id="preview" src="" />
                                </div>
                            </div>
                        </div>
                        <div class="input_wrap">
                            <label class="input_head" for="abstract">文章简介:</label>
                            <textarea class="textarea m5_textarea" name="data[bcontent]" tip-text="文章简介"  required id="abstract"><?php echo $item[bcontent]?></textarea>
                            <div class="clearfix"><p class="fr">文章简介要求在60字以内</p></div>
                        </div>
                        <div class="input_wrap clearfix">
                            <label class="input_head fl"><span class="red_star">*</span>文章内容:</label>
                            <div class="editor_box fl">
                                <textarea name="data[content]" id="editor" style="max-width: 550px; height: 300px;"><?php echo $item[content]?></textarea>
                            </div>
                        </div>

                        <div class="input_wrap">
                            <label class="input_head" for="tag"><span class="red_star">*</span>文章标签:</label>
                            <input class="input m_input" name="data[tags]" type="text" value="<?php echo $item[tags]?>" id="tag"/>
                            <button class="tag_btn" id="get-tags"  data-source="#title" type="button"> 自动获取</button>
                        </div>
                        <div class="input_nohead_wrap">
                            <button class="red_btn submit_btn ajaxproxy"
                                    href="<?php echo url("/user_article_insert") ?>"
                                    proxy='{
                                    "formId":"article_add_form",
                                    "method":"post",
                                    "callBack":"checkBack(data);",
                                    "location":"<?php echo url("/user_article_index") ?>"}'>保存
                            </button>
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
<!-- 引入编辑器 -->
<?php echo $this->importResource('cres', 'js', 'ueditor/tuonews.config.min.js')?>
<?php echo $this->importResource('cres', 'js', 'ueditor/ueditor.all.min.js')?>
<?php echo $this->importResource('gres', 'js', 'jcrop/js/jquery.Jcrop.min.js')?>
<?php echo $this->importResource('gres', 'js', 'uploadify/jquery.uploadify.min.js')?>
<?php echo $this->importResource('gres', 'js', 'UploadCrop.js')?>
<script>
    //实例化编辑器
    var __UE = UE.getEditor('editor');
    var __param = {
        userid : '<?php echo $loginUser[id]?>',
        uploader : '<?php echo url("/image_upload_index") ?>',
        cropUrl : '<?php echo url("/image_upload_crop") ?>'
    };

    $('#thumb_upload').UploadCrop({
        //上传按钮的dom id
        uploadId : '#thumb_upload',
        //裁剪dom id
        cropId : '#crop_target',
        //裁剪的源图片
        cropSrc : '#logo',
        //uploadify 插件配置
        upload : {
            'formData'     : {
                'userid' : '<?php echo $loginUser[id]?>',
                'width' : 700
            },
            'multi'	: false
        },
        //jcrop 插件配置
        jcrop : {
            setSelect: [0,0,620,290],
            aspectRatio: 620/290,
            allowResize : false
        },
        //预览选项，如果有多个预览预览图就配置多个选项
        privewOptions : {
            '#preview' : {
                width : 620,
                height : 290
            }
        },
        //裁剪成功回调函数
        onSuccess : function() {
            JDialog.tip.work({type:'ok', content:'裁剪成功！', timer : 1000});
        },

        //裁剪失败回调
        onError : function(message) {
            JDialog.tip.work({type:'error', content:message, timer : 1000});
        }
    });



    //自动获取标签
    $('#get-tags').click(function() {

        //更改按钮样式为加载状态
        try {
            $(this).button('loading');
        } catch (e) {}

        var dataSource = $(this).attr('data-source');
        var data = $(dataSource).val();
        var me = this;
        //发送分词请求
        $.post('/article_article_fetchTags.shtml', {
            data : data
        }, function(res) {

            if ( res.state == 'ok' ) {

                //先销毁tagInput对象
                try {
                    $('#tag').data('tagsinput').destroy();
                } catch (e) {}
                //重新创建tagInput对象
                var ch = res.message.split(",");
                var arr=unique(ch);
                $('#tag').val(arr.slice(0,5));

            } else {
                JDialog.tip.work({type:'warn', content:'获取标签失败！', timer:'2000'});
            }

            //重置按钮样式
            try {
                $(me).button('reset');
            } catch (e) {}

        }, 'json');
    });
    function unique(arr) {
        var result = [], hash = {};
        for (var i = 0, elem; (elem = arr[i]) != null; i++) {
            if (!hash[elem]) {
                result.push(elem);
                hash[elem] = true;
            }
        }
        return result;
    }
    function  checkBack(data){
        if(data.state == "ok"){
            JDialog.lock.work({opacity:0.5, timer:100000});
            JDialog.confirm.work({title:"提示信息",width:400,content:"已发稿成功,建议申请自媒体或媒体",borderWidth:1,shadow:false,skin:"none",button:{
                '确认':function(){
                   location.href="<?php echo url("/user_ucenter_mediaApply/?id=1") ?>";
                },
                '取消':function(){
                    JDialog.confirm.hide();
                    location.replace('<?php echo url("/user_article_index") ?>');
                }
            }});
        } else {
            JDialog.tip.work({type:"error", content:data.message, timer:2000});
        }
    };
</script>
<!--footer end-->
<?php include $this->getIncludePath('user.footer')?>
