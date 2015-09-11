<?php
namespace article\action;

use herosphp\bean\Beans;
use herosphp\core\Loader;
use herosphp\http\HttpRequest;
use herosphp\utils\AjaxResult;

Loader::import('article.action.ArticleCommonAction', IMPORT_APP);

/**
 * 标签 Action
 * @author          yangjian<yangjian102621@163.com>
 */
class TagsAction extends ArticleCommonAction {

    /**
     * 标签列表
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {

    }

    /**
     * 标签详情页
     * @param HttpRequest $request
     */
    public function detail(HttpRequest $request) {

        $id = $request->getParameter('id','intval');
        $page = $request->getParameter('page', 'intval');
        if ( $id <= 0 ) page404();

        $this->setPage($page);
        $condi = array('tagid' => $id);
        $articleViewService = Beans::get('article.view.service');
        $tagsService = Beans::get('article.tags.service');
        $userService = Beans::get('user.user.service');

        $items = $articleViewService->getItems($condi, 'id,title,thumb,add_time,chanel_id, tags,media_id,bcontent',
            'add_time DESC', $this->getPage(), $this->getPagesize());

        $cacheInfo = array(
            'baseKey' => 'tags',
            'ftype' => 'article',
            'factor' => $id.'-'.$this->getPage(),
            'expr' => 300
        );
        $aricles = &$this->loadArticleInfo($items, ART_INFO_DEFAULT, $cacheInfo);
        $this->assign('items', $aricles);

        //获取分页
        $count = $articleViewService->count($condi);
        $this->getPageData($count);

        //获取标签
        $tag = $tagsService->getItem($id);
        $tagsService->increase('hits',  1, $id);

        //获取热门标签
        $hotTags = $tagsService->getHotTags(12);
        $this->assign('hotTags', $hotTags);

        //判断用户是否订阅此标签
        $loginUser = $userService->getLoginUser();
        $ordered = 0;
        if ( $loginUser ) {
            $tagsOrderService = Beans::get('article.tags.order');
            $orderCondi = array(
                'userid' => $loginUser['id'],
                'tagid' => $id
            );
            if( $tagsOrderService->getItem($orderCondi) ) {
                $ordered = 1;
            }
        }
        $this->assign('ordered', $ordered);
        $this->assign('tag',$tag);

        //注册页面seo信息
        $this->assign('seoTitle', '驼牛词条-'.$tag['name']);
        $this->assign('seoKwords', $tag['name'].'驼牛网,牛媒体');
        $this->assign('seoDesc', $tag['intro']==''?$tag['name']:$tag['intro']);

        $this->setView('tag_detail');
    }

    /**
     * 订阅标签
     * @param HttpRequest $request
     */
    public function order(HttpRequest $request) {

        $id = $request->getParameter('id', 'intval');
        $orderService = Beans::get('article.tags.order');
        $userService = Beans::get('user.user.service');
        $loginUser = $userService->getLoginUser();
        if( $loginUser ) {

            //如果已经添加了就直接返回
            $condi = array('userid' => $loginUser['id'], 'tagid' => $id);
            if ( $orderService->count($condi) > 0 ) {
                AjaxResult::ajaxResult(1, 'on');
            }
            $data = array(
                'userid' => $loginUser['id'],
                'tagid' => $id,
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
     * 取消订阅标签
     * @param HttpRequest $request
     */
    public function unorder(HttpRequest $request) {

        $id = $request->getParameter('id', 'intval');
        $orderService = Beans::get('article.tags.order');
        $userService = Beans::get('user.user.service');
        $loginUser = $userService->getLoginUser();
        if( $loginUser ) {

            $condi = array('userid' => $loginUser['id'], 'tagid' => $id);
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
