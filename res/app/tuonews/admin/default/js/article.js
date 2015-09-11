/**
 * 博客模块的js代码
 * @author  yangjian<yangjian102621@163.com>
 */

window.__params = window.__params || {};

//处理定时发布
$('#publish-setting [data-toggle="radio"]').on('change.radiocheck', function(e) {

    var value = $(this).val();
    if ( value == '1' ) {
        $('#publish-time-box').hide();
        //清空发布时间
        $('#publish-time').val('');
    } else {
        $('#publish-time-box').show();
    }
});

//实现文章自动保存功能,每30秒钟保存一次
//setInterval(function() {
//
//}, 30*1000)

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
                $('#article-tag-input').data('tagsinput').destroy();
            } catch (e) {}
            //重新创建tagInput对象
            $('#article-tag-input').val(res.message).tagsinput({maxTags: 5});

        } else {
            JDialog.tip.work({type:'warn', content:'获取标签失败！', timer:'2000'});
        }

        //重置按钮样式
        try {
            $(me).button('reset');
        } catch (e) {}

    }, 'json');
});

//初始化文章标签插件
$('#article-tag-input').tagsinput({maxTags: 5});

//初始化发布时间日历选择
createDatePicker('publish-time', {dateFmt:'yyyy-MM-dd H:mm',minDate:'%y-%M-%d}'});

//添加推荐位文章
var __articles = {

    data : __params.data || {},

    add : function(id,title) {

        if ( __articles[id] != undefined ) {
            alert('该文章已被添加！');
            return false;
        }

        this.data[id] = title;

        this.update();
    },

    remove : function(id) {

        this.data[id] = null;
        this.update();
    },

    update : function() {
        var aids = new Array();
        $('#article-list-box').empty();
        console.log(this.data);
        for ( var name in this.data ) {
            if ( this.data[name] ) {
                $('#article-list-box').append('<p class="text-info">'+this.data[name]+' <a href="javascript:__articles.remove('+name+');" class="link del">删除</a></p>');
                aids.push(name);

            }
        }

        $('#art-ids').val(aids.join(','));
    }

};

//缩略图上传
try {
    $('#thumb_upload').UploadCrop({

        //裁剪dom id
        cropId : '#crop_target',

        cropSrc : '#thumb_src',

        //uploadify 插件配置
        upload : {
            'formData'     : {
                'userid' : __params.userid,
                'media_id' : __params.media_id,
                'width' : 700
            },
            'multi'	: false,
            'removeTimeout'	: 0.5,
            'uploader' : __params.uploader
        },
        //jcrop 插件配置
        jcrop : {
            setSelect: [0,0,620,290],
            aspectRatio: 620/290,
            allowResize : true,
            cropUrl : __params.cropUrl
        },

        //预览选项，如果有多个预览预览图就配置多个选项
        privewOptions : {

            '#preview_1' : {
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
} catch (e) {}


