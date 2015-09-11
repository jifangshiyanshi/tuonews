<?php

use herosphp\bean\Beans;
/**
 * 文章模块 Beans装配配置
 * @author yangjian102621@163.com
 * @since 1.0 - Nov 26, 2012
 */
$beans = array(
    /* 管理员服务 */
    'admin.admin.service'=>array(
        '@type'=>Beans::BEAN_OBJECT,
        '@class' => 'admin\service\AdminService',
        '@attributes' => array(
            '@bean/modelDao'=>array(
                '@type'=>Beans::BEAN_OBJECT,
                '@class'=>'admin\dao\AdminDao',
                '@params'=>'adminUser'
            )
        ),
    ),

    /* 管理员角色服务 */
    'admin.role.service'=>array(
        '@type'=>Beans::BEAN_OBJECT,
        '@class' => 'admin\service\RoleService',
        '@attributes' => array(
            '@bean/modelDao'=>array(
                '@type'=>Beans::BEAN_OBJECT,
                '@class'=>'admin\dao\RoleDao',
                '@params'=>'adminRole'
            )
        ),
    ),

    /* 菜单分组服务 */
    'admin.menuGroup.service'=>array(
        '@type'=>Beans::BEAN_OBJECT,
        '@class' => 'admin\service\MenuGroupService',
        '@attributes' => array(
            '@bean/modelDao'=>array(
                '@type'=>Beans::BEAN_OBJECT,
                '@class'=>'admin\dao\MenuGroupDao',
                '@params'=>'adminMenuGroup'
            )
        ),
    ),

    /* 菜单服务 */
    'admin.menu.service'=>array(
        '@type'=>Beans::BEAN_OBJECT,
        '@class' => 'admin\service\MenuService',
        '@attributes' => array(
            '@bean/modelDao'=>array(
                '@type'=>Beans::BEAN_OBJECT,
                '@class'=>'admin\dao\MenuDao',
                '@params'=>'adminMenu'
            )
        ),
    ),

    /* 系统配置服务 */
    'admin.config.service'=>array(
        '@type'=>Beans::BEAN_OBJECT,
        '@class' => 'admin\service\ConfigService',
        '@attributes' => array(
            '@bean/modelDao'=>array(
                '@type'=>Beans::BEAN_OBJECT,
                '@class'=>'admin\dao\ConfigDao',
                '@params'=>'config'
            )
        ),
    ),

    /* 系统消息模板服务 */
    'admin.messageTemplate.service'=>array(
        '@type'=>Beans::BEAN_OBJECT,
        '@class' => 'admin\service\MessageTemplateService',
        '@attributes' => array(
            '@bean/modelDao'=>array(
                '@type'=>Beans::BEAN_OBJECT,
                '@class'=>'admin\dao\MessageTemplateDao',
                '@params'=>'MessageTemplate'
            )
        ),
    ),

    /* 系统频道服务 */
    'admin.chanel.service'=>array(
        '@type'=>Beans::BEAN_OBJECT,
        '@class' => 'admin\service\ChanelService',
        '@attributes' => array(
            '@bean/modelDao'=>array(
                '@type'=>Beans::BEAN_OBJECT,
                '@class'=>'admin\dao\ChanelDao',
                '@params'=>'chanel'
            )
        ),
    ),

    /* 友情链接服务 */
    'admin.friendlink.service'=>array(
        '@type'=>Beans::BEAN_OBJECT,
        '@class' => 'admin\service\FriendLinkService',
        '@attributes' => array(
            '@bean/modelDao'=>array(
                '@type'=>Beans::BEAN_OBJECT,
                '@class'=>'admin\dao\FriendLinkDao',
                '@params'=>'friendLink'
            )
        ),
    ),

    /* 系统保留字服务 */
    'admin.keywords.service'=>array(
        '@type'=>Beans::BEAN_OBJECT,
        '@class' => 'admin\service\KeywordsService',
        '@attributes' => array(
            '@bean/modelDao'=>array(
                '@type'=>Beans::BEAN_OBJECT,
                '@class'=>'admin\dao\KeywordsDao',
                '@params'=>'keywords'
            )
        ),
    ),
);
return $beans;
