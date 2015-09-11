<?php
namespace site\action;

use herosphp\bean\Beans;
use herosphp\http\HttpRequest;
use herosphp\core\WebApplication;
use herosphp\core\Loader;
Loader::import('site.action.CommonAction', IMPORT_APP);
/**
 * 媒体站文章 Action
 * @author          yangjian<yangjian102621@163.com>
 */
class ArticleAction extends CommonAction {

    /**
     * 文章列表页面
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {

        $id = $request->getParameter('id', 'intval');
        $page = $request->getParameter('page', 'intval');

        $condi = getMediaArticleConds();
        $condi['media_chanel'] = $id;
        $this->loadMediaArticles($condi, $page);

        //注册页面seo信息
        $this->assign('seoTitle', $this->mediaConfigs['sitetitle']);
        $this->assign('seoKwords', $this->mediaConfigs['siteseo']);
        $this->assign('seoDesc', $this->mediaConfigs['sitedescription']);

        $this->assign("chanelId",$id);
        $this->setView("article_list");
    }

    /**
     * 媒体文章详情
     * @param HttpRequest $request
     */
    public function detail( HttpRequest $request) {

        $id = $request->getParameter('id','intval');
        if( $id <= 0 ) page404();

        $articleService=Beans::get("article.article.service");
        $tagService = Beans::get('article.tags.service');
        $condi = getMediaArticleConds();
        $conditions = array(
            'id' => $id,
            'media_id' => $this->loginMedia['id']
        );
        $condi = array_merge($conditions, $condi);
        $item = $articleService->getItem($condi, 'id,title,media_chanel,bcontent,tags,kwords,author, add_time, update_time');

        if ( !$item ) page404();
        //更新文章点击率
        $articleService->increase('hits', 1, $id);

        if ( $item['tags'] != '' ) {
            $tagids = explode(',', $item['tags']);
            $item['tags'] = $tagService->getItems($tagids, 'id,name');
        }
        $this->assign('item', $item);

        //注册页面seo信息
        $this->assign('seoTitle', $item['title'].'-'.$this->mediaConfigs['sitename']);
        $this->assign('seoKwords', $item['kwords']);
        $this->assign('seoDesc', $item['bcontent']);

        $this->assign("chanelId", $item["media_chanel"]);

        $this->setView('article_detail');
    }


}
?>
