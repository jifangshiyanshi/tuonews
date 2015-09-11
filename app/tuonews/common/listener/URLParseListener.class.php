<?php

namespace common\listener;

use herosphp\bean\Beans;
use herosphp\listener\IWebAplicationListener;
use herosphp\listener\WebApplicationListenerMatcher;

/**
 * URL解析监听器
 * Class URLParseListener
 * @package common\listener
 * @author yangjian102621@163.com
 */
 class URLParseListener extends WebApplicationListenerMatcher implements IWebAplicationListener {

     /**
      * 请求拦截
      */
    public function beforeRequestInit() {

        $host = $_SERVER['HTTP_HOST'];
        $host = str_replace('www.', '', $host);
        $domain = getConfig('domain');
        //移动端访问
        if ( strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') !== false ) {

            //绑定了独立域名，直接跳转到手机媒体站
            if ( $host != $domain ) {
                $mediaService = Beans::get('media.media.service');
                $conditions = array('domain' => $host);
                $item = $mediaService->getItem($conditions, 'id');
                if ( !$item ) {
                    page404();
                }


                //访问驼牛网手机媒体站
                $urlMap = array(
                    '/^\/$/iU' => '/mobile_site_index/?mediaId='.$item['id'],
                    '/^\/site_index_index\/media_id-(\d+)\.shtml$/iU' => '/mobile_index_media/?id=${1}',
                    '/^\/site_article_detail\/id-(\d+)-media_id-(\d+)\.shtml$/iU' => '/mobile_index_detail/?id=${1}',
                );
                $url = preg_replace(array_keys($urlMap), $urlMap, $_SERVER['REQUEST_URI']);
                $_SERVER['REQUEST_URI'] = url($url);

                //除了媒体站的页面，不能通过媒体站的独立域名访问驼牛的其他页面
                if ( strpos($_SERVER['REQUEST_URI'], '/mobile_') === false
                    && $_SERVER['REQUEST_URI'] != '/' ) {
                    page404();
                }

            } else {
                //访问驼牛网手机主站
                if ( strpos($_SERVER['REQUEST_URI'], '/mobile_') === false ) {
                    header("Location:http://{$domain}/mobile_index_index");
                    die();
                }
            }


        } else {    //pc端访问

            //绑定了独立域名，直接跳转到PC官网
            if ( $host != $domain ) {
                $mediaService = Beans::get('media.media.service');
                $conditions = array('domain' => $host);
                $item = $mediaService->getItem($conditions, 'id');
                if ( !$item ) {
                    page404();
                }

                //除了媒体站的页面，不能通过媒体站的独立域名访问驼牛的其他页面
                if ( strpos($_SERVER['REQUEST_URI'], '/site_') === false
                    && $_SERVER['REQUEST_URI'] != '/' ) {
                    page404();
                }

                //访问驼牛网PC媒体站首页
                if ( $_SERVER['REQUEST_URI'] == '/' ) {
                    $_SERVER['REQUEST_URI'] = '/site_index_index/?media_id='.$item['id'];
                }

            }

        }
        //代码执行到这里，则默认访问驼牛的PC主站

    }
}

?>
