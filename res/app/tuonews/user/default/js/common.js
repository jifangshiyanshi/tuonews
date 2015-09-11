/**
 * Created by zhao on 2015-5-12.
 */

var __global = {
    //uploadify上传插件配置
    uploadConfig : {
        'swf'      : '/res/global/js/uploadify/uploadify.swf',
        'queueContainer' : '#queue',
        'auto'     : true,  //是否自动上传
        'removeTimeout' : 1,  //移除dom延时
        'buttonImage' : '/res/global/js/uploadify/upload.png',  //上传按钮图片
        'height'          : 40,
        'wmode' : 'transparent',
        'width'           : 120,
        'fileSizeLimit' : '2MB', //最大上传文件
        'fileTypeExts' : '*.gif; *.jpg; *.jpeg; *.png;', //允许上传文件的后缀
        'multi'				: false,
        'uploader' : '/image_upload_index.shtml'
    },
    //Jcrop插件配置信息
    jcropConfig : {
        aspectRatio: 1,
        //后端图片裁剪地址
        cropUrl : '/image_upload_crop.shtml'
    }
};

$(function (){
    /*	懒加载图片	*/
    $("img.lazy").lazyload({
        threshold		: document.documentElement.clientHeight,
        skip_invisible	: false,
        failurelimit : 100
    });
    //header
    $('.header .item').hover(function(){
        $(this).find('.sublist').slideDown();
    },function(){
        $(this).find('.sublist:animated').stop();
        $(this).find('.sublist').slideUp();
    });
    //权限全选
    var select_role=$('.select_role');
    if(select_role[0]){
        var checkbox= select_role.find('dd input:checkbox');
        var selectAll= select_role.find('dt input:checkbox');
        selectAll.click(function(){
            var childCheckbox=$(this).parents('.select_item').find('dd input:checkbox');
            childCheckbox.prop('checked',this.checked);
        });
        checkbox.click(function(){
            var childCheckbox=$(this).parents('.select_item').find('dd input:checkbox');
            var parentCheckbox= $(this).parents('.select_item').find('dt input:checkbox');
            parentCheckbox.prop('checked',childCheckbox.length==childCheckbox.filter(':checked').length);
        });
    }
    //全选
    $('.select_all').click(function(){
        var checkboxChild = $(this).parents('table').find('.select_child');
        checkboxChild.prop('checked',this.checked);
    });
    $('.select_child').click(function(){
            var checkboxALL = $(this).parents('table').find('.select_all');
            checkboxALL.prop('checked',$('.select_child').length==$('.select_child').filter(':checked').length);
    });
    //编辑展开
    (function(){
        $('.ucenter_edit_box .edit_form').hide();
    })();
    $('.ucenter_edit_box').on('click','.edit_btn',function(){
        var editForm=$(this.parentNode).find('.edit_form')
        if(editForm.css('display') == 'none'){
            this.innerHTML = '收起<span class="icon icon_edit_up"></span>';
            editForm.show(200);
        }else {
            this.innerHTML = '编辑<span class="icon icon_edit_down"></span>';
            editForm.hide(200);
        }
    });
    /* 初始化 AjaxProxy 插件 */
    AjaxProxy.init({
        className:'ajaxproxy',
        dataType:'json',
        formId : 'content_add_form',
        callbackDelay : 2000,
        timeInterval : 1000
    });
//    $('.ajaxproxy').click(function(){
//        JDialog.tip.work({
//            type : 'warn',
//            content : this.getAttribute('data-loading-text'),
//            timer : 1000
//        })
//    });
    (function(){
        $('.layout-main').css('min-height',$('.layout-left')[0].offsetHeight+'px');
    })();

    //绑定删除内容事件
    $('.delone').click(function() {

        var url = $(this).attr('href');
        var deltip = $(this).attr('deltip') || '真的要删除该记录吗？'
        var self = this;
        JDialog.confirm.work({
            title : '删除提示',
            content : deltip,
            button : {
                '确定' : function() {
                    $.get(url, function(data) {

                        if ( data.state == 'ok' ) {
                            $(self).parents('tr').remove();
                        }

                        JDialog.tip.work({type:data.state, content:data.message, timer:1500});
                        JDialog.confirm.remove();

                    }, 'json');
                },

                '取消' : function() {
                    JDialog.confirm.remove();
                }
            }
        });
        return false;
    });
});
