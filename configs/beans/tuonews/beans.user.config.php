<?php

use herosphp\bean\Beans;
/**
 * 用户模块 Beans装配配置
 * @author yangjian102621@163.com
 * @since 1.0 - Nov 26, 2012
 */
$beans = array(
    /* 用户服务 */
    'user.user.service'=>array(
        '@type'=>Beans::BEAN_OBJECT,
        '@class' => 'user\service\UserService',
        '@attributes' => array(
            '@bean/modelDao'=>array(
                '@type'=>Beans::BEAN_OBJECT,
                '@class'=>'user\dao\UserDao',
                '@params' => array('user', 'userData')
            )
        ),
    ),

    /* 用户分组服务 */
    'user.group.service'=>array(
        '@type'=>Beans::BEAN_OBJECT,
        '@class' => 'user\service\UserGroupService',
        '@attributes' => array(
            '@bean/modelDao'=>array(
                '@type'=>Beans::BEAN_OBJECT,
                '@class'=>'user\dao\UserGroupDao',
                '@params' => 'userGroup'
            )
        ),
    ),

    /* 用户角色服务 */
    'user.role.service'=>array(
        '@type'=>Beans::BEAN_OBJECT,
        '@class' => 'user\service\UserRoleService',
        '@attributes' => array(
            '@bean/modelDao'=>array(
                '@type'=>Beans::BEAN_OBJECT,
                '@class'=>'user\dao\UserRoleDao',
                '@params' => 'userRole'
            )
        ),
    ),

    /* 用户站内信服务 */
    'user.message.service'=>array(
        '@type'=>Beans::BEAN_OBJECT,
        '@class' => 'user\service\UserMessageService',
        '@attributes' => array(
            '@bean/modelDao'=>array(
                '@type'=>Beans::BEAN_OBJECT,
                '@class'=>'user\dao\UserMessageDao',
                '@params' => 'userMessage'
            )
        ),
    ),

    /* 用户收藏服务 */
    'user.collect.service'=>array(
        '@type'=>Beans::BEAN_OBJECT,
        '@class' => 'user\service\UserCollectService',
        '@attributes' => array(
            '@bean/modelDao'=>array(
                '@type'=>Beans::BEAN_OBJECT,
                '@class'=>'user\dao\UserCollectDao',
                '@params' => 'userCollect'
            )
        ),
    ),
);
return $beans;