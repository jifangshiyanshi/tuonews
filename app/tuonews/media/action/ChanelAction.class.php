<?php
namespace media\action;

use herosphp\http\HttpRequest;

/**
 * 媒体频道 Action
 * @author          yangjian<yangjian102621@163.com>
 */
class ChanelAction extends MediaAction {

    /**
     * 媒体频道列表
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {
        $this->setView('system/chanel_list');
    }

    /**
     * 添加媒体频道界面
     * @param HttpRequest $request
     */
    public function add(HttpRequest $request) {
        $this->setView('system/chanel_form');
    }

    /**
     * 添加媒体频道操作
     * @param HttpRequest $request
     */
    public function insert(HttpRequest $request) {

    }

    /**
     * 编辑媒体频道界面
     * @param HttpRequest $request
     */
    public function edit(HttpRequest $request) {

    }

    /**
     * 更新媒体频道操作
     * @param HttpRequest $request
     */
    public function update(HttpRequest $request) {
        $this->setView('chanel_form');
    }

    /**
     * 删除媒体频道
     * @param HttpRequest $request
     */
    public function delete(HttpRequest $request) {

    }

}
?>
