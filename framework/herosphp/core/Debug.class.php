<?php
/*---------------------------------------------------------------------
 * 运行时调试类，如果用户开启的了调试模式，此类用以输出调试信息和错误报告
 * ---------------------------------------------------------------------
 * Copyright (c) 2013-now http://blog518.com All rights reserved.
 * ---------------------------------------------------------------------
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * ---------------------------------------------------------------------
 * Author: <yangjian102621@163.com>
 *-----------------------------------------------------------------------*/

namespace herosphp\core;

class Debug {

	/* 程序开始运行时间 */
	private static $startTime;

	/* 运行错误信息 */
	private static $error_msg = array();
	/* SQL 语句信息 */
	private static $sql_msg = array();

	/* 错误类型 */
	private static $messType = array(
		 E_WARNING 		=>'运行时警告',
		 E_NOTICE  		=>'运行时提醒',
	 	 E_STRICT  		=>'编码标准化警告',
	 	 E_USER_ERROR	=>'自定义错误',
	 	 E_USER_WARNING	=>'自定义警告',
	  	 E_USER_NOTICE	=>'自定义提醒',
	 	 'Unkown '		=>'未知错误'
	);
	
	/**
	 * 获取程序开始运行时间
	 */
	public static function start(){                       
		self::$startTime = microtime(true); 
	}

	/**
	 * 计算程序运行时间
	 */
	public static function getRunTime(){
		return round((microtime(true) - self::$startTime) , 4); 
	}

	/**
 	 * error handler function 自定义错误处理函数
	 */
	public static function customError($errno, $errstr, $errfile, $errline) {
		 
		if ( !isset(self::$messType[$errno]) ) $errno = "Unkown";
		
		$_error_reporting = error_reporting();		//读取错误提示级别
		if ( !($_error_reporting & $errno) ) return;	//屏蔽不需要的错误输出
		
		$err_str ='<div style="color:#cc0000;">';
	   	$err_str .='<b>'.self::$messType[$errno]."：</b><span style='color:#00F;'>[在文件 {$errfile} 中,第 {$errline} 行]:";
	   	$err_str.= $errstr;
	   	$err_str.='</span></div>'; 		
	  	self::appendMessage($err_str, 'run');
	 }

    /**
     * 添加调试错误信息
     * @param string $message 错误信息
     * @param string $msgType 信息类别
     */
    public static function appendMessage( $message, $msgType='run' ) {
	 	if ( APP_DEBUG ) {
	 		switch ( $msgType ) {
				case 'run' :
					array_push(self::$error_msg, $message );
					break;
				case 'sql' :
					array_push(self::$sql_msg, $message);
					break;
			}
	 	}
	 }

	 /* 打印错误信息 */
	 public static function printMessage() {
		echo '<div style="width:90%; text-align:left; border:2px solid #999999; background-color:#FFFFFF; margin:10px auto; padding:10px; line-height:150%;">';
		echo '<p style="color:#397923;font-size:12px; font-weight:bold;">脚本运行时间：<em style="color:#CC0000;">'.self::getRunTime().'</em> 秒</p>';
		if ( !empty(self::$error_msg) ) {
			echo '<h4>[运行调试信息]</h4>';
			foreach ( self::$error_msg as $_val ) echo "<p>{$_val}</p>";
		}
		if ( !empty(self::$sql_msg) ) {
			echo '<h4>[SQL信息]</h4>';
			foreach ( self::$sql_msg as $_val ) echo "<p>{$_val}</p>";
		}
		echo '</div>';
	 }
}
?>