/**
 * Created by yangjian on 15-6-14.
 * ucenter js code here
 */
$(function(){

    //正则表达式映射
    var __pattern = {
        'username' : /^[0-9|a-z|\-|_]{4,20}$/i,
        'email' : /^[a-z0-9]{1,20}\w{1,18}@[a-z0-9]{1,20}(\.[a-z]{1,6}){1,3}$/i,
        'mobile' : /^1[3|4|5|7|8][0-9]{9}$/
    };

    //上传裁剪头像
    try {
        var upload_configs = {

            //裁剪目标图片的ID
            cropId : '#crop_target',
            //存储裁剪的源图片的表单元素id
            cropSrc : '#media_logo',
            //裁剪预览
            previewBox : '#preview_box',
            //uploadify 插件配置
            upload : {
                'formData'     : {
                    'userid' : 0,
                    'media_id' : 0,
                    'width' : 400
                },
                'multi'	: false
            },
            //jcrop 插件配置
            jcrop : {
                setSelect: [0,0,218,128],
                aspectRatio: 218/128,
                //是否覆盖原图
                overwrite : 1
            },
            //预览选项，如果有多个预览预览图就配置多个选项
            privewOptions : {

                '#preview_1' : {
                    width : 218,
                    height : 128
                },

                '#preview_2' : {
                    width : 128,
                    height : 128
                }
            },
            //裁剪成功回调函数
            onSuccess : function() {
                JDialog.tip.work({type:'ok', content:'裁剪成功！', timer : 1000});
                //显示保存按钮
                $('#update_logo_form .save_btn').show();
            },

            //裁剪失败回调
            onError : function(message) {
                JDialog.tip.work({type:'error', content:message, timer : 1000});
            }
        };
        if ( __params.uploadConfig ) {
            upload_configs = $.extend(upload_configs, __params.uploadConfig);
        }
        $('#media_logo_upload').UploadCrop(upload_configs);

    } catch (e) {}


    /**
     * 计时器函数
     * @param obj 计时器按钮对象
     * @param timer 剩余时间
     */
    var __counter = function (obj, timer) {

        this.running = true;

        __counter.prototype.start = function() {
            timer--;
            if ( timer <= 0 || this.running == false ) {
                $(obj).attr('disabled', false);
                $(obj).html("点击获取！");
                return false;
            }
            var __self = this;
            $(obj).html(timer+"秒后重发！");
            setTimeout(function() {
                __self.start();
            }, 1000)
        };

        __counter.prototype.stop = function() {
            this.running = false;
        };

    };

    //初始化区域选择
    try {
        var __area = new JAreaSelect({
            data : AREA_DATA,
            container : 'area-select-box',
            showCountry : false,
            ids : __params.ids,
            maxAreaLevel : 3,
            autoInit: true
        });
        $('#area').html(__area.getAddress().replace('中国','')+__params.address);
    } catch (e) {}

    //绑定邮箱，发送邮件授权码
    $('#bind_email_btn').on('click', function() {

        var email = $.trim($('#bind_email').val());
        var template = $(this).attr('data-template');
        if ( !__pattern['email'].test(email) ) {
            JDialog.tip.work({type:'error', content:'请输入正确的邮箱地址', timer:1500});
            return false;
        }

        var __button = this;
        $.get('/common_authcode_sendEmailCode.shtml', {
            'email' : email,
            'template' : template
        }, function(res) {

            if ( res.state == 'ok' ) {
                // start the counter
                var counter = new __counter(__button, 120);
                counter.start();

                JDialog.tip.work({type:'ok', content:'邮件已经发送到您 '+email+ '邮箱中，请登录邮箱获取授权码，30分钟内输入有效！', timer:3000});
            } else {
                JDialog.tip.work({type:'error', content:res.message, timer:3000});
            }

        }, 'json');

        return false;
    });

    //绑定手机，发送授权码
    $('#bind_mobile_btn').on('click', function() {

        var mobile = $.trim($('#mobile').val());
        var template = $(this).attr('data-template');
        if ( !__pattern['mobile'].test(mobile) ) {
            JDialog.tip.work({type:'error', content:'请输入正确的手机号码', timer:1500});
            return false;
        }
        var __button = this;
        $.get('/common_authcode_sendMobileCode.shtml', {
            'mobile' : mobile,
            'template' : template
        }, function(res) {

            if ( res.state == 'ok' ) {
                // start the counter
                var counter = new __counter(__button, 120);
                counter.start();
                JDialog.tip.work({type:'ok', content:'授权码已经发送到您的注册手机 '+mobile+ '上，10分钟内输入有效！', timer:3000});
            } else {
                JDialog.tip.work({type:'error', content:res.message, timer:3000});
            }

        }, 'json');

        return false;
    });

    /* 媒体申请页面js */
    // 表单切换媒体类型
    $('#meida_Apply li').click(function(){
        var _this = $(this);
        _this.siblings().removeClass('current');
        _this.addClass('current');
        $('#meida_Apply_type').val(_this.attr('data-type-id'));
        $('#meida_Apply_text').html(_this.find('a').html());
    });
    $('.current').trigger('click');

    //上传身份证图片
    try {
        var uploadConfig = $.extend(__global.uploadConfig, {

            'formData'     : {
                'userid' : '{$loginUser[id]}',
                 'width' : 500
            },
            'multi'	: false,

            onUploadSuccess : function(file, data, response) {
                var res = $.parseJSON(data);
                $('#id_img').val(res.message);
                $('#id-preview').attr('src', res.message);
            },

            onUploadError : function(file, errorCode, errorMsg, errorString) {
                console.log.errorMsg;
            }
        });
        $('#id_src').uploadify(uploadConfig);

        //上传机构扫描件
        var uploadConfig = $.extend(__global.uploadConfig, {
            'formData'     : {
                'userid' : '{$loginUser[id]}',
                'width' : 500
            },
            'multi'	: false,

            onUploadSuccess : function(file, data, response) {
                var res = $.parseJSON(data);
                $('#company_img').val(res.message);
                $('#company-previw').attr('src', res.message);
            },

            onUploadError : function(file, errorCode, errorMsg, errorString) {
                console.log.errorMsg;
            }
        });
        $('#company_src').uploadify(uploadConfig);

    } catch (e) {}

    /**
     * 置顶文章的排序
     */
    //向上移动
    $('.move-up').on('click', function(e) {
        var index = $(this).attr('data-id');
        var currentItem = $('#tr-'+index);
        var container = currentItem.parent();
        var childrenIndex = container.children().index(currentItem);
        if ( childrenIndex == 0 ) return;
        var currentSort = currentItem.find('.sort_num').val();
        var prevSort = currentItem.prev().find('.sort_num').val();
        //互换排序数字
        currentItem.find('.sort_num').val(prevSort);
        currentItem.prev().find('.sort_num').val(currentSort);
        //提交数据
        var formdata = $('#content_add_form').serialize();
        $.post('/media_article_updateTopSort', formdata, function(res) {
            if ( res.state == 'ok') {
                //移动节点
                currentItem.insertBefore(container.children().get(childrenIndex-1));
            }
            JDialog.tip.work({type:res.state, content:res.message, timer:1000});
        }, 'json');

    });

    //向下移动
    $('.move-down').on('click', function(e) {
        var index = $(this).attr('data-id');
        var currentItem = $('#tr-'+index);
        var container = currentItem.parent();
        var childrenIndex = container.children().index(currentItem);
        if ( childrenIndex == container.children().length - 1  ) return;
        var currentSort = currentItem.find('.sort_num').val();
        var nextSort = currentItem.next().find('.sort_num').val();
        //互换排序数字
        currentItem.find('.sort_num').val(nextSort);
        currentItem.next().find('.sort_num').val(currentSort);
        //提交数据
        var formdata = $('#content_add_form').serialize();
        $.post('/media_article_updateTopSort', formdata, function(res) {
            if ( res.state == 'ok') {
                //移动节点
                currentItem.insertAfter(container.children().get(childrenIndex+1));
            }
            JDialog.tip.work({type:res.state, content:res.message, timer:1000});
        }, 'json');

    });

});
