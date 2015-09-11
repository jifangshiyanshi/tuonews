<?php
namespace admin\action;

use herosphp\bean\Beans;
use herosphp\http\HttpRequest;

/**
 * 单文章 Action
 * @author          yangjian<yangjian102621@163.com>
 */
class ArtoneAction extends CommonAction {

    /**
     * 初始化方法
     */
    public function C_start() {
        parent::C_start();
        $this->setServiceBean('artone.artone.service');

    }

    /**
     * 单文章列表
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {

        $this->setConditions("media_id=0");
        parent::index($request);
        $this->setView('artone/artone_index');

    }

    /**
     * @param HttpRequest $request
     */
    public function add(HttpRequest $request) {

        $this->setView('artone/artone_add');
    }

    /**
     * 添加单文章操作
     * @param HttpRequest $request
     */
    public function insert(HttpRequest $request) {

        $data = $request->getParameter('data');
        $data['update_time'] = time();
        $data['add_time'] = time();
        $service = Beans::get($this->getServiceBean());
        if ( $service->add($data) ) {
            //清除缓存
            $service->deleteFootNavisCache();
            AjaxResult::ajaxSuccessResult();
        } else {
            AjaxResult::ajaxFailtureResult();
        }
    }

    /**
     * @param HttpRequest $request
     */
    public function edit(HttpRequest $request) {

        parent::edit($request);
        $this->setView('artone/artone_edit');

        $item = $this->getTemplateVar('item');

        //注册图片空间的用户id
        if ( $item['userid'] > 0 ) {
            $_SESSION['front_userid'] = $item['userid'];
        }
        $this->assign('item', $item);

    }

    /**
     * 更新单文章
     * @param HttpRequest $request
     */
    public function update(HttpRequest $request) {

        $data = $request->getParameter('data');
        $data['update_time'] = time();
        $id = $request->getParameter('id', 'intval');
        if ( $id <= 0 ) AjaxResult::ajaxResult('error', INVALID_ARGS);

        $service = Beans::get($this->getServiceBean());
        if ( $service->update($data, $id) ) {
            //清除缓存
            $service->deleteFootNavisCache();
            AjaxResult::ajaxSuccessResult();
        } else {
            AjaxResult::ajaxFailtureResult();
        }
    }

    /**
     * 选择文章
     * @param HttpRequest $request
     */
    public function select(HttpRequest $request) {

        $aids = $request->getParameter('aids', 'trim');

        $this->setPagesize(12);
        $this->setFields('id,title,add_time,hits');
        parent::index($request);
        $this->setView('artone/artone_select');

        $aids = explode(',', $aids);
        $this->assign('aids', $aids);

    }
}
?>
