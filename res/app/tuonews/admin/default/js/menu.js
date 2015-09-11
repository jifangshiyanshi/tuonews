/**
 * 后台菜单模块的js代码
 * @author  yangjian<yangjian102621@163.com>
 */

//分组和菜单联动
$('#menu-group-select').select2().on('change', function() {

    var key = $(this).val();
    $('#pmenu-select').empty();
    //加载一级分类
    $.get('/admin_menu_getTopMemnu', {groupkey:key}, function(res) {

        if ( res.state == 'ok' ) {

            var data = res.message;
            $('#pmenu-select').append('<option value="0">顶级分类</option>');
            for ( var i = 0; i < data.length; i++ ) {
                $('#pmenu-select').append('<option value="'+data[i].id+'">'+data[i].name+'</option>');
            }
        }

    }, 'json');
});


