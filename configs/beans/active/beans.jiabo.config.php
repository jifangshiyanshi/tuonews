<?php

use herosphp\bean\Beans;
/**
 * 加博会模块 Beans装配配置
 */
$beans = array(
    /* 加博会服务 */
    'jiabo.form.service'=>array(
        '@type'=>Beans::BEAN_OBJECT,
        '@class' => 'jiabo\service\JiaboService',
        '@attributes' => array(
            '@bean/modelDao'=>array(
                '@type'=>Beans::BEAN_OBJECT,
                '@class'=>'jiabo\dao\JiaboDao',
                '@params'=>'jiabo'
            )
        ),
    ),

);
return $beans;
