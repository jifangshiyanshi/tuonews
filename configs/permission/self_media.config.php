<?php
/**
 * 自媒体权限配置数组
 * @author yangjian<yangjian102621@163.com>
 */

return array(

    'managerRole' => array(
        'name' => '角色管理',
        'methods' => array(
            'index' => '浏览',
            'insert' => '添加',
            'update' => '修改',
            'insert' => '添加',
            'delete'=>'删除',
        )
    ),
    'manager' => array(
        'name' => '媒体管理员',
        'methods' => array(
            'index' => '浏览',
            'insert' => '添加',
            'update' => '修改',
            'insert' => '添加',
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
            'insert' => '添加',
            'update' => '修改',
            'deletes' => '批量删除',
            'delete' => '删除单个',
        )
    ),
    'artone' => array(
        'name' => '单文章',
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
