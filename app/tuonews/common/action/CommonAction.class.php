<?php
namespace common\action;

use herosphp\bean\Beans;
use herosphp\cache\CacheFactory;
use herosphp\core\Controller;
use herosphp\utils\ArrayUtils;

/* 定义文章信息常量，以来确定要获取的文章信息 */
//获取文章标签
define('ART_INFO_TAGS', 1 << 0);
//获取文章频道
define('ART_INFO_CHANEL', 1 << 1);
//获取文章来源
define('ART_INFO_SOURCE', 1 << 2);

//默认获取
define('ART_INFO_DEFAULT', ART_INFO_TAGS | ART_INFO_CHANEL | ART_INFO_SOURCE);

define('INVALID_ARGS', '参数错误！');

/**
 * 前端模块 模块通用 Action
 * @author          yangjian<yangjian102621@163.com>
 */
abstract class CommonAction extends Controller {

    /**
     * 当前登陆用户
     * @var array
     */
    protected $loginUser;

    /**
     * 初始化方法
     */
    public function C_start() {

        parent::C_start();

        //获取频道
        $chanelService = Beans::get('admin.chanel.service');
        $chanels = $chanelService->getChanelCache(7200);

        //获取媒体分类
        $mediaTypeService = Beans::get('media.type.service');
        $mediaTypes = $mediaTypeService->getItems(null, 'id,name,tkey', 'sort_num ASC');
        foreach ( $mediaTypes as $key => $value ) {
            $mediaTypes[$key]['url'] = url('/article_media_index/?tkey='.$value['tkey']);
        }

        //获取当前登录用户
        $userService = Beans::get('user.user.service');
        $this->loginUser = $userService->getLoginUser();
        $this->assign('loginUser', $this->loginUser);

        $this->assign('mediaTypes', $mediaTypes);
        $this->assign('__chanels', $chanels);
    }

    /**
     * 检查用户是否登录，如果没有登陆则转跳到登陆地址
     * @return mixed
     */
    public function loginCheck() {

        $userService = Beans::get('user.user.service');
        $this->loginUser = $userService->getLoginUser();
        if ( $this->loginUser ) {
            $this->assign('loginUser', $this->loginUser);
        } else {
            $this->location(url("/user_login_index"));
        }

    }

    /**
     * 显示错误提示信息
     * @param $type 消息类型 info warnning success danger
     * @param $message 消息内容
     * @param $url 显示消息后需要跳转的url,不写则不跳转。
     */
    public function showMessage( $type, $message, $url ) {

        $url = url("/common_message_show/type-{$type}-message-".base64_encode($message)."-url-".urlencode($url));
        $this->location($url);

    }

    /**
     * 获取文章相关信息
     * @param array $items
     * @param int $info 要获取的内容信息
     * @param array $cacheInfo 缓存信息
     * @return array|bool
     */
    protected function &loadArticleInfo($items=null, $info = ART_INFO_DEFAULT, $cacheInfo=null) {

        //如果有缓存信息，首先读取缓存,默认缓存5分钟
//        if ( $cacheInfo ) {
//            $CACHER = CacheFactory::create('file');
//            $CACHER->baseKey($cacheInfo['baseKey'])->ftype($cacheInfo['ftype'])->factor($cacheInfo['factor']);
//            if ( !$cacheInfo['expr'] ) {
//                $cacheInfo['expr'] = 300;
//            }
//            $__items = $CACHER->get(null, $cacheInfo['expr']);
//            if ( $__items ) {
//                return $__items;
//            }
//        }
//
//        if ( !$items ) {
//            return false;
//        }

        $chanelIds = array();
        $mediaIds = array();
        foreach ( $items as $value ) {
            $chanelIds[] = $value['chanel_id'];
            $mediaIds[] = $value['media_id'];
        }

        //获取频道
        if ( $info & ART_INFO_CHANEL ) {
            $chanelService = Beans::get('admin.chanel.service');
            $chanels = $chanelService->getItems($chanelIds, 'id,name');
            $chanels = ArrayUtils::changeArrayKey($chanels, 'id');
        }

        //获取来源
        if ( $info & ART_INFO_SOURCE ) {
            $mediaService = Beans::get('media.media.service');
            $medias = $mediaService->getItems($mediaIds, 'id,name');
            $medias = ArrayUtils::changeArrayKey($medias, 'id');
        }

        $tagService = Beans::get('article.tags.service');
        foreach ( $items as $key => $value ) {

            $items[$key]['url'] = url("/article_article_detail/?id=$value[id]");
            //初始化频道信息
            if ( $info & ART_INFO_CHANEL ) {
                $items[$key]['chanel_name'] = $chanels[$value['chanel_id']]['name'];
                $items[$key]['chanel_url'] = url("/article_article_index/?id=$value[chanel_id]");
            }
            //初始化媒体信息
            if ( $info & ART_INFO_SOURCE ) {
                if ( $value['media_id'] == 0 ) {
                    $items[$key]['media_name'] = '驼牛网';
                    $items[$key]['media_url'] = 'javascript:void(0);';
                } else {
                    $items[$key]['media_name'] = $medias[$value['media_id']]['name'];
                    $items[$key]['media_url'] = url('/article_media_detail/?id='.$value['media_id']);
                }
            }
            //初始化标签信息
            if ( $info & ART_INFO_TAGS ) {
                if ( trim($value['tags']) != '' ) {
                    $tags = $tagService->getItems("id in({$value['tags']})", 'id,name');
                    foreach ( $tags as $k => $v ) {
                        $tags[$k]['tag_url'] = url("/article_tags_detail/?id=".$v['id']);
                    }
                    $items[$key]['__tags'] = $tags;
                }
            }
        }
//        if ( $cacheInfo ) {
//            $CACHER->set(null, $items);
//        }
        return $items;
    }

}
?>
