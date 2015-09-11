/**
 * admin应用公共js代码
 * @author  yangjian<yangjian102621@163.com>
 */

//兼容IE10 win8
(function () {
    'use strict';
    if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
        var msViewportStyle = document.createElement('style')
        msViewportStyle.appendChild(
            document.createTextNode(
                '@-ms-viewport{width:auto!important}'
            )
        )
        document.querySelector('head').appendChild(msViewportStyle)
    }
})();

//去除字符串的空格
if ( !String.prototype.trim ) {
    String.prototype.trim = function() {
        return this.replace(/^\s+}\s+$/, '');
    }
}

//全局JS对象
var __global = {

    //JDialog 的配置参数
    jdialog: {
        timer: 2000,   //提示框的显示时间
        winHeight: ($(window).height() - 120),    //弹出窗口的高度
        winBorderWidth: 8,    //弹出窗口的边框宽度
        winWidth: 90,         //弹出窗宽度
        widthType: 'percent',   //设置弹出窗口为父窗口百分比
        winMaxWidth: 1024,
        winSkin: 'default'    //弹出窗口的皮肤
    },

    //列表内容的配置文档
    contentList: {
        formId: 'J_ListForm',   //列表表单ID
        checkAllId: 'check-all',   //全选的checkbox ID
        checkboxName: 'ids[]',   //checkbox 的name属性，用来过滤全选的checkbox
        emptyTd: 'empty-table-td',     //空行td的class
        tableId: 'J_ListTable'         //数据类表ID
    },

    //uploadify上传插件配置
    uploadConfig : {
        'swf'      : 'http://'+window.location.host+'/res/global/js/uploadify/uploadify.swf',
        'queueContainer' : '#queue',
        'auto'     : true,  //是否自动上传
        'removeTimeout' : 1,  //移除dom延时
        'buttonImage' : 'http://'+window.location.host+'/res/global/js/uploadify/upload.png',  //上传按钮图片
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
        minSize: [50,50],
        aspectRatio: 1,
        //后端图片裁剪地址
        cropUrl : '/image_upload_crop.shtml'
    }
};

/**
 * 初始化页面
 */
$(document).ready(function() {

    __global.siteUrl = $('#website_url').val();

    //自动计算数据列表表格的colspan
    $('.'+__global.contentList.emptyTd).each(function() {

        var th = $(this).parent().parent().prev().children(":first").children();
        $(this).attr('colspan', th.length);

    });

    //初始化checkbox组件
    $('[data-toggle="checkbox"]').radiocheck();
    $('[data-toggle="radio"]').radiocheck();

    /* 初始化开关标签 */
    if ($('[data-toggle="switch"]').length) {
        $('[data-toggle="switch"]').bootstrapSwitch({onSwitchChange : function(e, state) {
            var ele = e.target;
            if ( state ) {      //更改状态时改变值
                $(ele).parent().parent().next().val(1);
            } else {
                $(ele).parent().parent().next().val(0);
            };
        }});
    }

    //初始化select组件
    if ( $('[data-toggle="select"]').length > 0 ) {
        $('[data-toggle="select"]').select2();
    }

    //为内容表单绑定全选事件
    var form = document.getElementById(__global.contentList.formId);
    if ( form != null ) {

        var elements = form.elements;
        var length = elements.length;

        $('#'+__global.contentList.checkAllId).on('change.radiocheck', function(e) {

            //获取事件对象
            var target = e.target;
            for ( var i = 0; i < length; i++ ) {
                if ( elements[i].type != 'checkbox'
                    || (elements[i].name != __global.contentList.checkboxName) ) continue;

                if ( target.checked == true ) {
                    $(elements[i]).radiocheck('check');
                } else {
                    $(elements[i]).radiocheck('uncheck');
                }
            }

        });
    }

    //初始化bootstrap工具提示框插件
    $('[data-toggle="tooltip"]').tooltip();

    /* 初始化 AjaxProxy 插件 */
    AjaxProxy.init({
        className:'ajaxproxy',
        dataType:'json',
        formId : 'content_add_form',
        callbackDelay : 1000,
        timeInterval : 1000
    });

    //删除一条记录
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

                        JDialog.tip.work({type:data.state, content:data.message, timer:__global.jdialog.timer});
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

    //分页跳转事件绑定
    $('#page-goto').click(function() {

        var page = $(this).prev().val();
        var url = $(this).attr('url');
        location.href = url.replace('{page}', page);

    });

});

/**
 * 批量操作前回调
 * @param data
 */
function multiCallbefore(data) {

    data = data || '您真的要删除选中记录吗？';
    if ( !window.confirm(data) ) {
        return false;
    }

    var ids = getCheckedIds(__global.contentList.formId);
    if ( ids.length == 0 ) {
        JDialog.tip.work({type:'error', content:'您没有选择任何记录！', timer : __global.jdialog.timer});
        return false;
    }

    return true;
}

/**
 * 获取选中记录id
 * @param formId
 * @returns {Array}
 */
function getCheckedIds( formId ) {

    formId = formId || __global.contentList.tableId;
    var elements = document.getElementById(formId);      //获取表单元素
    var ids = [];
    for ( var i = 0; i < elements.length; i++ ) {
        if ( elements[i].type != 'checkbox' ) continue;
        if ( elements[i].name != __global.contentList.checkboxName ) continue;
        if ( elements[i].checked == true ) ids.push(elements[i].value.trim());
    }
    return ids;

}

/**
 * 创建日历选择对象
 * @param id
 * @param options
 * @returns {number}
 */
function createDatePicker( id, options ) {
    //初始化 datepicker 插件
    options = options || {};
    $('#'+id).click(function() {new WdatePicker(options);});
    return 0;
}

/**
 * 获取指定尺寸的缩略图
 * @param string src 原图地址
 * @param string size尺寸如: 120x120
 * @return string
 */
function getImageBySize( src, size ) {

    var position = src.lastIndexOf('.');
    var ext = src.substring(position);
    return src+'.'+size+ext;

}




