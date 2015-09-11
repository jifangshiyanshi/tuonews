<?php

use herosphp\bean\Beans;
/**
 * 公共模块服务 Beans装配配置
 * @author yangjian102621@163.com
 * @since 1.0 - Nov 26, 2012
 */
$beans = array(
    /* 邮件服务 */
    'common.email.service'=>array(
        '@type'=>Beans::BEAN_OBJECT,
        '@class' => 'common\service\EmailService',
    ),

    /* 短信服务 */
    'common.mobileMessage.service'=>array(
        '@type'=>Beans::BEAN_OBJECT,
        '@class' => 'common\service\WeixinSmsService',
    ),

    /* 应用程序监听器配置 */
    Beans::BEAN_WEBAPP_LISTENER => array (
        '@type' => Beans::BEAN_OBJECT_ARRAY,
        '@attributes' => array (
            array (
                '@type' => Beans::BEAN_OBJECT,
                '@class' => 'common\listener\URLParseListener'
            )
        )
    ),

    /*金融服务广告表单*/
    'common.finance.service'=>array(
        '@type'=>Beans::BEAN_OBJECT,
        '@class' => 'common\service\financeService',
        '@attributes' => array(
            '@bean/modelDao'=>array(
                '@type'=>Beans::BEAN_OBJECT,
                '@class'=>'common\dao\financeDao',
                '@params'=>'finance'
            )
        ),
    ),


);
return $beans;
