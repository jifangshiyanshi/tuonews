/**
 * Created by MoKi on 2015-6-3.
 * 基于jq $.ajax 封装ajax
 */
define(function(require,exports,module){
    var $ = require('jquery');
    $.fn.ajaxProxy=function(options){
        //布尔值转换
        function changeBool(str){
            if(str === 'true'){return true;}
            return false;
        }
        //function 转换
        function changeFn(str){
            if(str === 'string'){ return new Function("data", 'return '+str);}
            return str;
        }
        var defaults={
            url:        '',//ajax地址
            data:       '',//发生请求数据
            type:       this.attr('data-ajax-type')?this.attr('data-ajax-type'):'post',//发送请求模式
            async:      this.attr('data-ajax-async')?changeBool(this.attr('data-ajax-async')):true,//加载模式
            success:    function(){},
            error:      this.attr('data-ajax-error')?this.attr('data-ajax-error'):function(){},
            dataType:   this.attr('data-ajax-dataType')?this.attr('data-ajax-dataType'):'json',//ajax 数据类型 json jsonp等
            lockTime:   this.attr('data-ajax-lockTime')?this.attr('data-ajax-lockTime'):'1000',//锁定按钮时间 避免重复发送
            lockClass:  this.attr('data-ajax-lockClass')?this.attr('data-ajax-lockClass'):'disable',//锁定按钮样式
            //lockBefore: function(){},//锁定前执行函数
            //lockAfter:  function(){},//锁定后执行函数
            event:      this.attr('data-ajax-event')?this.attr('data-ajax-event'):'click',//触发事件
            validate:   false,//触发事件
            before:     function(){},//ajax执行前方法
            queueList:  false,//ajax元素队列
            complete:   function(){}
        };
        var options=$.extend(defaults, options);
        if(this){
            if(options.queueList){
                ajaxProxyArr=[];
                ajaxProxyThis='';
              /*  options.complete=function(){
                    ajaxProxyThis=ajaxProxyArr.shift();
                    console.log(ajaxProxyThis)
                }*/
            }
            $(this)[options.event] (function(e){
                e.preventDefault();
                var _this=$(this);
                //对应赋值
                options.url=_this.attr('data-ajax-url')?_this.attr('data-ajax-url'):_this.parents('form').attr('action');
                options.data=_this.attr('data-ajax-data')?_this.attr('data-ajax-data'):'';
                //ajax 锁定
                var time_index= this.time_index = 0;
                function lockBtn(){
                    _this.addClass(options.lockClass);
                    setTimeout(function(){
                        time_index++;
                        if(time_index<parseInt(options.lockTime/1000)){
                            lockBtn();
                        }else{
                            _this.removeClass(options.lockClass);
                        }
                    },options.lockTime);
                }

                if(this.className.indexOf(options.lockClass)<0){
                    lockBtn();
                    options.before();
                    //data转换
                    if(options.data == ''){
                        options.data=$(this).parents('form').serialize();
                    }else if(typeof options.data=='string'){
                        if(options.data.indexOf('{"')>-1){
                        options.data= $.parseJSON(options.data);
                    }
                    }
                    //队列
                    if(options.queueList){
                        ajaxProxyArr.push($(this));
                    }
                    $.ajax({
                        type: options.type,
                        url: options.url,
                        data: options.data,
                        async: options.async,
                        dataType: options.dataType,
                        success: options.success,
                        error:  options.error,
                        complete: options.complete
                    });
                }
            })
        }
    }
});
