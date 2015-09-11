<?php
/*---------------------------------------------------------------------
 * 应用的公共的常用的全局函数
 * ---------------------------------------------------------------------
 * Copyright (c) 2013-now http://blog518.com All rights reserved.
 * ---------------------------------------------------------------------
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * ---------------------------------------------------------------------
 * Author: <yangjian102621@163.com>
 *-----------------------------------------------------------------------*/

/**
 * 获取指定尺寸的缩略图
 * @param string $src 原图地址
 * @param string $size 尺寸如: 120x120
 * @return string
 */
function getImageThumb( $src, $size) {

    //如果是绝对地址，则直接返回
    if ( strpos($src, 'http://') === 0 ) {
        return $src;
    }
    $src = ltrim($src, '/');
    $position = strrpos($src, '.');
    $ext = substr($src, $position);
    return '/'.$src.".".$size.$ext;

}

/**
 * 获取指定尺寸的裁剪图
 * @param string $src 原图地址
 * @param string $size 尺寸如: 120x120
 * @return string
 */
function getImageCrop( $src, $size) {

    //如果是绝对地址，则直接返回
    if ( strpos($src, 'http://') === 0 ) {
        return $src;
    }
    $src = ltrim($src, '/');
    $position = strrpos($src, '.');
    $ext = substr($src, $position);
    return '/'.$src.".__crop__.".$size.$ext;

}

/**
 * 获取邮件授权码,默认30分钟
 * @param string $email 邮箱地址
 * @param int $expr 授权码的有效期，默认长期有效
 * @return mixed
 */
function getEmailCode($email, $expr=0) {

    $factor = getHashCode($email);
    $CACHER = \herosphp\cache\CacheFactory::create('file');
    $CACHER->baseKey('authcode')->ftype('email')->factor($factor);
    return $CACHER->get(null, $expr);

}

/**
 * 获取手机授权码, 默认30分钟有效
 * @param string $mobile
 * @param int $expr 授权码的有效期, 默认为30分钟
 * @return mixed
 */
function getMobileCode($mobile, $expr=1800) {

    //缓存校验码
    $factor = $mobile;
    if ( !is_numeric($mobile) ) {
        $factor = getHashCode($mobile);
    }
    $CACHER = \herosphp\cache\CacheFactory::create('file');
    $CACHER->baseKey('authcode')->ftype('mobile')->factor($factor);
    return $CACHER->get(null, $expr);

}

/**
 * 获取文章显示的基本条件
 * @return string
 */
function getArticleBasicConditions() {

    $conditions['trash'] = 0;
    $conditions['ischeck'] = 1;
    return $conditions;
}

/**
 * 获取媒体文章显示的基本条件
 * @return string
 */
function getMediaArticleConds() {
    return array('trash' => 0);
}

//跳转到404页面
function page404() {
    header("HTTP/1.0 404 Not Found!");
    die();
}

//转跳301页面
function page301( $url ) {
    header( "HTTP/1.1 301 Moved Permanently" );
    header( "Location: {$url}" );
    die();
}
