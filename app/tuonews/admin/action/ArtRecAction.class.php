<?php
namespace admin\action;

use herosphp\bean\Beans;
use herosphp\http\HttpRequest;
use herosphp\utils\ArrayUtils;

/**
 * 文章推荐位 Action
 * @author          yangjian<yangjian102621@163.com>
 */
class ArtRecAction extends CommonAction {

    /**
     * 初始化方法
     */
    public function C_start() {
        parent::C_start();
        $this->setServiceBean('article.rec.service');
    }

    /**
     * 推荐位列表
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {

        $this->setOrder('sort_num ASC');
        parent::index($request);
        $this->setView('article/recommend_index');

    }

    /**
     * 添加推荐位
     * @param HttpRequest $request
     */
    public function add( HttpRequest $request ) {

        $this->setView('article/recommend_add');

    }

    /**
     * 推荐位编辑
     * @param HttpRequest $request
     */
    public function edit( HttpRequest $request ) {

        parent::edit($request);

        $item = $this->getTemplateVar('item');
        //获取推荐位置的文章
        if ( $item['aids'] ) {
            $articleService = Beans::get('article.article.service');
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
        $this->setView('article/recommend_edit');
    }

    /**
     * 添加推荐位操作
     * @param HttpRequest $request
     */
    public function insert( HttpRequest $request ) {

        $data = $request->getParameter('data');
        $data['add_time'] = time();

        //检查位置key是否存在
        //检验模板key唯一性
        $tkey_bak = $request->getParameters('tkey_bak', 'trim');
        if ( $tkey_bak != trim($data['position']) ) {
            $this->checkField('position', $data['position']);
        }

        parent::insert($data);
    }

    /**
     * 更新推荐位操作
     * @param HttpRequest $request
     */
    public function update( HttpRequest $request ) {

        $data = $request->getParameter('data');
        parent::update($data, $request);

    }

}
?>
