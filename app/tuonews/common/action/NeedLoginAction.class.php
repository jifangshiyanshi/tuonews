<?php
namespace common\action;
use herosphp\utils\Page;

/**
 * 需要登录的业务逻辑通用 Action
 * @author          yangjian<yangjian102621@163.com>
 */
abstract class NeedLoginAction extends CommonAction {

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


    public function C_start(){

        parent::C_start();

        //验证登录
        $this->loginCheck();
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
?>
