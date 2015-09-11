/**
 * 图片上传裁剪的代码
 * @author  yangjian<yangjian102621@163.com>
 */
(function($){
    $.fn.extend({
        UploadCrop : function(options){

            //初始化参数
            settings = $.extend(true, defaults, options);

            //绑定裁剪事件
            settings.jcrop.onSelect = updateCoords;
            settings.jcrop.onChange = updatePreview;
            settings.jcrop.onDblClick = doCrop;

            //记录上传按钮id
            settings.upload_btn_id = '#'+$(this).attr('id');

            settings.upload.onUploadSuccess = function(file, data, response) {

                var res = $.parseJSON(data);
                if ( res.state == 1 ) {

                    //隐藏上传按钮
                    $(settings.upload_btn_id).hide(1000);
                    //给缩略图表单赋值
                    $(settings.cropSrc).val(res.message);
                    //显示裁剪预览
                    $(settings.cropId).attr('src', res.message).parent().show();
                    var previewBox = $(settings.previewBox);
                    previewBox.show();
                    previewBox.find('.preview').attr('src', res.message);

                    //初始化预览元素
                    for ( var name in settings.privewOptions ) {
                        $(name).parent().css({
                            width : settings.privewOptions[name].width + 'px',
                            height : settings.privewOptions[name].height + 'px',
                            margin : 0 ,
                            overflow : 'hidden',
                            float : 'left'
                        });
                    }

                    $(settings.cropId).Jcrop(settings.jcrop,
                        function() {
                            var bounds = this.getBounds();
                            boundx = bounds[0];
                            boundy = bounds[1];
                            jcrop_api = this;
                        }
                    );

                } else {
                    alert(res.message);
                }

            };
            defaults.upload.onUploadError = function(file, errorCode, errorMsg, errorString) {
                console.log.errorMsg;
            }
            $(this).uploadify(settings.upload);
        }
    });

    //默认参数
    var defaults = {
        upload : __global.uploadConfig || {},
        jcrop : __global.jcropConfig || {},
        //裁剪目标图片的ID
        cropId : '#crop_target',
        //存储裁剪的源图片的表单元素id
        cropSrc : '#src',
        //预览图片框
        previewBox : '#preview_box'
        }, settings;

    //头像裁剪
    var jcrop_api, boundx, boundy;

    //更新坐标
    function updateCoords(c)
    {
        $('#x').val(c.x);
        $('#y').val(c.y);
        $('#w').val(c.w);
        $('#h').val(c.h);
    }

    //更新预览
    function updatePreview(c) {

        if ( parseInt(c.w) > 0 && settings.privewOptions != undefined ) {

            for ( var name in settings.privewOptions ) {
                var pos = settings.privewOptions[name];
                var rx = pos.width / c.w;
                var ry = pos.height / c.h;
                $(name).css({
                    width: Math.round(rx * boundx) + 'px',
                    height: Math.round(ry * boundy) + 'px',
                    marginLeft: '-' + Math.round(rx * c.x) + 'px',
                    marginTop: '-' + Math.round(ry * c.y) + 'px'
                });
            }
        }
    }

    /**
     * 执行裁剪操作
     * @param c jcrop对象
     */
    function doCrop(c) {

        $(settings.uploadId).show();
        $(settings.cropId).parent().hide();
        $.post(settings.jcrop.cropUrl, {

            'x' : c.x,
            'y' : c.y,
            'w' : c.w,
            'h' : c.h,
            '_w' : settings.jcrop.setSelect[2],
            '_h' : settings.jcrop.setSelect[3],
            'overwrite' : settings.jcrop.overwrite,
            'src': $(settings.cropSrc).val()

        }, function(res) {

            if ( res.state == 1 ) {

                settings.onSuccess();
                //销毁裁剪
                jcrop_api.destroy();
                //显示上传按钮
                $(settings.upload_btn_id).show();

            } else if( res.state == 0 ) {
                settings.onError(res.message);
            }

        }, 'json');
    }

})(jQuery);

