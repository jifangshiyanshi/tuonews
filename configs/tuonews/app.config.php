<?php
/*---------------------------------------------------------------------
 * 当前访问application配置信息.
 * 注意：此处的配置将会覆盖同名键值的系统配置
 * ---------------------------------------------------------------------
 * Copyright (c) 2013-now http://blog518.com All rights reserved.
 * ---------------------------------------------------------------------
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * ---------------------------------------------------------------------
 * Author: <yangjian102621@163.com>
 *-----------------------------------------------------------------------*/

$config = array(
    //默认访问的页面
    'default_url' => array(
        'module' => 'common',
        'action' => 'index',
        'method' => 'index'),

    'template' => 'default', //默认模板
    'skin' => 'default', //默认皮肤
    'temp_cache' => 0, //模板引擎缓存

    //网站名称
    'site_name' => "驼牛信息文化转播公司",
    //网站标题
    'site_title' => "驼牛网-产业文化与媒体影响力传播交流平台",
    //网站关键字
    'site_keywords' => "飞碟科技,驼牛网, 东莞盟大集团",
    //网站描述
    'site_desc' => "驼牛网，中国第一个专注于产业金融科技文化创新的媒体平台！",

    //后台管理中心 title
    'admin_title' => "驼牛网后台管理中心",
    //后台登录页title
    'admin_login_title' => "登录驼牛后台管理中心",
    //版权信息
    'copy_right' => "Copyright ©2015  tuonews.com 驼牛网 ,All Rights Reserved",
    'ipc_beian' => "粤ICP备14051865号",

    //短链接映射
    'url_mapping_rules' => array(
        //目标链接到源链接
        'target_to_source' => array(
            //新闻详情
            '^\/newsdetail-(\d+)\/?$' => '/article_article_detail/?id=${1}',
            //新闻列表
            '^\/newslist-(\d+)\/?$' => '/article_article_index/?id=${1}',
            //新闻列表页分页
            '^\/newslist-(\d+)-(\d+)\/?$' => '/article_article_index/?id=${1}&page=${2}',
            //关于我们
            '^\/service\/id-(\d+)\.shtml$' => '/article_artone_service/?id=${1}',
            //所有媒体列表
            '^\/medias\/?$' => '/article_media_index',
            //所有媒体列表分页
            '^\/medias-(\d+)\/?$' => '/article_media_index/?page=${1}',
            //媒体分类列表
            '^\/medias\/([a-z|A-Z|0-9|_]+)\/?$' => '/article_media_index/?tkey=${1}',
            //媒体分类列表分页
            '^\/medias\/([a-z|A-Z|0-9|_]+)-(\d+)\/?$' => '/article_media_index/?tkey=${1}&page=${2}',
            //标签详情
            '^\/tags-(\d+)\/?$' => '/article_tags_detail/?id=${1}',

        ),

        //源链接到目标链接
        'source_to_target' => array(
            //新闻详情
            '^\/article_article_detail\/\?id=(\d+)$' => '/newsdetail-${1}/',
            //新闻列表
            '^\/article_article_index\/\?id=(\d+)$' => '/newslist-${1}/',
            //新闻列表页分页
            '^\/article_article_index\/\?id=(\d+)&page=(\d+)$' => '/newslist-${1}-${2}/',
            //关于我们
            '^\/article_artone_service\/\?id=(\d+)$' => '/service/id-${1}.shtml',
            //有所媒体列表
            '^\/article_media_index\/?$' => '/medias/',
            //有所媒体列表分页
            '^\/article_media_index\/\?page=(\d+)$' => '/medias-${1}/',
            //媒体分类列表
            '^\/article_media_index\/\?tkey=([a-z|A-Z|0-9|_]+)$' => '/medias/${1}/',
            //媒体分类列表分页
            '^\/article_media_index\/\?tkey=([a-z|A-Z|0-9|_]+)&page=(\d+)$' => '/medias/${1}-${2}/',
            //标签详情
            '^\/article_tags_detail\/\?id=(\d+)$' => '/tags-${1}/',
        ),
    ),

    //默认logo图片
    'default_logo' => '/res/global/images/default_face.jpg.106x106.jpg',
    'image_block' => '/res/global/images/reception/block.gif',
    //驼牛网站点logo
    'site_logo' => '/res/global/images/reception/logo143x74.jpg',

    //系统配置分组
    'system.config.group' => array(
        'basic' => '基础配置',
        'email' => '邮件配置',
    ),

    //消息模板分类
    'message.template.type' => array(
        'email' => '邮件模板',
        'message' => '短信模板',
        'site' => '站内信模板',
    ),

    //消息模板标签
    'message.template.tags' => array(
        '{username}' => '网址',
        '{username}' => '用户名',
        '{userid}' => '用户ID',
        '{mobile}' => '手机号码',
        '{email}' => '邮箱',
        '{nickname}' => '昵称',
        '{media_name}' => '媒体名称',
        '{media_id}' => '媒体ID',
        '{authcode}' => '授权码|验证码，一般为6位随机数字',
    ),

    //文章排序方式
    'article.orderway' => array(
        'hits' => '点击率升序',
        '_hits' => '点击率降序',
        'comment' => '评论数升序',
        '_comment' => '评论数降序',
        'share' => '分享次数升序',
        '_share' => '分享次数降序',
        'collect' => '收藏次数升序',
        '_collect' => '收藏次数降序',
        'zan' => '点赞次数升序',
        '_zan' => '点赞次数降序',
    ),

    //文章统计时间
    'article.statistics.time' => array(
        'today' => '今天',
        'yesterday' => '昨天',
        'week' => '最近七天',
        'month' => '最近30天',
    ),

    //系统保留关键字类型
    'system.keywords.type' => array(
        '0' => '二级域名',
        '1' => '用户名'
    ),

);

return $config;
