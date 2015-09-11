<?php
namespace article\action;

use common\action\CommonAction;
use herosphp\bean\Beans;
use herosphp\utils\Page;

/**
 * 文章模块公共抽象 action
 * Class ArticleCommonAction
 * @package article\action
 */
abstract class ArticleCommonAction extends CommonAction{

    /**
     * 当前页面
     * @var int
     */
    protected $page = 1;

    /**
     * 每页显示记录数量
     * @var int
     */
    protected $pagesize = 12;

    /**
     * 初始化方法
     */
    public function C_start() {

        parent::C_start();
        //获取友情链接
        $friendLinkService = Beans::get('admin.friendlink.service');
        $friendLinks = $friendLinkService->getFootLinks(40);
        $this->assign('friendLinks', $friendLinks);

        //获取底部导航
        $artoneService = Beans::get('artone.artone.service');
        $footNavis = $artoneService->getFootNavis(6, 'site_bottom', 'sort_num ASC');
        $this->assign('footNavis', $footNavis);

    }

    /**
     * 对数据进行分页
     * @param int 总记录数 $total
     */
    protected function getPageData($total) {

        $pageHandler = new Page($total, $this->getPagesize(), $this->getPage(), 3);
        //获取分页数据
        $pageData = $pageHandler->getPageData(DEFAULT_PAGE_STYLE);
        if (!empty($pageData)) {
            $pagemenu = '<ul class="page">';
            if ($pageData['prev'] != '#'){
                $pagemenu .= '<li class="prev"><a href="'.$pageData['prev'].'"><span class="icon icon_page_prev"></span></a></li>';
            }
            foreach($pageData['list'] as $key => $value) {
                if( $value == '#' ) {
                    $pagemenu .= '<li class="num current">'.$key.'</li>';
                } else {
                    $pagemenu .= '<li class="num"><a href="'.$value.'">'.$key.'</a></li>';
                }
            }
            if ($pageData['next'] != '#'){
                $pagemenu .= '<li class="next"><a href="'.$pageData['next'].'"><span class="icon icon_page_next"></span></a></li>';
            }
            $pagemenu .= '</ul>';

            $this->assign('pagemenu', $pagemenu);
        }
    }

    /**
     * @return int
     */
    protected function getPage()
    {
        if ( $this->page > 0 ) {
            return $this->page;
        } else {
            return 1;
        }
    }

    /**
     * @param int $page
     */
    protected function setPage($page)
    {
        if ( $page > 0 ) {
            $this->page = $page;
        }
    }

    /**
     * @return int
     */
    protected function getPagesize()
    {
        return $this->pagesize;
    }

    /**
     * @param int $pagesize
     */
    protected function setPagesize($pagesize)
    {
        $this->pagesize = $pagesize;
    }
}
