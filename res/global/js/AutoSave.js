/**
 * 表单自动保存插件
 * @author      yangjian102621@gmail.com
 * @version     1.0.0
 * @since       2015-05-17
 * @copyright   FiiDee All Rights Reserved
 */
var AutoSave = function(options) {

    var defaultOptions = {
        //后端保存数据的url
        url : null,

        //需要保存的数据，可是数据对象或者表单的id
        data : null,

        //自动保存间隔时间， 单位ms
        saveInterval : 10000,

        //缓存所属用户id
        userid : 0,

        //编辑器对象，用来获取编辑器中的内容
        editor : null,

        //数据缓存的key
        cacheDataKey : null,

        //保存之前的回调,如果返回false,则取消保存
        beforeSave : function() {
            return true;
        },

        //缓存成功回调
        onSuccess : function(data) {},

        //缓存失败回调
        onError : function(data) {}

    }

    var __self = this;

    AutoSave.prototype.save = function() {

        if ( !__self.options.beforeSave() ) {
            return false;
        }
        if ( this.options.url == null ) {
            alert('From AutoSave plugin, 请指定数据保存的后端地址');
        }

        var data = this.options.data;
        //如果是表单id，则表示自动保存整个表单的数据
        if ( typeof data == 'string' ) {
            data = $('#'+data).serializeArray();
            if ( __self.options.editor != null ) {
                try {
                    //同步编辑器的内容
                    __self.options.editor.sync();
                } catch(e) {}
            }
        }

        //添加参数
        data.push({name : 'userid', value : this.options.userid});
        data.push({name : 'cache_key', value : this.options.cacheDataKey});

        $.post(this.options.url, $.param(data), function(res) {

            //保存成功
            if ( res.state == 'ok' ) {

                __self.options.onSuccess(res.message);

                //保存失败
            } else {
                __self.options.onError(res.message);
            }

            //继续自动保存
            setTimeout(function() {
                __self.save();
            }, __self.options.saveInterval);

        }, 'json');

    };

    //合并参数
    this.options = $.extend(defaultOptions, options);

    if ( this.options.saveInterval == '0' ) {
        return false;
    }

    //开始自动保存
    setTimeout(function() {
        __self.save();
    }, this.options.saveInterval);

};