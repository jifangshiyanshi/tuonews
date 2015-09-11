<?php
/*---------------------------------------------------------------------
 * 应用程序入口文件
 * ---------------------------------------------------------------------
 * Copyright (c) 2013-now http://blog518.com All rights reserved.
 * ---------------------------------------------------------------------
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * ---------------------------------------------------------------------
 * Author: <yangjian102621@163.com>
 * @version 1.2.1
 *-----------------------------------------------------------------------*/

//设置页面编码
header("Content-Type:text/html; charset=utf-8");

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG', true);

// 定义当前访问的应用
define('APP_NAME', 'tuonews');

// 定义系统根目录
define('APP_ROOT', __DIR__.'/');

//定义应用根目录
define('APP_PATH', APP_ROOT."app/");

//定义框架根目录
define('APP_FRAME_PATH', APP_ROOT.'framework/herosphp/');

//定义Beans配置目录，如果为false则默认使用configs/beans,注意目录分割符号用.而不是用/
define('BEANS_PATH', 'beans.tuonews');

//定义数据模型配置目录，如果为false则默认使用configs/models,注意目录分割符号用.而不是用/
define('MODELS_PATH', 'configs.models.tuonews');

//定义数据库配置目录，如果为false则默认使用configs/db,注意目录分割符号用.而不是用/
define('DB_CFG_PATH', 'db.tuonews');

//引入系统常量文件
require APP_FRAME_PATH.'Heros.const.php';

//包含系统框架的统一入口文件
require APP_FRAME_PATH.'Herosphp.class.php';

//包含公共函数页面
require APP_ROOT.'functions.php';

//启动应用程序
Herosphp::run();
