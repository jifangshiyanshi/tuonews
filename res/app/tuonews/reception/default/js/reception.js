/**
 * Created by zhao on 2015-5-12.
 */
define(function(require,exports,module){
    var $ = require('jquery');
    $(function (){
        /*导航*/
        var url= location.href;
        var articlesChanel=document.getElementById('articles_chanel');
        if(articlesChanel){
            var articlesChanel=articlesChanel.href;
        }
        $('#nav a').each(function(){
            var href=this.href;
            var flag=false;
            href==url?flag=true:href==articlesChanel?flag=true:'';

            if(flag) {
                $(this).parents('.nav_item ').addClass('current');
            }
        });

        /*	懒加载图片	*/
        require('jq_plugins/jquery.lazyload.min');
        $("img.lazy").lazyload({
            threshold		: document.documentElement.clientHeight,
            skip_invisible	: false,
            failurelimit : 100,
            load : function(elements_left, settings) {
                var _this = $(this);
                _this.removeClass('lazy');
                _this.removeAttr('data-original');
            }
        });
        //lazyload修正
        window.onscroll=function(){};
        window.onscroll();
		 //header
        $('.header .user_item').hover(function(){
            $(this).find('.sublist').slideDown();
        },function(){
            $(this).find('.sublist:animated').stop();
            $(this).find('.sublist').slideUp();
        });
        //nav
        $('.nav_item').hover(function(){
            $(this).find('.nav_sublist').slideDown();
        },function(){
            $(this).find('.nav_sublist:animated').stop();
            $(this).find('.nav_sublist').slideUp();
        });
        //slider
        var banner= $('.banner');
        if (banner[0]){
            require('jq_plugins/slider');
            banner.slider({
                event: 'mouseenter',
                effects: "slideX",
                interval: 3000,
                fullScreen: false,
                createControl: false,
                hasSideControl: true,
                fadeSideControl: false
            });
        }
        //tab
        var aside_ranking= $(".aside_ranking_tab");
        var reg_tab = $(".reg_tab");
        if(aside_ranking[0]||reg_tab[0]){
            require('jq_plugins/tab');
            reg_tab.tab({
                defaultIndex: 0,
                trigger: "click",
                auto: false
            });
            aside_ranking.tab({
                defaultIndex: 0,
                trigger: "mouseenter",
                auto: false
            });
        }
        $('.aside_ranking').find('.tab_conItem').each(function(){
            $(this).find('.item:lt(3)').each(function(){
                $(this).find('.index').addClass('hot_index');
            })
        });
        //article_tag 查看更多
        (function(){
            $('.article_tag').each(function(){
                var defaultH = $(this).find('.info_box').outerHeight();
                var currentH= $(this).find('.info').outerHeight();
                if(currentH<defaultH){
                    $(this).find('.more').hide();
                }
            });
        })();
        $('.article_tag .more').click(function(){
            var article_tag= $(this).parents('.article_tag');
            var defaultH=article_tag.find('.title_box').outerHeight();
            var targetH=article_tag.find('.info').outerHeight();
            var currentH=article_tag.find('.info_box').outerHeight();
            if(currentH<targetH) {
                article_tag.find('.info_box').height(targetH + 'px');
                this.innerHTML='收起<span class="icon icon_up"></span>';
            }else if(currentH>targetH){
                article_tag.find('.info_box').height(defaultH + 'px');
                this.innerHTML='查看更多<span class="icon icon_down"></span>';
            }
        });
        require('jq_plugins/ajaxProxy');
        //订阅
        $('.subscribe_ajax_btn').ajaxProxy({
            queueList: true,
            dataType: 'json',
            success: function(data){
                ajaxProxyThis=ajaxProxyArr.shift();
                //message 订阅 on off 未登录 login 错误 error
                var type=data.message;
                var filter= ajaxProxyThis.attr('data-ajax-data');
                if (type==='on') {
                    $('.subscribe_ajax_btn').each(function(){
                        var _this=$(this);
                        if(_this.attr('data-ajax-data') == filter){
                            _this.removeClass('subscribe_add');
                            _this.addClass('subscribe_remove');
                            _this.attr('data-ajax-url', '/article_media_unorder');
                        }
                    });
                }
                else if( type==='off' ){
                    $('.subscribe_ajax_btn').each(function(){
                        var _this=$(this);
                        if(_this.attr('data-ajax-data') == filter){
                            _this.addClass('subscribe_add');
                            _this.removeClass('subscribe_remove');
                            _this.attr('data-ajax-url', '/article_media_order');
                        }
                    });
                } else if( type==='login'){
                        $('#login_popup_btn').click();
                } else if ( type==='error') {
                        alert('操作失败');
                }
                    ajaxProxyThis=null;
            },
            error:function(){
                ajaxProxyThis=ajaxProxyArr.shift();
            }
        });

        //文章收藏
        $('#collection').ajaxProxy({
            lockTime: 1000,
            dataType: 'json',
            success: function(data){
                var collection = $('#collection');
                if(data.message=='on'){ //收藏
                    collection.removeClass('collection_off');
                    collection.addClass('collection_on');
                    collection.attr('data-ajax-url','{url /article_article_uncollection}');
                }else if(data.message=='off'){ //取消收藏
                    collection.addClass('collection_off');
                    collection.removeClass('collection_on');
                    collection.attr('data-ajax-url','{url /article_article_collection}');
                }else if(data.message=='login'){ //未登录
                    $('#login_popup_btn').click();
                }
            }
        });
        //文章赞
        $('#zan').ajaxProxy({
            lockTime: 1000,
            dataType: 'json',
            success: function(data){
                if(data.message=='success'){ //成功
                    var zan=$('#zan');
                    zan.removeClass('zan_off');
                    zan.addClass('zan_on');
                    var num=parseInt(zan.find('.num').html());
                    zan.find('.num').html(num+1);
                    $('#zan').unbind();
                    /*                    $('#zan').attr('data-ajax-data','');
                     }else if(data.message=='off'){
                     $('#zan').addClass('zan_off');
                     $('#zan').removeClass('zann_on');
                     $('#zan').attr('data-ajax-data','');*/
                }else if(data.message=='login'){ //未登录
                    $('#login_popup_btn').click();
                }
            }
        });
        //tags
        $('.subscribe_ajax_btn_tag').ajaxProxy({
            queueList: true,
            success: function(data){
                ajaxProxyThis=ajaxProxyArr.shift();
                //message 订阅 on off 未登录 login 错误 error
                var type=data.message;
                if (type==='on') {
                    ajaxProxyThis.removeClass('subscribe_add');
                    ajaxProxyThis.addClass('subscribe_remove');
                    ajaxProxyThis.attr('data-ajax-url', '/article_tags_unorder');
                    ajaxProxyThis.find('.on').hide();
                    ajaxProxyThis.find('.off').show();
                }
                else if( type==='off' ){
                    ajaxProxyThis.addClass('subscribe_add');
                    ajaxProxyThis.removeClass('subscribe_remove');
                    ajaxProxyThis.attr('data-ajax-url', '/article_tags_order');
                    ajaxProxyThis.find('.off').hide();
                    ajaxProxyThis.find('.on').show();
                } else if( type==='login'){
                    $('#login_popup_btn').click();
                } else if ( type==='error') {
                    alert('操作失败');
                }
                ajaxProxyThis=null;
            },
            error:function(){
                ajaxProxyThis=ajaxProxyArr.shift();
            }
        });
        //弹窗
        var template=require('plugins/artTemplate.min');
        var templateData = {};
        var html = template('login_template', templateData);
        var JDialog=require('jq_plugins/JDialog');
        JDialog = JDialog.JDialog;
        $('#login_popup_btn').click(function(e){
            e.preventDefault();
            JDialog.lock.work({opacity:0.5});
            JDialog.win.work({
                title : '帐号登录',
                skin : 'popup_login',
                borderWidth: 0,
                content : html
            });
            //弹窗登陆ajax
            $('#login_submit_popup').ajaxProxy({
                dataType:'json',
                success:function(data){

                    //邮箱没有激活
                    if ( data.state  == 'not_active' ) {
                        var button = $('#__send_active_email');
                        button.parent().show();
                        var url = button.attr('href').replace('(email)', data.message);
                        button.attr('href', url);
                        return;
                    }

                    if( data.state == 'ok' ) {
                        location.reload();
                    }else {
                        alert(data.message);
                    }
                }
            });
        });
        //ajax 分页
        $('#page_ajax').ajaxProxy({
            before:     function(){
                var pageNum=parseInt($.parseJSON(this.data).page)+1;
                $('#page_ajax').attr('data-ajax-data','{"page":"'+ pageNum +'"}');
                this.data='{"page":"'+ pageNum +'"}';
            },
            lockTime:   0,
            dataType:   'json',
            success:    function(data){
                if(data.data.length<20){
                    $('#page_ajax').fadeOut(200);
                }
                var templateData = {list:data.data}
                var html = template('page_template', templateData);
                $('.article_list .list').append(html);
            }
        });


        /**
         * 登录，注册页面js代码
         * added by yangjian 2015-06-06
         */
        //正则表达式映射
        var __pattern = {
            'username' : /^[0-9|a-z|\-|_]{4,20}$/i,
            'email' : /^[a-z0-9]{1}\w{1,18}@[a-z0-9]{1,20}(\.[a-z]{1,6}){1,3}$/i,
            'mobile' : /^1[3|4|5|7|8][0-9]{9}$/
        };

        //用户登录
        $('#user_login_btn').on('click', function() {

            var url = $(this).attr('url');
            var pass = $('#pass').val();
            var user = $('#account').val();
            if ( user == '' ) {
                JDialog.tip.work({type:'error', content:'用户名不能为空！', timer:1500});
                return false;
            }
            if ( pass == '' ) {
                JDialog.tip.work({type:'error', content:'密码不能为空！', timer:1500});
                return false;
            }
            $.post(url, {

                username : user,
                password : pass

            }, function(res) {

                //邮箱没有激活
                if ( res.state  == 'not_active' ) {
                    var button = $('#send_active_email');
                    button.parent().show();
                    var url = button.attr('href').replace('(email)', res.message);
                    button.attr('href', url);
                    return;
                }
                if ( res.state == 'ok' ) {
                    location.replace('/user_ucenter_index.shtml');
                }

                JDialog.tip.work({type:res.state, content:res.message, timer:1500});

            }, 'json');
            return false;

        });

        //发送短信授权码
        $('#send_mobile_message').on('click', function() {

            var mobile = $('#mobile').val();
            if ( !__pattern['mobile'].test(mobile) ) {
                JDialog.tip.work({type:'error', content:'手机号码格式不正确！', timer:1500});
                return false;
            }

            // disbale the button
            $(this).attr('disabled', true);
            var __button = this;
            $.post('/common_authcode_sendMobileCode.shtml', {
                'mobile' : mobile,
                'template' : 'mobile_register'
            }, function(res) {

                if ( res.state == 'ok' ) {
                    var counter = new __counter(__button, 60);
                    counter.start();
                }
                JDialog.tip.work({type:res.state, content:res.message, timer:1500});

            }, 'json');
            return false;
        });

        //提交注册验证
        $('.user-reg').on('click', function() {

            var formId = $(this).attr('data-form');
            var form = document.getElementById(formId);
            var elements = form.elements;
            //数据验证
            for ( var i = 0; i < elements.length; i++ ) {

                if ( elements[i].type != 'text' && elements[i].type != 'password' ) {
                    continue;
                }
                var dtype = elements[i].getAttribute('dtype'),
                    value = elements[i].value,
                    tiptxt = elements[i].getAttribute('tiptxt');

                if ( $.trim(value) == '' ) {

                    JDialog.tip.work({type:'error', content:tiptxt+'不能为空！', timer:1500});
                    return false;

                } else if ( __pattern[dtype] != undefined && !__pattern[dtype].test(value) ) {

                    JDialog.tip.work({type:'error', content:tiptxt+'格式不正确！', timer:1500});
                    return false;

                }

            }

            //提交表单
            var url = form.getAttribute('action');
            if ( url != '' ) {
                var formData = $('#'+formId).serialize();
                $.post(url, formData, function(res) {

                    if ( res.state == 'ok' ) {
                        JDialog.tip.work({type:'ok', content:'注册成功，跳转到登录页面……', timer:1500});
                        setTimeout(function() {
                            //引导用户去邮件激活页面
                            location.replace(res.message);
                        }, 1500);
                    } else {
                        JDialog.tip.work({type:'error', content: res.message, timer:1500});
                    }

                }, 'json');
            }

            return false;
        });

        //发送注册激活邮件
        $('#email-active').on('click', function() {

            if ( $(this).attr('disabled') ) {
                return false;
            }

            var url = $(this).attr('href');
            $(this).attr('disabled', true);
            var __button = this;
            //显示正在发送
            $('#sending').show();

            $.get(url, function(res) {

                if ( res.state == 'ok' ) {
                    //隐藏正在发送
                    $('#sending').hide();
                    // start the counter
                    var counter = new __counter(__button, 120);
                    counter.start();
                    $('#tip-text').html('验证邮件已发送至您的注册邮箱，请尽快登录邮箱完成激活。');
                }
                JDialog.tip.work({type:res.state, content:res.message, timer:1500});

            }, 'json');
            return false;
        });

        /**
         * 计时器函数
         * @param obj 计时器按钮对象
         * @param timer 剩余时间
         */
        var __counter = function (obj, timer) {

            $(obj).data('text', $(obj).html());
            $(obj).attr('disabled', true);
            this.running = true;

            __counter.prototype.start = function() {
                timer--;
                if ( timer <= 0 || this.running == false ) {
                    $(obj).attr('disabled', false);
                    $(obj).html($(obj).data('text'));
                    return false;
                }
                var __self = this;
                $(obj).css('width', 120+'px').html(timer+" 秒后重发！");
                setTimeout(function() {
                    __self.start();
                }, 1000)
            };

            __counter.prototype.stop = function() {
                this.running = false;
            };

        };

        //媒体管理员邀请登录验证
        $('#invite_check_btn').on('click', function() {
            var username = $.trim($('#account').val());
            var pass = $.trim($('#pass').val());
            var authcode = $.trim($('#authcode').val());
            var url = $(this).attr('url'), formId = $(this).attr('form-id');
            var formdata;   //表单数据
            if ( username == '' ) {
                JDialog.tip.work({type:'error', content:'用户名不能为空！', timer:1500});
                return false;
            }
            if ( pass == '' ) {
                JDialog.tip.work({type:'error', content:'密码不能为空！', timer:1500});
                return false;
            }
            if ( authcode == '' ) {
                JDialog.tip.work({type:'error', content:'邀请码不能为空！', timer:1500});
                return false;
            }

            //获取表单数据
            formdata = $(formId).serialize();
            $.post(url, formdata, function(res) {

                if ( res.state == 'ok' ) {
                    JDialog.tip.work({type:'ok', content:'验证成功，页面正在跳转……', timer:1500});
                    setTimeout(function() {
                        location.replace(res.message);
                    }, 1500);
                } else {
                    JDialog.tip.work({type:res.state, content:res.message, timer:1500});
                }

            }, 'json');
        });

        /* 重置密码js */
        //下一步,检测用户名是否存在
        $('#reset_next_step').on('click', function() {

            var username = $.trim($('#reset_username').val());
            if ( username == '' ) {
                $('#reset_username').next().html('请输入用户名').css({'color' : '#cc0000'});
                return false;
            }
            $.get('/user_resetPass_checkUser.shtml', {
                username : username
            }, function(res) {

                if ( res.state == 'error' ) {
                    $('#reset_username').next().html(res.message).css({'color' : '#cc0000'});
                } else {
                    document.getElementById('reset_pass_select').submit();
                }

            }, 'json');
            return false;
        });

        //邮箱重置密码表单
        $('#email_reset_pass_btn').on('click', function() {

            var form  = $('#email_reset_pass');
            var authcode = form.find('#authcode').val();
            var password = form.find('#password').val();
            var repass = form.find('#repass').val();

            if ( $.trim(authcode) == '' ) {
                JDialog.tip.work({type:'error', content:'授权码不能为空！', timer:1500});
                return false;
            }
            if ( $.trim(password) == '' ) {
                JDialog.tip.work({type:'error', content:'密码不能为空！', timer:1500});
                return false;
            }
            if ( $.trim(repass) == '' ) {
                JDialog.tip.work({type:'error', content:'确认不能为空！', timer:1500});
                return false;
            }
            if ( password != repass ) {
                JDialog.tip.work({type:'error', content:'两次输入密码不一致！', timer:1500});
                return false;
            }

            var formdata = form.serialize();
            $.post('/user_resetPass_password.shtml', formdata, function(res) {

                if ( res.state == 'ok' ) {
                    location.replace('/user_resetPass_finish.shtml');
                }
                JDialog.tip.work({type:res.state, content:res.message, timer:1500});

            }, 'json');
            return false;

        });

        //发送邮件确认
        $('#reset_pass_send_email').on('click', function() {

            var email = $(this).attr('data-email');
            var template = $(this).attr('data-template');

            var __button = this;
            $.get('/common_authcode_sendEmailCode.shtml', {
                'email' : email,
                'template' : template
            }, function(res) {

                if ( res.state == 'ok' ) {
                    // start the counter
                    var counter = new __counter(__button, 120);
                    counter.start();
                    $('#message_tip_box').html('邮件已经发送到您 '+email+ '邮箱中，请登录邮箱获取授权码，2小时内输入有效！').css({'color':'#0000cc'}).show();
                } else {
                    $('#message_tip_box').html(res.message).css({'color':'#cc0000'}).show();
                }

            }, 'json');

            return false;
        });

        //发送短信授权码
        $('#reset_pass_send_mobile').on('click', function() {

            var mobile = $(this).attr('data-email');
            var template = $(this).attr('data-template');

            var __button = this;
            $.get('/common_authcode_sendMobileCode.shtml', {
                'mobile' : mobile,
                'template' : template
            }, function(res) {

                if ( res.state == 'ok' ) {
                    // start the counter
                    var counter = new __counter(__button, 60);
                    counter.start();
                    $('#message_tip_box').html('授权码已经发送到您的注册手机 '+mobile+ '上，10分钟内输入有效！').css({'color':'#0000cc'}).show();
                } else {
                    $('#message_tip_box').html(res.message).css({'color':'#cc0000'}).show();
                }

            }, 'json');

            return false;
        });
        //补全信息
        $('#fill_btn').on('click',function(e) {
            e.preventDefault();
            var formId = $(this).attr('data-form');
            var form = document.getElementById(formId);
            var elements = form.elements;
            //数据验证
            for ( var i = 0; i < elements.length; i++ ) {
                if ( elements[i].type != 'text' && elements[i].type != 'password' ) {
                    continue;
                }
                var dtype = elements[i].getAttribute('dtype'),
                    value = elements[i].value,
                    tiptxt = elements[i].getAttribute('tiptxt');
                if ( $.trim(value) == '' ) {
                    JDialog.tip.work({type:'error', content:tiptxt+'不能为空！', timer:1500});
                    return false;
                } else if ( __pattern[dtype] != undefined && !__pattern[dtype].test(value) ) {
                    JDialog.tip.work({type:'error', content:tiptxt+'格式不正确！', timer:1500});
                    return false;
                }
            }

            //提交表单
            var url = form.getAttribute('action');
            if ( url != '' ) {
                var formData = $('#'+formId).serialize();
                $.post(url, formData, function(res) {
                    if ( res.state == 'ok' ) {
                        JDialog.tip.work({type:'ok', content:'注册成功，跳转到登录页面……', timer:1500});
                        setTimeout(function() {
                            //跳转页面
                            location.href='/user_login_index';
                        }, 1500);
                    } else {
                        JDialog.tip.work({type:'error', content: res.message, timer:1500});
                    }
                }, 'json');
            }
            return false;
        });
        //绑定账号
        $('#binding_btn').on('click',function(e) {
            e.preventDefault();
            var formId = $(this).attr('data-form');
            var form = document.getElementById(formId);
            var elements = form.elements;
            //数据验证
            for ( var i = 0; i < elements.length; i++ ) {
                if ( elements[i].type != 'text' && elements[i].type != 'password' ) {
                    continue;
                }
                var dtype = elements[i].getAttribute('dtype'),
                    value = elements[i].value,
                    tiptxt = elements[i].getAttribute('tiptxt');
                if ( $.trim(value) == '' ) {
                    JDialog.tip.work({type:'error', content:tiptxt+'不能为空！', timer:1500});
                    return false;
                } else if ( __pattern[dtype] != undefined && !__pattern[dtype].test(value) ) {
                    JDialog.tip.work({type:'error', content:tiptxt+'格式不正确！', timer:1500});
                    return false;
                }
            }

            //提交表单
            var url = form.getAttribute('action');
            if ( url != '' ) {
                var formData = $('#'+formId).serialize();
                $.post(url, formData, function(res) {
                    if ( res.state == 'ok' ) {
                        JDialog.tip.work({type:'ok', content:'注册成功，跳转到登录页面……', timer:1500});
                        setTimeout(function() {
                            //跳转页面
                            location.href='/user_login_index';
                        }, 1500);
                    } else {
                        JDialog.tip.work({type:'error', content: res.message, timer:1500});
                    }
                }, 'json');
            }
            return false;
        });
    });
});
