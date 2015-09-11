<?php
/*---------------------------------------------------------------------
 * 框架的公共配置信息
 * ---------------------------------------------------------------------
 * Copyright (c) 2013-now http://blog518.com All rights reserved.
 * ---------------------------------------------------------------------
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * ---------------------------------------------------------------------
 * Author: <yangjian102621@163.com>
 *-----------------------------------------------------------------------*/
$config = array(

    'template' => 'default',    //默认模板
    'skin' => 'default',    //默认皮肤
    /**
     * 模板编译缓存配置
     * 0 : 不启用缓存，每次请求都重新编译(建议开发阶段启用)
     * 1 : 开启部分缓存， 如果模板文件有修改的话则放弃缓存，重新编译(建议测试阶段启用)
     * -1 : 不管模板有没有修改都不重新编译，节省模板修改时间判断，性能较高(建议正式部署阶段开启)
     */
    'temp_cache' => 0,

    //文件上传目录
    'upload_dir' => RES_PATH.'upload/',
    /**
     * 用户自定义模板标签编译规则
     * array( 'search_pattern' => 'replace_pattern'  );
     */
    'temp_rules' => array(),

    //PVC123短信平台参数配置
    'pvc123_message_config' => array(
        'user' => '13922508685',
        'password' => 'CE16E3A42A7EDD86F3EB1FA5FE5D',
        //短信发送网关
        'gateway' => 'http://web.cr6868.com/asmx/smsservice.aspx',
        //短信签名
        'sign' => '驼牛网(www.tuonews.com)',
        //通道分组
        'group' => ''
    ),

    //维信互动短信平台参数配置
    'weixin_message_config' => array(
        'user' => 'cf_tuonews',
        'password' => md5('tuonews123'),
        //短信发送网关
        'gateway' => 'http://106.ihuyi.cn/webservice/sms.php',

    )
);

return $config;
