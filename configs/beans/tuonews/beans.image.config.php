<?php

use herosphp\bean\Beans;
/**
 * 图片空间 Beans装配配置
 * @author yangjian102621@163.com
 * @since 1.0 - Nov 26, 2012
 */
$beans = array(
    /* 图片空间服务 */
    'image.image.service'=>array(
        '@type'=>Beans::BEAN_OBJECT,
        '@class' => 'image\service\ImageService',
        '@attributes' => array(
            '@bean/modelDao'=>array(
                '@type'=>Beans::BEAN_OBJECT,
                '@class'=>'image\dao\ImageDao',
                '@params' => array('image')
            )
        ),
    ),


);
return $beans;