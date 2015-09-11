<?php
namespace user\action;

use common\action\NeedLoginAction;
use herosphp\bean\Beans;
use herosphp\core\WebApplication;
use herosphp\http\HttpRequest;
use herosphp\utils\AjaxResult;
use herosphp\utils\ArrayUtils;

/**
 * 用户文章 Action
 * @author          yangjian<yangjian102621@163.com>
 */
class ArticleAction extends NeedLoginAction {

    protected $articleService = null;

    protected $page = 1;

    protected $pagesize = 20;

    public function C_start() {
        parent::C_start();

        $webApp = WebApplication::getInstance();
        $request = $webApp->getHttpRequest();
        $currentOpt = $request->getAction().'@'.$request->getMethod();
        $this->assign("currentOpt", $currentOpt);

        $this->articleService = Beans::get('article.article.service');
    }

    /**
     * 文章列表
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {

        $conditions['userid'] = $this->loginUser['id'];
        $order = 'add_time DESC';
        $articles = $this->articleService->getItems($conditions, null, $order);
        $this->assign('articles', $articles);
        $this->setView('article/index');
    }

    /**
     * 评论列表
     * @param HttpRequest $request
     */
    public function comment( HttpRequest $request ) {
        $this->setView('article/comment');
    }

    /**
     * 添加文章界面
     * @param HttpRequest $request
     */
    public function add(HttpRequest $request) {
        $this->setView('article/add');
    }

    /**
     * 添加文章操作
     * @param HttpRequest $request
     */
    public function insert(HttpRequest $request) {

        $data = $request->getParameter('data');
        //如果有标签则先插入标签
        if ( trim($data['tags']) != '' ) {
            $tagService = Beans::get('article.tags.service');
            $tags = explode(',', $data['tags']);
            $tagIds = array();
            foreach ( $tags as $value ) {
                //1.首先查看标签是否存在,如果存在则直接取其ID
                $item = $tagService->getItem("name='{$value}'", 'id');
                if ( $item ) {
                    $tagIds[] = $item['id'];

                    //不存在则加入新标签
                } else {
                    $id = $tagService->add(array('name' => $value));
                    if ( $id > 0 ) {
                        $tagIds[] = $id;
                    }
                }
            }
        }
        $data['update_time'] = time();
        $data['add_time'] = time();
        $data['ischeck'] = 0;
        $data['tags'] = implode(',', $tagIds);
        $data['userid'] = $this->loginUser['id'];
        $data['author'] = $this->loginUser['nickname'] ? $this->loginUser['nickname'] : $this->loginUser['username'];

        //插入文章
        $service = Beans::get('article.article.service');

        if ( $service->add($data) ) {
            AjaxResult::ajaxSuccessResult();
        } else {
            AjaxResult::ajaxFailtureResult();
        }
    }

    /**
     * 修改文章界面
     * @param HttpRequest $request
     */
    public function edit(HttpRequest $request) {
        if ($request->getParameter('id', 'intval')) {
            $id = $request->getParameter('id', 'intval');
            $item = $this->articleService->getItem($id);

            if ($item['userid'] != $this->loginUser['id']){
                page404();
            }

            //初始化文章标签
            $tagsId = explode(',', $item['tags']);
            $tagService = Beans::get('article.tags.service');
            $tags = $tagService->getItems($tagsId, 'id, name');
            $tags = ArrayUtils::changeArrayKey($tags, 'id');
            $__tags = array();
            foreach ( $tagsId as $value ) {
                $__tags[] = $tags[$value]['name'];
            }
            $item['tags'] = implode(',', $__tags);
            $this->assign('item', $item);
            $this->setView('article/edit');
        } else {
            page404();
        }
    }

    /**
     * 更新文章操作
     * @param HttpRequest $request
     */
    public function update(HttpRequest $request) {
        $data = $request->getParameter('data');
        $data['update_time'] = time();

        //如果有标签则先插入标签
        $tag_bak = $request->getParameter('tag_bak', 'trim');
        if ( trim($data['tags']) != $tag_bak ) {
            $tagService = Beans::get('article.tags.service');
            $tags = explode(',', $data['tags']);
            $tagIds = array();
            foreach ( $tags as $value ) {
                //1.首先查看标签是否存在,如果存在则直接取其ID
                $item = $tagService->getItem("name='{$value}'", 'id');
                if ( $item ) {
                    $tagIds[] = $item['id'];

                    //不存在则加入新标签
                } else {
                    $id = $tagService->add(array('name' => $value));
                    if ( $id > 0 ) {
                        $tagIds[] = $id;
                    }
                }
            }
            $data['tags'] = implode(',', $tagIds);

            //不更改标签
        } else {
            unset($data['tags']);
        }


        if ( !$data ) AjaxResult::ajaxFailtureResult();

        $id = $request->getParameter('id', 'intval');
        if ( $id <= 0 ) AjaxResult::ajaxResult('error', INVALID_ARGS);

        if ( $this->articleService->update($data, $id) ) {
            AjaxResult::ajaxSuccessResult();
        } else {
            AjaxResult::ajaxFailtureResult();
        }
    }

    /**
     * 回收站文章列表
     * @param HttpRequest $request
     */
    public function trash(HttpRequest $request) {

    }

    /**
     * 删除文章到回收站操作
     * @param HttpRequest $request
     */
    public function doTrash(HttpRequest $request) {

    }

    /**
     * 彻底删除文章
     * @param HttpRequest $request
     */
    public function delete(HttpRequest $request) {

    }


}
?>
