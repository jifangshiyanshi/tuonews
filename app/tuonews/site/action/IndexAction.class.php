<?php
namespace site\action;

use herosphp\bean\Beans;
use herosphp\http\HttpRequest;
use herosphp\core\WebApplication;
use herosphp\core\Loader;
Loader::import('site.action.CommonAction', IMPORT_APP);
/**
 * Index Action
 * @author          yangjian<yangjian102621@163.com>
 */
class IndexAction extends CommonAction {

    /**
     * 首页
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {

        $page = $request->getParameter('page', 'intval');

        //获取轮播图
        $mediaService = Beans::get("media.media.service");
        $casoulItems = $mediaService->getMediaCarousel(5, $this->loginMedia['id']);
        $this->assign("casoulItems", $casoulItems);

        $condi = getMediaArticleConds();
        $condi['media_id'] = $this->loginMedia['id'];
        $this->loadMediaArticles($condi, $page, 'sort_num DESC, id DESC');

        //注册页面seo信息
        $this->assign('seoTitle', $this->mediaConfigs['sitetitle']);
        $this->assign('seoKwords', $this->mediaConfigs['siteseo']);
        $this->assign('seoDesc', $this->mediaConfigs['sitedescription']);

        $this->setView('index');
    }

    /**
     * w文章列表页
     * @param HttpRequest $request
     */
    public function nav( HttpRequest $request ) {

        $navid=$request->getParameter("navid","intval");

        $url = url("/site_article_index/?id={$navid}&media_id=".$this->loginMedia['id']);
        page301($url);

    }

    /**
     * 媒体文章详情
     * @param HttpRequest $request
     */
    public function detail( HttpRequest $request) {

        $id = $request->getParameter('id', 'intval');
        $url = url("/site_article_detail/?id={$id}&media_id=".$this->loginMedia['id']);
        page301($url);
    }

}
?>
