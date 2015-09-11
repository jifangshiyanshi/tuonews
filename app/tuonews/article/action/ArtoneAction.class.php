<?php
namespace article\action;

use common\action\CommonAction;
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
     * 关于我们模块统一处理页面，属于单文章模型，默认将显示第一篇
     * @param HttpRequest $request
     */
    public function service( HttpRequest $request ) {

        $id  = $request->getParameter('id', 'intval');
        if ( $id <= 0 ) page404();

        $service = Beans::get('artone.artone.service');
        $service->increase('hits',1,$id);
        $item = $service->getItem($id);

        if ( !$item ) page404();

        $this->assign('item', $item);
        $this->setView('artone_detail');
    }

}
?>
