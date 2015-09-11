<?php
namespace article\action;

use herosphp\bean\Beans;
use herosphp\cache\CacheFactory;
use herosphp\core\Loader;
use herosphp\http\HttpRequest;
use herosphp\utils\AjaxResult;
use herosphp\utils\ArrayUtils;

Loader::import('article.action.ArticleCommonAction', IMPORT_APP);

/**
 * 媒体 Action
 * @author          yangjian<yangjian102621@163.com>
 */
class MediaAction extends ArticleCommonAction {

    /**
     * 媒体列表
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {

        $tkey = $request->getParameter('tkey', 'trim');
        $page = $request->getParameter('page', 'intval');

        //默认显示群媒体
        if ( $tkey == '' ) {
            $tkey = 'qunmei';
        }
        //如果是自媒体和企业则不显示logo
        $showLogo = false;
        if ( $tkey == 'qunmei' || $tkey == '' ) {
            $showLogo = true;
        }

        //读取媒体缓存信息,默认缓存1小时
//        $CACHER = CacheFactory::create('file', false);
//        $CACHER->baseKey('media')->ftype('list')->factor($tkey.'-'.$page);
//        $__medias = $CACHER->get(null, 7200);
         $__medias = false;
        //初始化服务
        $mediaTypeService = Beans::get('media.type.service');
        $mediaService = Beans::get('media.media.service');
        $articleService = Beans::get('article.article.service');
        $userService = Beans::get('user.user.service');

        $this->setPage($page);
        //组合条件
        $condi = array('ischeck' => 1);
        //获取媒体类型ID
        if ( $tkey != '' ) {
            $mediaType = $mediaTypeService->getItem("tkey='{$tkey}'" , 'id,name,summary');
            $condi['media_type'] = $mediaType['id'];
        }

        if ( !$__medias ) {

            //获取推荐位
            $recommendMedias = null;
            $fields = 'id,name,logo,intro';
            switch ( $tkey ){
                case 'gemei':
                    $recommendMedias = $mediaService->getRecommendMedia(4, 'gemei', $fields);
                    break;
                case 'qiye':
                    $recommendMedias = $mediaService->getRecommendMedia(4, 'qiye', $fields);
                    break;
                default:
                    $recommendMedias = $mediaService->getRecommendMedia(4, 'qunmei', $fields);
                    break;
            }

            //查找媒体信息
            $medias = $mediaService->getItems($condi, $fields, 'add_time DESC', $this->getPage(), $this->getPagesize());

            //收集媒体IDS
            $mediaIds = array();
            foreach ( $medias as $value ) {
                $mediaIds[] = $value['id'];
            }
            foreach ( $recommendMedias as $value ) {
                $mediaIds[] = $value['id'];
            }
            $mediaIds = implode(",", $mediaIds);
            if( $mediaIds ) {
                //查询媒体收录数
                $sumCondi = array('ischeck' => 1, 'media_id' => '#IN'.$mediaIds);
                $sums = $articleService->getItems($sumCondi, 'count(*) as total, media_id', null, null, null, 'media_id');
                $sums = ArrayUtils::changeArrayKey($sums, 'media_id');

                //判断媒体是否被订阅
                $loginUser = $userService->getLoginUser();
                if( $loginUser ) {
                    $orderCondi = array('media_id' => "#IN".$mediaIds, 'userid' => $loginUser['id']);
                    $orderService = Beans::get('media.order.service');
                    $orders = $orderService->getItems($orderCondi, 'id,media_id');
                    $orders = ArrayUtils::changeArrayKey($orders, 'media_id');
                }

                //初始化媒体信息
                foreach ( $medias as $key => $value ) {
                    if ( isset($orders[$value['id']]) ) {
                        $medias[$key]['order'] = 1;
                    } else {
                        $medias[$key]['order'] = 0;
                    }
                    if ( isset($sums[$value['id']]) ) {
                        $medias[$key]['total'] = $sums[$value['id']]['total'];
                    } else {
                        $medias[$key]['total'] = 0;
                    }
                    $medias[$key]['url'] = url('/article_media_detail/?id='.$value['id']);
                }

                //初始化推荐媒体信息
                foreach ( $recommendMedias as $key => $value ) {
                    if ( isset($orders[$value['id']]) ) {
                        $recommendMedias[$key]['order'] = 1;
                    } else {
                        $recommendMedias[$key]['order'] = 0;
                    }
                }
            }

            $__medias['items'] = $medias;
            $__medias['recommends'] = $recommendMedias;
            //添加缓存
            //$CACHER->set(null, $__medias);
        }

        //获取分页
        $count = $mediaService->count($condi);
        $this->getPageData($count);

        $this->assign('showLogo', $showLogo);
        $this->assign('medias', $__medias);

        //注册页面seo信息
        $this->assign('seoTitle', $mediaType['name'].'牛媒体- 驼牛网');
        $this->assign('seoKwords', $mediaType['summary'].'驼牛网, 牛媒体');
        $this->assign('seoDesc', $mediaType['summary'].'驼牛网牛媒体');

        $this->setView('media_index');
    }

    /**
     * 媒体所包含的文章列表
     * @param HttpRequest $request
     */
    public function detail(HttpRequest $request) {

        $id = $request->getParameter('id', 'intval');
        $page = $request->getParameter('page', 'intval');
        if ( $id <= 0 ) page404();

        $this->setPage($page);
        //获取文章
        $userService = Beans::get('user.user.service');
        $articleService = Beans::get('article.article.service');
        $mediaService = Beans::get('media.media.service');
        $tagService = Beans::get('article.tags.service');

        $baseCondi = getArticleBasicConditions();
        $condi['media_id'] = $id;
        $condi = array_merge($condi, $baseCondi);
        $items = $articleService->getItems($condi, 'id,title,thumb,add_time,chanel_id, tags,media_id,bcontent',
            'add_time DESC', $this->getPage(), $this->getPagesize());

        $cacheInfo = array(
            'baseKey' => 'article',
            'ftype' => 'mediadetail',
            'factor' => $id.'-'.$page,
            'expr' => 300
        );
        $aricles = &$this->loadArticleInfo($items, ART_INFO_DEFAULT, $cacheInfo);
        $this->assign('items', $aricles);

        //获取分页
        $count = $articleService->count($condi);
        $this->getPageData($count);

        //获取媒体信息
        $mediaInfo = $mediaService->getItem($id, 'id,name,intro,logo');
        $this->assign('mediaInfo', $mediaInfo);

        //获取媒体信息
        $imageClass = 'logo';
        $mediaInfo = $mediaService->getItem($id, "id, name, media_type, nickname, domain, logo, intro");
        $mediaInfo['domain'] = trim($mediaInfo['domain']);
        if ( $mediaInfo['domain'] != '' ) {
            $mediaInfo['domain'] = 'http://www.'.$mediaInfo['domain'];
        } else {
            $mediaInfo['domain'] = url('/site_index_index/?media_id='.$id);
        }
        $mediaInfo['configs'] = cn_json_decode($mediaInfo['configs']);
        $this->assign('mediaInfo', $mediaInfo);

        //判断媒体类型
        $mediaTypeService = Beans::get('media.type.service');
        $type = $mediaTypeService->getItem($mediaInfo['media_type'], 'tkey');
        if($type['tkey'] != 'qunmei') {
            $imageClass = 'aside_publish_user';
        }

        $this->assign('imageClass', $imageClass);

        //判断用户是否订阅此媒体
        $loginUser = $userService->getLoginUser();
        $mediaOrdered = 0;
        if ( $loginUser ) {
            $mediaOrderService = Beans::get('media.order.service');
            $orderCondi = array(
                'userid' => $loginUser['id'],
                'media_id' => $id
            );
            if( $mediaOrderService->getItem($orderCondi) ) {
                $mediaOrdered = 1;
            }
        }
        $this->assign('mediaOrdered', $mediaOrdered);

        //获取热点排行文章
        $hotRanks = $articleService->getHotRank(10, 'id,title');
        $this->assign('hotRanks', $hotRanks);

        //获取周排行
        $weekRanks = $articleService->getWeekRank(10, 'id,title');
        $this->assign('weekRanks', $weekRanks);

        //获取编辑推荐的文章
        $editorRec = $articleService->getEditorRecommend(10);
        $this->assign('editorRec', $editorRec);

        //获取推荐媒体信息
        $niulanMedia = $mediaService->getRecommendMedia(4, 'niulan');
        $this->assign('niulanMedia', $niulanMedia);

        //获取热门标签
        $hotTags = $tagService->getHotTags(12);
        $this->assign('hotTags', $hotTags);

        //注册页面seo信息
        $this->assign('seoTitle', $mediaInfo['configs']['sitetitle'].' - 驼牛网牛媒体');
        $this->assign('seoKwords', $mediaInfo['configs']['siteseo'].'驼牛网,牛媒体');
        $this->assign('seoDesc', $mediaInfo['configs']['sitedescription']);

        $this->setView('media_detail');
    }

    /**
     * 订阅媒体
     * @param HttpRequest $request
     */
    public function order(HttpRequest $request) {

        $id = $request->getParameter('id', 'intval');
        $orderService = Beans::get('media.order.service');
        $userService = Beans::get('user.user.service');
        $loginUser = $userService->getLoginUser();
        if( $loginUser ) {

            //如果已经添加了就直接返回
            $condi = array('userid' => $loginUser['id'], 'media_id' => $id);
            if ( $orderService->count($condi) > 0 ) {
                AjaxResult::ajaxResult(1, 'on');
            }
            $data = array(
                'userid' => $loginUser['id'],
                'media_id' => $id,
                'add_time' => time()
            );

            if ( $orderService->add($data) ) {
                AjaxResult::ajaxResult(1, 'on');
            } else {
                AjaxResult::ajaxResult(0, 'error');
            }
        } else {
            AjaxResult::ajaxResult(0, 'login');
        }
    }

    /**
     * 取消订阅媒体
     * @param HttpRequest $request
     */
    public function unorder(HttpRequest $request) {

        $id = $request->getParameter('id', 'intval');
        $orderService = Beans::get('media.order.service');
        $userService = Beans::get('user.user.service');
        $loginUser = $userService->getLoginUser();
        if( $loginUser ) {

            $condi = array('userid' => $loginUser['id'], 'media_id' => $id);
            if ( $orderService->deletes($condi) ) {
                AjaxResult::ajaxResult(1, 'off');
            } else {
                AjaxResult::ajaxResult(0, 'error');
            }

        } else {
            AjaxResult::ajaxResult(0, 'login');
        }

    }

}
?>
