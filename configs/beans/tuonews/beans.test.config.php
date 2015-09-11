<?php

use herosphp\bean\Beans;
/**
 * 测试模块 Beans装配配置
 * @author yangjian102621@163.com
 * @since 1.0 - Nov 26, 2012
 */
$beans = array(
    
    /* 测试服务 */
    'test.test.service'=>array(
        '@type'=>Beans::BEAN_OBJECT,
        '@class' => 'test\service\TestService',
        '@attributes' => array(
            '@bean/modelDao'=>array(
                '@type'=>Beans::BEAN_OBJECT,
                '@class'=>'test\dao\TestDao',
                '@params' => 'test'
            )
        ),
    ),

);
return $beans;