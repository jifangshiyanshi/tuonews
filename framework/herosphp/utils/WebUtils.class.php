<?php

namespace herosphp\utils;

/*---------------------------------------------------------------------
 * HerosPHP 网络操作工具类
 * ---------------------------------------------------------------------
 * Copyright (c) 2013-now http://blog518.com All rights reserved.
 * ---------------------------------------------------------------------
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * ---------------------------------------------------------------------
 * Author: <yangjian102621@163.com>
 *-----------------------------------------------------------------------*/

class WebUtils {

    /**
     * 从网络地址中获取文件路径
     * @param string $url
     * @return string
     */
    public static function getFileFromUrl( $url ) {
        $urlInfo = parse_url($url);
        return str_replace('/', DIRECTORY_SEPARATOR, $urlInfo['path']);
    }

    /**
     * 获取客户端ip
     * @return string
     */
    public static function getClientIP() {

        if ( getenv('HTTP_CLIENT_IP') )
            $ip = getenv('HTTP_CLIENT_IP');

        //获取客户端用代理服务器访问时的真实ip 地址
        else if ( getenv('HTTP_X_FORWARDED_FOR') )
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        else if ( getenv('HTTP_X_FORWARDED') )
            $ip = getenv('HTTP_X_FORWARDED');
        else if ( getenv('HTTP_FORWARDED_FOR') )
            $ip = getenv('HTTP_FORWARDED_FOR');
        else if ( getenv('HTTP_FORWARDED') )
            $ip = getenv('HTTP_FORWARDED');
        else
            $ip = $_SERVER['REMOTE_ADDR'];

        return $ip;
    }
} 