<?php

use herosphp\bean\Beans;
/**
 * 媒体模块 Beans装配配置
 * @author yangjian102621@163.com
 * @since 1.0 - Nov 26, 2012
 */
$beans = array(
    /* 媒体服务 */
    'media.media.service'=>array(
        '@type'=>Beans::BEAN_OBJECT,
        '@class' => 'media\service\MediaService',
        '@attributes' => array(
            '@bean/modelDao'=>array(
                '@type'=>Beans::BEAN_OBJECT,
                '@class'=>'media\dao\MediaDao',
                '@params' => array('media', 'mediaData')
            )
        ),
    ),

    /* 媒体频道服务 */
    'media.chanel.service'=>array(
        '@type'=>Beans::BEAN_OBJECT,
        '@class' => 'media\service\MediaChanelService',
        '@attributes' => array(
            '@bean/modelDao'=>array(
                '@type'=>Beans::BEAN_OBJECT,
                '@class'=>'media\dao\MediaChanelDao',
                '@params' => 'mediaChanel'
            )
        ),
    ),

    /* 媒体订阅服务 */
    'media.order.service'=>array(
        '@type'=>Beans::BEAN_OBJECT,
        '@class' => 'media\service\MediaOrderService',
        '@attributes' => array(
            '@bean/modelDao'=>array(
                '@type'=>Beans::BEAN_OBJECT,
                '@class'=>'media\dao\MediaOrderDao',
                '@params' => 'mediaOrder'
            )
        ),
    ),

    /* 媒体分类服务 */
    'media.type.service'=>array(
        '@type'=>Beans::BEAN_OBJECT,
        '@class' => 'media\service\MediaTypeService',
        '@attributes' => array(
            '@bean/modelDao'=>array(
                '@type'=>Beans::BEAN_OBJECT,
                '@class'=>'media\dao\MediaTypeDao',
                '@params' => 'mediaType'
            )
        ),
    ),

    /* 媒体友情链接服务 */
    'media.friendlink.service'=>array(
        '@type'=>Beans::BEAN_OBJECT,
        '@class' => 'media\service\MediaFriendLinkService',
        '@attributes' => array(
            '@bean/modelDao'=>array(
                '@type'=>Beans::BEAN_OBJECT,
                '@class'=>'media\dao\MediaFriendLinkDao',
                '@params' => 'mediaFriendLink'
            )
        ),
    ),

    /* 媒体推荐位服务 */
    'media.rec.service'=>array(
        '@type'=>Beans::BEAN_OBJECT,
        '@class' => 'media\service\MediaRecService',
        '@attributes' => array(
            '@bean/modelDao'=>array(
                '@type'=>Beans::BEAN_OBJECT,
                '@class'=>'media\dao\MediaRecDao',
                '@params' => 'mediaRec'
            )
        ),
    ),

    /* 媒体管理员服务 */
    'media.manager.service'=>array(
        '@type'=>Beans::BEAN_OBJECT,
        '@class' => 'media\service\MediaManagerService',
        '@attributes' => array(
            '@bean/modelDao'=>array(
                '@type'=>Beans::BEAN_OBJECT,
                '@class'=>'media\dao\MediaManagerDao',
                '@params' => 'mediaManager'
            )
        ),
    ),

    /* 媒体管理员角色服务 */
    'media.managerRole.service'=>array(
        '@type'=>Beans::BEAN_OBJECT,
        '@class' => 'media\service\MediaManagerRoleService',
        '@attributes' => array(
            '@bean/modelDao'=>array(
                '@type'=>Beans::BEAN_OBJECT,
                '@class'=>'media\dao\MediaManagerRoleDao',
                '@params' => 'mediaManagerRole'
            )
        ),
    ),

    /* 媒体文章推荐位服务 */
    'media.articleRec.service'=>array(
        '@type'=>Beans::BEAN_OBJECT,
        '@class' => 'media\service\MediaArticleRecService',
        '@attributes' => array(
            '@bean/modelDao'=>array(
                '@type'=>Beans::BEAN_OBJECT,
                '@class'=>'media\dao\MediaArticleRecDao',
                '@params' => 'mediaArticleRec'
            )
        ),
    ),
);
return $beans;
