<?php
namespace admin\action;

use herosphp\bean\Beans;
use herosphp\http\HttpRequest;
use herosphp\utils\AjaxResult;
use herosphp\utils\ArrayUtils;

/**
 * 用户爆料Action
 * @author          yangjian<yangjian102621@163.com>
 */
class TipoffAction extends CommonAction {

    /**
     * 初始化方法
     */
    public function C_start() {
        parent::C_start();
        $this->setServiceBean('tipoff.tipoff.service');
    }

    /**
     * 首页方法
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {

        parent::index($request);

        $items = $this->getTemplateVar('items');
        //初始化用户名
        $userIds = array();
        foreach ( $items as $value ) {
            $userIds[] = $value['userid'];
        }
        if ( !empty($userIds) ) {
            $userService = Beans::get('user.user.service');
            $users = $userService->getItems($userIds, 'id, username, nickname');
            $users = ArrayUtils::changeArrayKey($users, 'id');
        }

        foreach ( $items as $key => $value ) {
            $items[$key]['username'] = $users[$value['userid']]['username'];
            $items[$key]['nickname'] = $users[$value['userid']]['nickname'];
        }

        $this->assign('items', $items);

        $this->setView('article/tipoff_index');

    }

    /**
     * 获取爆料详情
     * @param HttpRequest $request
     */
    public function detail(HttpRequest $request) {

        $id = $request->getParameter('id', 'intval');
        $service = Beans::get($this->getServiceBean());
        $item = $service->getItem($id);
        if ( $item ) {
            AjaxResult::ajaxResult('ok', $item['content']);
        } else {
            AjaxResult::ajaxFailtureResult();
        }

    }

}
?>
