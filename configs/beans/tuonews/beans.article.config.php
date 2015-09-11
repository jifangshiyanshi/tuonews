<?php

use herosphp\bean\Beans;
/**
 * 文章模块 Beans装配配置
 * @author yangjian102621@163.com
 * @since 1.0 - Nov 26, 2012
 */
$beans = array(
    /* 文章服务 */
    'article.article.service'=>array(
        '@type'=>Beans::BEAN_OBJECT,
        '@class' => 'article\service\ArticleService',
        '@attributes' => array(
            '@bean/modelDao'=>array(
                '@type'=>Beans::BEAN_OBJECT,
                '@class'=>'article\dao\ArticleDao',
                '@params' => array('article', 'articleTagAssoc')
            )
        ),
    ),

    /* 文章视图服务 */
    'article.view.service'=>array(
        '@type'=>Beans::BEAN_OBJECT,
        '@class' => 'article\service\ArticleViewService',
        '@attributes' => array(
            '@bean/modelDao'=>array(
                '@type'=>Beans::BEAN_OBJECT,
                '@class'=>'article\dao\ArticleViewDao',
                '@params' => array('articleView')
            )
        ),
    ),


    /* 文章标签服务 */
    'article.tags.service'=>array(
        '@type'=>Beans::BEAN_OBJECT,
        '@class' => 'article\service\ArticleTagService',
        '@attributes' => array(
            '@bean/modelDao'=>array(
                '@type'=>Beans::BEAN_OBJECT,
                '@class'=>'article\dao\ArticleTagDao',
                '@params'=> array('articleTag', 'articleTagAssoc')
            )
        ),
    ),

    /* 文章标签订阅服务 */
    'article.tags.order'=>array(
        '@type'=>Beans::BEAN_OBJECT,
        '@class' => 'article\service\ArticleTagOrderService',
        '@attributes' => array(
            '@bean/modelDao'=>array(
                '@type'=>Beans::BEAN_OBJECT,
                '@class'=>'article\dao\ArticleTagOrderDao',
                '@params'=> array('articleTagOrder')
            )
        ),
    ),

    /* 文章推荐位置服务 */
    'article.rec.service'=>array(
        '@type'=>Beans::BEAN_OBJECT,
        '@class' => 'article\service\ArticleRecService',
        '@attributes' => array(
            '@bean/modelDao'=>array(
                '@type'=>Beans::BEAN_OBJECT,
                '@class'=>'article\dao\ArticleRecDao',
                '@params'=> array('articleRec')
            )
        ),
    ),

    /* 单文章服务 */
    'artone.artone.service'=>array(
        '@type'=>Beans::BEAN_OBJECT,
        '@class' => 'article\service\ArtoneService',
        '@attributes' => array(
            '@bean/modelDao'=>array(
                '@type'=>Beans::BEAN_OBJECT,
                '@class'=>'article\dao\ArtoneDao',
                '@params' => array('artone', 'artoneData')
            )
        ),
    ),

    /* 单文章显示位置服务 */
    'artone.position.service'=>array(
        '@type'=>Beans::BEAN_OBJECT,
        '@class' => 'article\service\ArtonePositionService',
        '@attributes' => array(
            '@bean/modelDao'=>array(
                '@type'=>Beans::BEAN_OBJECT,
                '@class'=>'article\dao\ArtonePositionDao',
                '@params' => 'artonePosition'
            )
        ),
    ),

    /* 用户爆料服务 */
    'tipoff.tipoff.service'=>array(
        '@type'=>Beans::BEAN_OBJECT,
        '@class' => 'article\service\TipOffService',
        '@attributes' => array(
            '@bean/modelDao'=>array(
                '@type'=>Beans::BEAN_OBJECT,
                '@class'=>'article\dao\TipOffDao',
                '@params' => 'tipOff'
            )
        ),
    ),

    /* 用户评论 by jifangshiyanshi 2015/9/7 */
    'article.service.comment'=>array(
        '@type'=>Beans::BEAN_OBJECT,
        '@class'=>'article\service\ArticleCommentService',
        '@attributes'=>array(
           '@bean/modelDao'=>array(   
               '@type'=>Beans::BEAN_OBJECT,  
               '@class'=>'article\dao\ArticleCommentDao',
               '@params'=>'articleComment',
           )                                                           
        ),                                                            
    ),
);
return $beans;