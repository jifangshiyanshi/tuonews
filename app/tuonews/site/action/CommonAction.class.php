<?php
namespace site\action;

use article\action\ArticleCommonAction;
use herosphp\bean\Beans;
use herosphp\core\WebApplication;
use herosphp\core\Loader;
use herosphp\utils\ArrayUtils;

Loader::import('article.action.ArticleCommonAction', IMPORT_APP);

/**
 * Index Action
 * @author          yangjian<yangjian102621@163.com>
 */
class CommonAction extends ArticleCommonAction {

    /**
     * 当前媒体信息
     * @var array
     */
    protected  $loginMedia = array();

    /**
     * 当前媒体配置
     * @var array
     */
    protected $mediaConfigs = array();

    /**
     * 初始化方法
     */
    public function C_start() {

        parent::C_start();

        $webApp = WebApplication::getInstance();
        $request = $webApp->getHttpRequest();
        //获取当前登录媒体
        $mediaService = Beans::get("media.media.service");
        $mediaId = $request->getParameter("media_id", 'intval');
        $this->loginMedia = $mediaService->getItem($mediaId);
        $this->mediaConfigs = cn_json_decode($this->loginMedia["configs"]);

        //注册媒体信息
        $this->assign('mediaConfigs', $this->mediaConfigs);
        $this->assign("loginMedia",$this->loginMedia);

        //获取媒体频道列表
        $chanelService = Beans::get("media.chanel.service");
        $chanels = $chanelService->getChanelCache($mediaId);
        $this->assign("chanels", $chanels);

        //底部单页导航
        $artoneService = Beans::get("artone.artone.service");
        $artoneMenu = $artoneService->getMediaArtone($this->loginMedia['id']);
        $this->assign("artoneMenu", $artoneMenu);

        //媒体底部友情链接列表
        $linkService = Beans::get("media.friendlink.service");
        $friendLinks = $linkService->getMediaFriendLinks($mediaId);
        $this->assign("friendLinks",$friendLinks);

        $this->getHotArticles($request);
    }

    /**
     * 获取文章数据
     * @param array $condition
     * @param int $page
     */
    public function loadMediaArticles($condition, $page=1, $order="id DESC") {

        $articleService = Beans::get("article.article.service");
        $this->setPage($page);
        $this->setPagesize(20);
        $fields = "id,title,thumb,add_time,bcontent,author,hits";
        $articles = $articleService->getItems($condition,$fields, $order, $this->getPage(), $this->getPagesize());
        //获取分页
        $count = $articleService->count($condition);
        $this->getPageData($count);
        $this->assign('items', $articles);
    }

    /**
     * 获取热点文章
     * @param HttpRequest $request
     */
    private function getHotArticles(HttpRequest $request) {

        $mediaId = $request->getParameter('media_id', 'intval');
        $articleService = Beans::get('article.article.service');
        $articleRecService = Beans::get('media.articleRec.service');
        $baseCondi = getMediaArticleConds();
        //1. 首先获取推荐位的文章
        $rcondi = array('media_id' => $mediaId, 'position' => 2, 'status' => 1);
        $item = $articleRecService->getItem($rcondi, 'aids');
        $field = 'id, title, thumb, bcontent, hits, author';
        if ( $item && $item['aids'] ) {
            $conditions = $baseCondi;
            $conditions['id'] = '#IN'.$item['aids'];
            $items = $articleService->getItems($conditions, $field);
            if ( $items ) {
                //按照ID排序
                $ids = explode(',', $item['aids']);
                $newsItems = array();
                $items = ArrayUtils::changeArrayKey($items, 'id');
                foreach ( $ids as $value ) {
                    if ( $items[$value] ) {
                        $newsItems[] = $items[$value];
                    }
                }
            }
        }
        //2. 推荐位的文章不够，再从最热门搜索补上
        if ( count($newsItems) < 10 ) {
            $conditions = $baseCondi;
            $conditions['media_id'] = $mediaId;
            if ( $item['aids'] ) {
                $conditions['id'] = '#NI'.$item['aids'];
            }
            $hotArticles = $articleService->getItems($conditions, $field, "hits desc", 1, 10-count($newsItems));
        }
        $result = array();
        if ( $newsItems ) {
            $result = array_merge($result, $newsItems);
        }
        if ( $hotArticles ) {
            $result = array_merge($result, $hotArticles);
        }
        $this->assign('hotArticles', $result);
    }

}
