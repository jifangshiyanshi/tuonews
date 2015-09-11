<?php
namespace admin\action;

use herosphp\bean\Beans;
use herosphp\core\Debug;
use herosphp\http\HttpRequest;
use herosphp\utils\AjaxResult;
use herosphp\utils\ArrayUtils;

/**
 * 文章统计 Action
 * @author          yangjian<yangjian102621@163.com>
 */
class ArticleStatAction extends CommonAction {

    /**
     * 初始化方法
     */
    public function C_start() {
        parent::C_start();
        $this->setServiceBean('article.article.service');

        //获取所有的子频道
        $chanelService = Beans::get('admin.chanel.service');
        $subChanels = $chanelService->getItems('pid > 0', 'id,pid,name,seo_title', 'sort_num ASC');
        $chanels = $chanelService->getItems(null, 'id,pid,name,seo_title', 'sort_num ASC');

        $this->assign('subChanels', $subChanels);
        $this->assign('chanels', ArrayUtils::changeArrayKey($chanels, 'id'));
    }

    /**
     * 文章列表
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {

        $title = $request->getParameter('title', 'trim');
        $chanelId = $request->getParameter('chanel_id', 'intval');
        $order = $request->getParameter('order', 'trim');
        $time = $request->getParameter('time', 'trim');

        $conditions = array();
        //标题筛选
        if ( $title != '' ) {
            $conditions['title'] = '%.'.$title.'%';
        }

        //频道筛选
        if ( $chanelId > 0 ) {
            $conditions['chanel_id'] = $chanelId;
        }

        //时间筛选
        if ( $time != '' ) {
            $this->getTimeCondition($time, $conditions);
        }

        $this->setFields('id,title,userid,chanel_id,add_time,hits,collect_times,zan_times,share_times,comment_times');
        $this->setConditions($conditions);

        //设置排序
        $this->setOrder($this->getOrderString($order));

        parent::index($request);
        $this->setView('article/article_statistics');

        $this->assign('params', $request->getParameters());

    }

    /**
     * 获取排序
     * @param $order
     * @return mixed
     */
    private function getOrderString($order) {

        switch ( $order ) {

            case 'hits':
                $_order = 'hits ASC';
                break;
            case '_hits':
                $_order = 'hits DESC';
                break;
            case 'comment':
                $_order = 'comment_times ASC';
                break;
            case '_comment':
                $_order = 'comment_times DESC';
                break;
            case 'share':
                $_order = 'share_times ASC';
                break;
            case '_share':
                $_order = 'share_times DESC';
                break;
            case 'collect':
                $_order = 'collect_times ASC';
                break;
            case '_collect':
                $_order = 'collect_times DESC';
                break;
            case 'zan':
                $_order = 'zan_times ASC';
                break;
            case '_zan':
                $_order = 'zan_times DESC';
                break;
            default :
                $_order = 'id DESC';
        }
        return $_order;
    }

    /**
     * 获取时间条件
     * @param $time
     * @param $conditions 条件
     */
    private function getTimeCondition($time, &$conditions) {

        $endday = time();
        switch ($time) {
            case 'today':
                $startday = strtotime(date('Y-m-d', time()));
                $conditions['add_time'] = '>='.$startday;
                $conditions['#add_time'] = '<='.$endday;
                break;
            case 'yesterday':
                $startday = strtotime(date('Y-m-d', strtotime("-1 day")));
                $endday = strtotime(date('Y-m-d'));
                $conditions['add_time'] = '>='.$startday;
                $conditions['#add_time'] = '<='.$endday;
                break;
            case 'week':
                $startday = strtotime(date('Y-m-d', strtotime("-7 day")));
                $conditions['add_time'] = '>='.$startday;
                $conditions['#add_time'] = '<='.$endday;
                break;
            case 'month':
                $startday = strtotime(date('Y-m-d', strtotime("-30 day")));
                $conditions['add_time'] = '>='.$startday;
                $conditions['#add_time'] = '<='.$endday;
                break;

        }
    }


}
?>
