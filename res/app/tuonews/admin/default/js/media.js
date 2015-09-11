/**
 * 媒体模块js代码
 * @author  yangjian<yangjian102621@163.com>
 */

window.__params = window.__params || {};

//添加推荐位文章
var __medias = {

    data : __params.data || {},

    add : function(id,title) {

        if ( __medias[id] != undefined ) {
            alert('该媒体已被添加！');
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
        $('#media-list-box').empty();
        for ( var name in this.data ) {
            if ( this.data[name] ) {
                $('#media-list-box').append('<p class="text-info">'+this.data[name]+' <a href="javascript:__medias.remove('+name+');" class="link del">删除</a></p>');
                aids.push(name);

            }
        }

        $('#media-ids').val(aids.join(','));
    }

};

$(function() {

    //上传并裁剪logo
    $('#thumb_upload').UploadCrop({

        //裁剪dom id
        cropId : '#crop_target',

        cropSrc : '#thumb_src',

        //uploadify 插件配置
        upload : {
            'formData'     : {
                'userid' : __params.userid,
                'media_id' : __params.media_id,
                'width' : 500
            },
            'multi'	: false,
            'removeTimeout'	: 0.5,
            'uploader' : __params.uploader
        },
        //jcrop 插件配置
        jcrop : {
            setSelect: [0,0,218,128],
            aspectRatio: 218/128,
            cropUrl : __params.cropUrl
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
            $('#logo_thumb')
            JDialog.tip.work({type:'ok', content:'裁剪成功！', timer : 1000});
        },

        //裁剪失败回调
        onError : function(message) {
            JDialog.tip.work({type:'error', content:message, timer : 1000});
        }
    });

    //上传身份证
    var configs = {
        'formData'     : {
            'userid' : __params.userid,
            'media_id' : __params.media_id,
            'width' : 500
        },

        'onUploadSuccess':function(file,data,response){
            var dd=eval("("+data+")");
            $("#thumb-old-id img").attr("src",dd.message);
            $("#id_img").val(dd.message);
        }
    }
    var upConfig= $.extend(__global.uploadConfig,configs);
    $('#id_img_upload').uploadify(upConfig);

    //上传营业执照
    var configs ={
        'formData'     : {
            'userid' : __params.userid,
            'media_id' : __params.media_id,
            'width' : 500
        },

        'onUploadSuccess':function(file,data,response){
            var dd=eval("("+data+")");
            $("#thumb-old-company img").attr("src",dd.message);
            $("#company_img").val(dd.message);
        }
    }
    var upConfig= $.extend(__global.uploadConfig,configs);
    $('#company_img_upload').uploadify(upConfig);

});


