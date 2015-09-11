<?php
/*---------------------------------------------------------------------
 * 数据库连接配置文件
 * ---------------------------------------------------------------------
 * Copyright (c) 2013-now http://blog518.com All rights reserved.
 * ---------------------------------------------------------------------
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * ---------------------------------------------------------------------
 * Author: <yangjian102621@163.com>
 *-----------------------------------------------------------------------*/

return array(
    //mysql数据库配置
    DB_TYPE_MYSQL     =>  array(
        array(
            'db_type'      => 'mysql',
           'db_host'      => 'localhost',
           'db_user'      => 'publisher',
           'db_pass'      => 'mdPUBsdhds8sapw234',
            'db_name'      => 'active.tuonews.com',
            'db_port'      => 3306,
            'db_charset'   => 'utf8',
            'serial'       => 'db-write',      //写服务器,如果没有配置读写分离，则此处不用理它
        ),
    ),
);
