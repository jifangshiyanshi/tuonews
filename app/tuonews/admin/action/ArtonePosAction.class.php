<?php
namespace admin\action;

use herosphp\bean\Beans;
use herosphp\http\HttpRequest;

/**
 * 单文章显示位 Action
 * @author          yangjian<yangjian102621@163.com>
 */
class ArtonePosAction extends CommonAction {

    /**
     * 初始化方法
     */
    public function C_start() {
        parent::C_start();
        $this->setServiceBean('artone.position.service');
    }

    /**
     * 显示位列表
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {

        parent::index($request);
        //获取文章数量
        $items = $this->getTemplateVar('items');
        foreach ( $items as $key => $value ) {
            if ( $value['aids'] == '' ) {
                $items[$key]['art_num'] = 0;
            } else {
                $items[$key]['art_num'] = mb_substr_count($value['aids'], ',') + 1;
            }
        }
        $this->assign('items', $items);
        $this->setView('artone/position_index');

    }

    /**
     * 添加显示位
     * @param HttpRequest $request
     */
    public function add( HttpRequest $request ) {

        $this->setView('artone/position_add');

    }

    /**
     * 显示位编辑
     * @param HttpRequest $request
     */
    public function edit( HttpRequest $request ) {

        parent::edit($request);

        $item = $this->getTemplateVar('item');
        //获取当前位置包含的文章
        if ( $item['aids'] ) {
            $articleService = Beans::get('artone.artone.service');
            $articles = $articleService->getItems(explode(',', $item['aids']), 'id,title');
            $this->assign('articles', $articles);
            //组建js对象
            $data = "{";
            foreach ( $articles as $value ) {
                if ( $data == '{' ) {
                    $data .= "'{$value['id']}' : '{$value['title']}'";
                } else {
                    $data .= ", '{$value['id']}' : '{$value['title']}'";
                }
            }
            $data .= '}';
            $this->assign('data', $data);
        }

        $this->setView('artone/position_edit');
    }

    /**
     * 添加显示位操作
     * @param HttpRequest $request
     */
    public function insert( HttpRequest $request ) {

        $data = $request->getParameter('data');
        $data['add_time'] = time();

        $this->checkField('position', $data['position']);

        parent::insert($data);
    }

    /**
     * 更新显示位操作
     * @param HttpRequest $request
     */
    public function update( HttpRequest $request ) {

        $data = $request->getParameter('data');
        $posBak = $request->getParameter('pos_bak', 'trim');

        //更改了position重新认证
        if ( $posBak != $data['position'] ) {
            $this->checkField('position', $data['position']);
        }

        parent::update($data, $request);

    }

}
?>
