<?php
namespace media\action;

use herosphp\bean\Beans;
use herosphp\core\Loader;
use herosphp\http\HttpRequest;
use herosphp\utils\AjaxResult;
use herosphp\utils\ArrayUtils;

/**
 * 媒体用户文章推荐位 Action
 * @author          yangjian<yangjian102621@163.com>
 */
class ArticleRecAction extends MediaAction {

    public function C_start(){

        $this->setServiceBean("media.articleRec.service");
        parent::C_start();
    }
    /**
     * 文章推荐位列表
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {

        $__configs = Loader::config('media', 'data');
        $service = Beans::get($this->getServiceBean());
        $condi = array('media_id' => $this->loginMedia['id']);
        $items = $service->getItems($condi);
        $items = ArrayUtils::changeArrayKey($items, 'position');
        $__configs = $__configs['media_article_rec'];
        $__items = array();
        foreach ( $__configs as $key => $value ) {
            $__items[$key]['name'] = $value;
            $__items[$key]['id'] = $key;
            //判断是否开启此推荐位
            if ( !empty($items[$key]) ) {
                $__items[$key]['open'] = $items[$key]['status'];
            } else {
                $__items[$key]['open'] = 0;
            }
        }
        $this->assign('items', $__items);

        $this->assign("seoTitle","媒体中心后台管理-文章推荐位");

        $this->setView('article/recommend_index');
    }

    /**
     * 开启推荐位
     * @param HttpRequest $request
     */
    public function open(HttpRequest $request) {

        $id = $request->getParameter('id', 'intval');
        if ( $id <= 0 ) {
            AjaxResult::ajaxFailtureResult();
        }
        $condi = array('position' => $id, 'media_id' => $this->loginMedia['id']);
        $service = Beans::get($this->getServiceBean());
        $item = $service->getItem($condi);
        //1. 如果已经添加了该推荐位，则更新其状态
        if ( $item ) {
            $result = $service->set('status', 1, $item['id']);
        } else {
            //2. 添加推荐位
            $data = array(
                'media_id' => $this->loginMedia['id'],
                'position' => $id,
                'status' => 1
            );
            $result = $service->add($data);
        }
        if ( $result ) {
            AjaxResult::ajaxResult('ok', '启用推荐位成功！');
        } else {
            AjaxResult::ajaxResult('error', '启用推荐位失败！');
        }
    }

    /**
     * 关闭推荐位
     * @param HttpRequest $request
     */
    public function close(HttpRequest $request) {

        $id = $request->getParameter('id', 'intval');
        if ( $id <= 0 ) {
            AjaxResult::ajaxFailtureResult();
        }
        $condi = array('position' => $id, 'media_id' => $this->loginMedia['id']);
        $service = Beans::get($this->getServiceBean());
        $item = $service->getItem($condi);
        if ( !$item ) {
            AjaxResult::ajaxFailtureResult();
        }
        if ( $service->set('status', 0, $item['id']) ) {
            AjaxResult::ajaxResult('ok', '关闭推荐位成功！');
        } else {
            AjaxResult::ajaxResult('error', '关闭推荐位失败！');
        }
    }

    /**
     * 推荐位详情
     * @param HttpRequest $request
     */
    public function detail(HttpRequest $request) {

        $id = $request->getParameter('id', 'intval');
        if ( $id <= 0 ) {
            page404();
        }
        $condi = array('position' => $id, 'media_id' => $this->loginMedia['id']);
        $service = Beans::get($this->getServiceBean());
        $item = $service->getItem($condi);
        if ( !$item ) {
            page404();
        }
        //获取推荐位的文章
        if ( $item['aids'] ) {
            $articleService = Beans::get('article.article.service');
            $aids = explode(',', $item['aids']);
            $items = $articleService->getItems($aids, 'id, title, add_time');
            //重新按照推荐位ID排序
            $items = ArrayUtils::changeArrayKey($items, 'id');
            $newItems = array();
            foreach ( $aids as $value ) {
                $newItems[] = $items[$value];
            }
            $this->assign('items', $newItems);
        }
        $this->assign('item', $item);
        $this->setView('article/recommend_detail');
    }

    /**
     * 更新推荐位的文章
     * @param HttpRequest $request
     */
    public function updateArt(HttpRequest $request) {

        $id = $request->getParameter('id', 'intval');
        $ids = $request->getParameter('aids');
        if ( is_array($ids) ) {
            $ids = implode(',', $ids);
        }
        if ( $id <= 0 ) {
            AjaxResult::ajaxFailtureResult();
        }

        $service = Beans::get($this->getServiceBean());
        if ( $service->set('aids', $ids, $id) ) {
            AjaxResult::ajaxSuccessResult();
        } else {
            AjaxResult::ajaxFailtureResult();
        }
    }

}
?>
