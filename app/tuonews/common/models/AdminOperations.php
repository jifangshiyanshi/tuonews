<?php

return array(

    //系统模块
    'system' => array(
        'name' => '系统',
        'actions' => array(
            //系统配置
            'config' => array(
                'name' => '系统配置',
                'methods' => array(
                    'index' => '浏览配置',
                    'add' => '添加配置',
                    'delete' => '删除配置',
                )
            ),

            //后台菜单
            'menu' => array(
                'name' => '菜单管理',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'delete' => '删除'
                )
            ),

            //菜单分组
            'gmenu' => array(
                'name' => '菜单分组',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'delete' => '删除'
                )
            ),

            //区域管理
            'area' => array(
                'name' => '区域管理',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'delete' => '删除'
                )
            ),

            /* 管理员用户 */
            'admin' => array(
                'name' => '管理员用户',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'delete' => '删除'
                )
            ),

            //管理员角色
            'role' => array(
                'name' => '管理员角色',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'delete' => '删除',
                    'permission' => '修改权限'

                )
            ),

            //频道管理
            'chanel' => array(
                'name' => '频道管理',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'delete' => '删除'
                )
            ),

            //友情链接
            'friendLink' => array(
                'name' => '友情链接',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'delete' => '删除'
                )
            ),

            'ad' => array(
                'name' => '广告管理',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'delete' => '删除'
                )
            ),
        ),
    ),

    //会员模块
    'member' => array(
        'name' => '会员',
        'actions' => array(
            'user' => array(
                'name' => '会员管理',
                'methods' => array(
                    'index' => '浏览',
                    'edit' => '编辑',
                    'delete' => '删除',
                    'check' => '审核',
                )
            ),

            'userGroup' => array(
                'name' => '会员分组',
                'methods' => array(
                    'index' => '浏览',
                    'edit' => '编辑',
                    'delete' => '删除',
                )
            ),

            'userRole' => array(
                'name' => '会员角色',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'delete' => '删除',
                )
            ),
        )
    ),

    //文章模块
    'member' => array(
        'name' => '会员',
        'actions' => array(
            'user' => array(
                'name' => '会员管理',
                'methods' => array(
                    'index' => '浏览',
                    'edit' => '编辑',
                    'delete' => '删除',
                    'check' => '审核',
                )
            ),

            'userGroup' => array(
                'name' => '会员分组',
                'methods' => array(
                    'index' => '浏览',
                    'edit' => '编辑',
                    'delete' => '删除',
                )
            ),

            'userRole' => array(
                'name' => '会员角色',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'delete' => '删除',
                )
            ),
        )
    ),

    //图文模块
    'article' => array(
        'name' => '图文模块',
        'actions' => array(
            'article' => array(
                'name' => '图文管理',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'delete' => '删除',
                    'check' => '审核',
                    'config' => '模块配置'
                )
            ),
            'articleUser' => array(
                'name' => '用户资讯管理',
                'methods' => array(
                    'index' => '浏览',
                    'edit' => '编辑',
                    'Fcheck' => '文章审核',
                    'trash' => '回收站列表',
                    'update' => '更新资讯',
                    'mtrash'=>'批量删除到回收站',
                    'recovery'=>'从回收站恢复',
                    'delete' => '删除',
                    'mcheck' => '批量审核',
                )
            ),
            'articlecat' => array(
                'name' => '图文分类管理',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'delete' => '删除'
                )
            ),

            'articleAttr' => array(
                'name' => '文章属性',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'delete' => '删除'
                )
            ),

            'articleSource' => array(
                'name' => '文章来源',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'delete' => '删除'
                )
            ),

            'articleRec' => array(
                'name' => '文章推荐位',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'delete' => '删除'
                )
            ),
        )
    ),

    //会员模块
    'user' => array(
        'name' => '会员模块',
        'actions' => array(

            'user' => array(
                'name' => '会员模块',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'delete' => '删除',
                    'config' => '模块配置',
                )
            ),

            'userGroup' => array(
                'name' => '会员分组',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'delete' => '删除'
                )
            ),

            'shop' => array(     /* 云铺管理 */
                'name' => '店铺管理',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'delete' => '删除'
                )
            )

        )
    ),

    //公司模块
    'system' => array(
        'name' => '公司模块',
        'actions' => array(
            'images' => array(
                'name' => '图片空间',
                'methods' => array(
                    'index' => '浏览',
                    'edit' => '编辑',
                    'delete' => '删除',
                    'config' => '模块配置'
                )
            ),

            'ad' => array(
                'name' => '广告管理',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'delete' => '删除'
                )
            ),
            'adModel' => array(
                'name' => '广告位管理',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'delete' => '删除'
                )
            ),
            'channel' => array(
                'name' => '广告频道管理',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'delete' => '删除'
                )
            ),
            'link' => array(
                'name' => '友情链接',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'delete' => '删除'
                )
            ),
            'linkType' => array(
                'name' => '友情链接频道',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'delete' => '删除'
                )
            ),
            /* 公告管理 */
            'notice' => array(
                'name' => '公告管理',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'delete' => '删除',
                )
            ),

            /* 底部内容管理 */
            'footer' => array(
                'name' => '底部内容管理',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'delete' => '删除',

                )
            ),
            /* 标签管理 */
            'tag' => array(
                'name' => '标签管理',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'delete' => '删除',

                )
            ),
        )
    ),

    //产品模块
    'goods' => array(
        'name' => '商品模块',
        'actions' => array(
            'goods' => array(
                'name' => '商品管理',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'config' => '模块配置',
                    'check' => '审核',
                    'delete' => '删除'
                )
            ),

            'goodsModel' => array(
                'name' => '商品模型',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'updateModelTree' => '更新模型缓存',
                    'delete' => '删除'
                )
            ),

            'goodsCategory' => array(
                'name' => '商品分类',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'updateCategoryCache' => '更新分类缓存',
                    'delete' => '删除'
                )
            ),

            'brand' => array(
                'name' => '商品品牌',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'delete' => '删除'
                )
            ),
        )
    ),

    //装修平台
    'design' => array(
        'name' => '装修平台',
        'actions' => array(
            'templateCategory' => array(
                'name' => '行业分类',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'delete' => '删除'
                )
            ),
            'templatePage' => array(
                'name' => '模板页面',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'delete' => '删除'
                )
            ),
            'templateLayout' => array(
                'name' => '模板布局',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'delete' => '删除'
                )
            ),
            'templateStyle' => array(
                'name' => '模板风格',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'delete' => '删除'
                )
            ),
            'templateColor' => array(
                'name' => '模板色系',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'delete' => '删除'
                )
            ),
            'templatePpt' => array(
                'name' => '平台PPT',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'delete' => '删除'
                )
            ),
            'template' => array(
                'name' => '模板',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'delete' => '删除'
                )
            ),
            'templateMobile' => array(
                'name' => '手机模板',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'delete' => '删除'
                )
            ),
            'templateModule' => array(
                'name' => '模板模块',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'delete' => '删除'
                )
            ),
        ),
    ),

    //客服服务
    'service' => array(
        'name' => '客服服务',
        'actions' => array(
            'customCenter' => array(
                'name' => '客服中心',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'delete' => '删除'
                )
            ),
            'customCategory' => array(
                'name' => '客服分类',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'delete' => '删除'
                )
            ),
            'certification' => array(
                'name' => '认证信息',
                'methods' => array(
                    'index' => '个人认证',
                    'company' => '公司认证',
                    'add' => '添加',
                    'edit' => '编辑',
                    'delete' => '删除'
                )
            ),

            'inform' => array(
                'name' => '举报管理',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'delete' => '删除'
                )
            ),
            'complaint' => array(
                'name' => '投诉管理',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'delete' => '删除'
                )
            ),
            'consult' => array(
                'name' => '咨询管理',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'delete' => '删除'
                )
            ),
            'violat' => array(
                'name' => '违规管理',
                'methods' => array(
                    'index' => '浏览',
                    'add' => '添加',
                    'edit' => '编辑',
                    'delete' => '删除'
                )
            )

        ),
    ),

);
