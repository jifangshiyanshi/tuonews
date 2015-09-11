<?php
/**
 * 后台管理权限配置数组
 * @author yangjian<yangjian102621@163.com>
 */

return array(

    /***************** 系统模块 *********************/
    'config' => array(
        'name' => '系统配置',
        'methods' => array(
            'index' => '浏览',
            'insert' => '添加',
            'update' => '修改',
            'delete' => '删除'
        )
    ),
    'menu' => array(
        'name' => '后台菜单',
        'methods' => array(
            'index' => '浏览',
            'insert' => '添加',
            'update' => '修改',
            'quicksave' => '快速保存',
            'delete' => '删除'
        )
    ),
    'menuGroup' => array(
        'name' => '菜单分组',
        'methods' => array(
            'index' => '浏览',
            'insert' => '添加',
            'update' => '修改',
            'quicksave' => '快速保存',
            'delete' => '删除'
        )
    ),
    'admin' => array(
        'name' => '管理员',
        'methods' => array(
            'index' => '浏览',
            'insert' => '添加',
            'update' => '修改',
            'delete' => '删除'
        )
    ),
    'role' => array(
        'name' => '管理员角色',
        'methods' => array(
            'index' => '浏览',
            'insert' => '添加',
            'update' => '修改',
            'quicksave' => '快速保存',
            'permission' => '查看权限',
            'updatePermission' => '修改权限',
            'delete' => '删除'
        )
    ),
    'sTemplate' => array(
        'name' => '系统信息模板',
        'methods' => array(
            'index' => '浏览',
            'insert' => '添加',
            'update' => '修改',
            'delete' => '删除'
        )
    ),
    'keywords' => array(
        'name' => '系统保留关键字',
        'methods' => array(
            'index' => '浏览',
            'insert' => '添加',
            'update' => '修改',
            'delete' => '删除'
        )
    ),
    'chanel' => array(
        'name' => '频道',
        'methods' => array(
            'index' => '浏览',
            'insert' => '添加',
            'update' => '修改',
            'quicksave' => '快速保存',
            'delete' => '删除'
        )
    ),
    'friendLink' => array(
        'name' => '友情链接',
        'methods' => array(
            'index' => '浏览',
            'insert' => '添加',
            'update' => '修改',
            'quicksave' => '快速保存',
            'delete' => '删除'
        )
    ),

    /***************** 会员模块 *********************/
    'userGroup' => array(
        'name' => '会员分组',
        'methods' => array(
            'index' => '浏览',
            'insert' => '添加',
            'update' => '修改',
            'deletes' => '批量删除',
            'delete' => '删除'
        )
    ),
    'userRole' => array(
        'name' => '会员角色',
        'methods' => array(
            'index' => '浏览',
            'insert' => '添加',
            'update' => '修改',
            'deletes' => '批量删除',
            'delete' => '删除'
        )
    ),
    'user' => array(
        'name' => '会员',
        'methods' => array(
            'index' => '浏览',
            'insert' => '添加',
            'update' => '修改',
            'abort' => '封号',
            'unaborted' => '解封',
            'quickcheck' => '审核',
            'deletes' => '批量删除',
            'delete' => '删除',
        )
    ),

    /***************** 文章模块 *********************/
    'artRec' => array(
        'name' => '文章推荐位',
        'methods' => array(
            'index' => '浏览',
            'insert' => '添加',
            'update' => '修改',
            'quicksave' => '快速保存',
            'delete' => '删除',
        )
    ),
    'artTag' => array(
        'name' => '文章标签',
        'methods' => array(
            'index' => '浏览',
            'update' => '修改',
            'quicksave' => '快速保存',
            'deletes' => '批量删除',
            'delete' => '删除',
        )
    ),
    'article' => array(
        'name' => '文章',
        'methods' => array(
            'index' => '浏览',
            'insert' => '添加',
            'update' => '修改',
            'doCheck' => '审核',
            'articleStat' => '查看统计',
            'recommend' => '查看推荐栏',
            'doTrash' => '删除到回收站',
            'deletes' => '批量物理删除',
            'delete' => '物理删除',
        )
    ),
    'tipoff' => array(
        'name' => '用户爆料',
        'methods' => array(
            'index' => '浏览',
            'detail' => '查看详情',
            'deletes' => '批量删除',
        )
    ),
    'artonePos' => array(
        'name' => '单文章显示位',
        'methods' => array(
            'index' => '浏览',
            'insert' => '添加',
            'update' => '修改',
            'delete' => '删除',
        )
    ),
    'artone' => array(
        'name' => '单文章',
        'methods' => array(
            'index' => '浏览',
            'insert' => '添加',
            'update' => '修改',
            'delete' => '删除',
            'deletes' => '批量删除',
        )
    ),

    /***************** 媒体模块 *********************/
    'media' => array(
        'name' => '媒体',
        'methods' => array(
            'index' => '浏览',
            'insert' => '添加',
            'update' => '修改',
            'quicksave' => '快速保存',
            'multiCheck' => '审核',
            'apply' => '查看申请入驻',
            'delete' => '删除',
            'deletes' => '批量删除',
        )
    ),
    'mediaType' => array(
        'name' => '媒体类型',
        'methods' => array(
            'index' => '浏览',
            'insert' => '添加',
            'update' => '修改',
            'quicksave' => '快速保存',
            'delete' => '删除',
            'deletes' => '批量删除',
        )
    ),
    'mediaRec' => array(
        'name' => '媒体推荐位',
        'methods' => array(
            'index' => '浏览',
            'insert' => '添加',
            'update' => '修改',
            'quicksave' => '快速保存',
            'delete' => '删除',
            'deletes' => '批量删除',
        )
    ),
);
