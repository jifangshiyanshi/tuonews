<?php
/**
 * session configures for all session handlers.
 * @author yangjian<yangjian102621@163.com>
 */

return array(
	//file session configure
	'file' => array(
        //session文件前缀
		'session_file_prefix' => 'heros_session_',
        //为减少服务器的负担，每30秒钟更新一次session或者session有改变时
		'session_update_interval' => 30,
        //session 有效期, 默认为24分钟
		'gc_maxlifetime' => 3600,
	),
	
	//memcache session configure
	'memo' => array(
        //memcache服务器ip
		'host'	=> '127.0.0.1',
        //memcache服务器端口
		'port'  => '11211',
        //session 有效期, 默认为24分钟
        'gc_maxlifetime' => 3600,				/* session gc lifetime */
	)
);