<?php
/**
 * 企业媒体操作菜单数组
 * @author yangjian<yangjian102621@163.com>
 */

return array(

    array(
        'name' => '系统管理',
        'icon' => 'icon_sys',
        'sub' => array(
            array(
                'name' => '角色管理',
                'opt' => array('managerRole@index', 'managerRole@add'),
                'url' => url('/media_managerRole_index')
            ),
            array(
                'name' => '媒体管理员',
                'opt' => array('manager@index'),
                'url' => url('/media_manager_index')
            ),
        )
    ),

    array(
        'name' => '文章管理',
        'icon' => 'icon_article',
        'sub' => array(
            array(
                'name' => '文章列表',
                'opt' => array('article@index', 'article@uncheck', 'article@checked', 'article@aborted'),
                'url' => url('/media_article_index')
            ),
            array(
                'name' => '发表文章',
                'opt' => array('article@add'),
                'url' => url('/media_article_add')
            ),
            array(
                'name' => '关于我们',
                'opt' => array('artone@index'),
                'url' => url('/media_artone_index')
            ),

        )
    ),
    array(
        'name' => '设置管理',
        'icon' => 'icon_set',
        'sub' => array(
            array(
                'name' => '媒体信息',
                'opt' => array('profile@index'),
                'url' => url('/media_profile_index')
            ),
        )
    ),
);
