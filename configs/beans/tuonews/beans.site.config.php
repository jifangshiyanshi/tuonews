<?php

use herosphp\bean\Beans;
/**
 * 媒体站模块 Beans装配配置
 * @author yangjian102621@163.com
 * @since 1.0 - Nov 26, 2012
 */
$beans = array(
    
    /* 模板服务 */
    'site.template.service'=>array(
        '@type'=>Beans::BEAN_OBJECT,
        '@class' => 'site\service\TemplateService',
        '@attributes' => array(
            '@bean/modelDao'=>array(
                '@type'=>Beans::BEAN_OBJECT,
                '@class'=>'site\dao\TemplateDao',
                '@params' => 'template'
            )
        ),
    ),

    /* 媒体模板服务 */
    'media.template.service'=>array(
        '@type'=>Beans::BEAN_OBJECT,
        '@class' => 'site\service\MediaTemplateService',
        '@attributes' => array(
            '@bean/modelDao'=>array(
                '@type'=>Beans::BEAN_OBJECT,
                '@class'=>'site\dao\MediaTemplateDao',
                '@params' => 'mediaTemplate'
            )
        ),
    ),

);
return $beans;