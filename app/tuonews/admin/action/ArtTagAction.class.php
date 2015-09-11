<?php
namespace admin\action;

use herosphp\http\HttpRequest;

/**
 * 文章标签 Action
 * @author          yangjian<yangjian102621@163.com>
 */
class ArtTagAction extends CommonAction {

    /**
     * 初始化方法
     */
    public function C_start() {
        parent::C_start();
        $this->setServiceBean('article.tags.service');
    }

    /**
     * 标签列表
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {

        //接受参数
        $name = $request->getParameter('name', 'trim|urldecode');
        $condi = array();
        if ( $name != '' ) {
            $condi['name'] = "%{$name}%";
        }
        $this->setConditions($condi);
        parent::index($request);
        $this->assign('name', $name);
        $this->setView('article/tags_index');

    }

    /**
     * 标签编辑
     * @param HttpRequest $request
     */
    public function edit( HttpRequest $request ) {

        parent::edit($request);
        $this->setView('article/tags_edit');
    }

    /**
     * 更新标签操作
     * @param HttpRequest $request
     */
    public function update( HttpRequest $request ) {

        $data = $request->getParameter('data');
        parent::update($data, $request);

    }

}
?>
