/**
 * Created by yangjian on 15-6-14.
 * ucenter js code here
 */
$(function(){

    if ( __param == undefined ) {
        var __param = {};
    }
    //正则表达式映射
    var __pattern = {
        'username' : /^[0-9|a-z|\-|_]{4,20}$/i,
        'email' : /^[a-z0-9]{1}\w{1,18}@[a-z0-9]{1,20}(\.[a-z]{1,6}){1,3}$/i,
        'mobile' : /^1[3|4|5|7|8][0-9]{9}$/
    };

    //上传裁剪头像
    $('#user_logo').UploadCrop({
        //裁剪目标图片的ID
        cropId : '#crop_target',
        //存储裁剪的源图片的表单元素id
        cropSrc : '#header',
        //uploadify 插件配置
        upload : {
            'formData'     : {
                'userid' : __param.userid || 0,
                'width' : 400
            },
            'multi'	: false
        },
        //jcrop 插件配置
        jcrop : {
            setSelect: [0,0,200,200],
            aspectRatio: 1,
            //是否覆盖原图
            overwrite : 1
        },
        //预览选项，如果有多个预览预览图就配置多个选项
        privewOptions : {

            '#preview_1' : {
                width : 200,
                height : 200
            },

            '#preview_2' : {
                width : 200,
                height : 200
            }
        },
        //裁剪成功回调函数
        onSuccess : function() {
            JDialog.tip.work({type:'ok', content:'裁剪成功！', timer : 1000});
        //显示保存按钮
            $('#update_head_form .save_btn').show();
        },

        //裁剪失败回调
        onError : function(message) {
            JDialog.tip.work({type:'error', content:message, timer : 1000});
        }
    });


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

});
