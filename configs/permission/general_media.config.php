<?php
/**
 * 普通媒体权限配置数组
 * @author yangjian<yangjian102621@163.com>
 */

return array(

    'config' => array(
        'name' => '系统配置',
        'methods' => array(
            'index' => '浏览',
            'update' => '修改',
            'domain'=>'设置域名',
        )
    ),
    'managerRole' => array(
        'name' => '角色管理',
        'methods' => array(
            'index' => '浏览',
            'insert' => '添加',
            'update' => '修改',
            'delete'=>'删除',
        )
    ),
    'manager' => array(
        'name' => '媒体管理员',
        'methods' => array(
            'index' => '浏览',
            'insert' => '添加',
            'update' => '修改',
            'delete'=>'删除',
        )
    ),
    'nav' => array(
        'name' => '频道管理',
        'methods' => array(
            'index' => '浏览',
            'insert' => '添加',
            'update' => '修改',
            'delete'=>'删除',
        )
    ),
    'friendlink' => array(
        'name' => '友链管理',
        'methods' => array(
            'index' => '浏览',
            'insert' => '添加',
            'update' => '修改',
            'delete'=>'删除',
        )
    ),
    'article' => array(
        'name' => '媒体文章',
        'methods' => array(
            'index' => '浏览已发布',
            'checked' => '浏览已审核',
            'uncheck' => '浏览待审核',
            'aborted' => '浏览未通过',
            'top' => '浏览置顶文章',
            'insert' => '添加',
            'update' => '修改',
            'deletes' => '批量删除',
            'delete' => '删除单个',
            'addtop' => '添加置顶',
            'canceltop' => '取消置顶',
        )
    ),
    'articleRec' => array(
        'name' => '文章推荐位',
        'methods' => array(
            'index' => '浏览推荐位',
            'open' => '开启推荐位',
            'close' => '关闭推荐位',
            'detail' => '浏览推荐位文章',
            'updateArt' => '更新推荐位文章',
        )
    ),
    'artone' => array(
        'name' => '关于我们',
        'methods' => array(
            'index' => '浏览',
            'insert' => '添加',
            'update' => '修改',
            'quicksave' => '快速保存',
            'delete' => '删除',
        )
    ),
    'profile' => array(
        'name' => '媒体号配置',
        'methods' => array(
            'index' => '浏览',
            'update' => '修改',
        )
    ),
);
