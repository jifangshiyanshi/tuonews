/**
 * Created by yangjian on 15-07-17.
 * 媒体文章推荐位页面 js
 */
$(function(){

    //向上移动
    $('.table_list').on('click', '.move-up', function(e) {
        var index = $(this).attr('data-id');
        var currentItem = $('#tr-'+index);
        var container = currentItem.parent();
        var childrenIndex = container.children().index(currentItem);
        if ( childrenIndex == 0 ) return;
        //移动节点
        currentItem.insertBefore(container.children().get(childrenIndex-1));
        //提交数据
        var formdata = $('#content_add_form').serialize();
        $.post('/media_articleRec_updateArt', formdata, function(res) {
            if ( res.state == 'ok' ) {
                JDialog.tip.work({type:res.state, content:'移动成功！', timer:1000});
            } else {
                JDialog.tip.work({type:res.state, content:'移动失败！', timer:1000});
            }
        }, 'json');

    });

    //向下移动
    $('.table_list').on('click', '.move-down', function(e) {
        var index = $(this).attr('data-id');
        var currentItem = $('#tr-'+index);
        var container = currentItem.parent();
        var childrenIndex = container.children().index(currentItem);
        if ( childrenIndex == container.children().length - 1  ) return;
        //移动节点
        currentItem.insertAfter(container.children().get(childrenIndex+1));
        //提交数据
        var formdata = $('#content_add_form').serialize();
        $.post('/media_articleRec_updateArt', formdata, function(res) {
            JDialog.tip.work({type:res.state, content:res.message, timer:1000});
        }, 'json');

    });

    //添加文章弹出框
    $('#add-rec-article').on('click', function(e) {
        //初始化ID
        var init_ids = __recommend.aids;
        //获取文章数据
        JDialog.win.work({
            title : '添加文章',
            content : '<iframe src="/media_article_select/?ids='+init_ids+'" frameborder="0" width="100%" height="500"></iframe>',
            width : 600
        });

    });


});

//推荐文章操作接口
var __recommend = {

    aids : new Array(),
    init : function() {
        this.aids = document.getElementById('data-aids').innerHTML.split(",");
    },

    //添加文章
    add : function(id, title) {

        if ( this.aids.length >= 10 ) {
            JDialog.tip.work({type:'error', content:'每个最多添加10篇文章！', timer:1500});
            return false;
        }
        //如果空的单元格存在，删除
        try {
            $('#empty-tr-data').remove();
        } catch (e) {}
        //获取数据
        var item = {};
        item.title = title;
        item.id = id;
        //console.log(item);
        this.aids.unshift(item.id);
        //更新后台元素
        this.update(function() {
            //添加dom元素
            var dom = template.render('article-tr-template', {item:item});
            $('#content-tbody').prepend(dom);
        });
        return true;
    },

    //移除文章
    remove : function(obj) {

        var aid = $(obj).attr('data-id');

        //删除数组元素
        var __ids = [];
        for ( var i = 0; i < this.aids.length; i++ ) {
            if ( this.aids[i] != aid ) {
                __ids.push(this.aids[i]);
            }
        }
        this.aids = __ids;
        //更新后台元素
        this.update(function() {
            //移除dom元素
            $(obj).parent().parent().remove();
        });

    },

    /**
     * 更新数据到后台
     * @param callback 回调函数
     */
    update : function(callback) {

        //过滤数据
        var __ids = [];
        for ( var i = 0; i < this.aids.length; i++ ) {
            if ( this.aids[i] ) {
                __ids.push(this.aids[i]);
            }
        }
        //获取推荐位ID
        var id = document.getElementById('rec-id').innerHTML;
        $.post('/media_articleRec_updateArt/', {
            id : id,
            aids : __ids.join(',')
        }, function(res) {

            if ( res.state == 'ok' ) {
                callback();
            } else {
                JDialog.tip.work({type:'error', content:'添加文章失败！', timer:1000});
            }

        }, 'json')

    }


};
__recommend.init();
