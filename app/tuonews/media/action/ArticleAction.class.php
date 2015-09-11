<?php
namespace media\action;

use herosphp\bean\Beans;
use herosphp\http\HttpRequest;
use herosphp\utils\AjaxResult;
use herosphp\utils\ArrayUtils;

/**
 * 媒体用户文章 Action
 * @author          yangjian<yangjian102621@163.com>
 */
class ArticleAction extends MediaAction {

    public function C_start(){

        $this->setServiceBean("article.article.service");
        parent::C_start();
    }
    /**
     * 已发布文章列表
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {

        //获取文章列表
        $condi = array('media_id' => $this->loginMedia['id']);
        $this->getArtData($condi, $request);

        $this->assign("seoTitle","媒体中心后台管理-已发布文章列表");
        $this->assign("seoDesc","已发布文章列表");
        $this->assign("seoKwords","媒体中心后台管理 已发布文章列表");

        $this->setView('article/article_list');
    }
    /**
     * 已审核文章列表
     * @param HttpRequest $request
     */
    public function checked( HttpRequest $request ) {

        //获取文章列表
        $condi = array('ischeck' => 1, 'media_id' => $this->loginMedia['id']);
        $this->getArtData($condi, $request);

        $this->assign("seoTitle","媒体中心后台管理-已审核文章列表");
        $this->assign("seoDesc","已审核文章列表");
        $this->assign("seoKwords","媒体中心后台管理 已审核文章列表");

        $this->setView('article/article_list');
    }
    /**
     * 未审核文章列表
     * @param HttpRequest $request
     */
    public function uncheck( HttpRequest $request ) {

        //获取未审核文章列表
        $condi = array('ischeck' => 0, 'media_id' => $this->loginMedia['id']);
        $this->getArtData($condi, $request);

        $this->assign("seoTitle","媒体中心后台管理-未审核文章列表");
        $this->assign("seoDesc","未审核文章列表");
        $this->assign("seoKwords","媒体中心后台管理 未审核文章列表");

        $this->setView('article/article_list');
    }
    /**
     * 未通过文章列表
     * @param HttpRequest $request
     */
    public function aborted( HttpRequest $request ) {

        //获取未通过文章列表
        $condi = array('ischeck' => -1, 'media_id' => $this->loginMedia['id']);
        $this->getArtData($condi, $request);

        $this->assign("seoTitle","媒体中心后台管理-未通过文章列表");
        $this->assign("seoDesc","未通过文章列表");
        $this->assign("seoKwords","媒体中心后台管理 未通过文章列表");

        $this->setView('article/article_list');
    }

    /**
     * 置顶文章列表
     * @param HttpRequest $request
     */
    public function top(HttpRequest $request) {

        $condi = array('sort_num' => '>0', 'media_id' => $this->loginMedia['id']);
        $this->getArtData($condi, $request, 'sort_num DESC');
        $this->setView('article/article_top');

    }

    /**
     * 添加置顶文章
     * @param HttpRequest $request
     */
    public function addtop(HttpRequest $request) {

        $id = $request->getParameter('id', 'intval');
        if ( $id <= 0 ) {
            AjaxResult::ajaxFailtureResult();
        }
        $articleService = Beans::get('article.article.service');
        //最多置顶5篇文章
        $maxTopNum = 5;
        $condi = array('sort_num' => '>0', 'media_id' => $this->loginMedia['id']);
        if ( $articleService->count($condi) >= $maxTopNum ) {
            AjaxResult::ajaxResult('error', '您最多能设置5篇文章置顶。');
        }
        $result = $articleService->getItem($condi, 'id,max(sort_num) as max_sort');
        if ( $articleService->set('sort_num', $result['max_sort']+1, $id) ) {
            AjaxResult::ajaxResult('ok', '置顶成功！');
        } else {
            AjaxResult::ajaxResult('error', '置顶失败！');
        }

    }

    /**
     * 取消文章置顶
     * @param HttpRequest $request
     */
    public function canceltop(HttpRequest $request) {
        $id = $request->getParameter('id', 'intval');
        if ( $id <= 0 ) {
            AjaxResult::ajaxFailtureResult();
        }
        $articleService = Beans::get('article.article.service');
        //将sort_num清0
        if ( $articleService->set('sort_num', 0, $id) ) {
            AjaxResult::ajaxResult('ok', '取消置顶成功！');
        } else {
            AjaxResult::ajaxResult('error', '取消置顶失败！');
        }
    }

    /**
     * 更新置顶文章排序
     * @param HttpRequest $request
     */
    public function updateTopSort(HttpRequest $request) {

        $ids = $request->getParameter('ids');
        $sort_num = $request->getParameter('sort_num');
        $articleService = Beans::get('article.article.service');
        $counter = 0;
        foreach ( $ids as $key => $value ) {
            if ( $articleService->set('sort_num', $sort_num[$key], $value) ) {
                $counter++;
            }
        }
        if ( $counter == count($ids) ) {
            AjaxResult::ajaxSuccessResult();
        } else {
            AjaxResult::ajaxFailtureResult();
        }
    }

    /**
     * 获取文章数据
     * @param $condition
     * @param HttpRequest $request
     */
    private function getArtData($condition, HttpRequest $request, $order='id DESC') {

        $articleService = Beans::get('article.article.service');
        $chanelService = Beans::get("media.chanel.service");
        $fields = "id,userid,media_chanel,title,sort_num,add_time";
        $items = $articleService->getItems($condition, $fields, $order);

        $chanels = $chanelService->getItems("media_id=".$this->loginMedia['id']);
        $chanels = ArrayUtils::changeArrayKey($chanels, 'id');
        foreach ( $items as $key => $value ) {
            $items[$key]['chanel'] = $chanels[$value['media_chanel']]['name'];
        }

        $this->assign('items', $items);
    }

    /**
     * 添加文章界面
     * @param HttpRequest $request
     */
    public function add(HttpRequest $request) {

        //获取媒体频道列表
        $service = Beans::get("media.chanel.service");
        $navList = $service->getItems("media_id=".$this->loginMedia["id"],"id,name");

        $this->assign("navList",$navList);
        $this->assign("seoTitle","媒体中心后台管理 - 添加文章");
        $this->assign("seoDesc","媒体中心后台管理 - 添加文章");
        $this->assign("seoKwords","媒体中心后台管理 添加文章");
        $this->setView('article/article_form');
    }

    /**
     * 添加文章操作
     * @param HttpRequest $request
     */
    public function insert(HttpRequest $request) {

        $data = $request->getParameter("data");
        $data["userid"]   = $this->loginUser["id"];
        $data["media_id"] = $this->loginMedia["id"];
        $data["add_time"] = time();
        $data["update_time"] = time();
        $data["ischeck"]  = 0;
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
        $data['tags'] = implode(',', $tagIds);
        parent::insert($data);
    }

    /**
     * 修改文章界面
     * @param HttpRequest $request
     */
    public function edit(HttpRequest $request) {

        //获取媒体频道列表
        $service = Beans::get("media.chanel.service");
        $navList = $service->getItems("media_id=".$this->loginMedia["id"],"id,name");
        $this->assign("navList",$navList);

        $articleService = Beans::get($this->getServiceBean());
        $id = $request->getParameter('id', 'intval');
        $item = $articleService->getItem($id);

        if ( $item['media_id'] != $this->loginMedia['id']){
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

        $this->assign("seoTitle","媒体中心后台管理 - 编辑文章");
        $this->assign("seoDesc","媒体中心后台管理 文章列表 - 编辑文章");
        $this->assign("seoKwords","媒体中心后台管理 文章列表  编辑文章");

        $this->setView('article/article_form');
    }

    /**
     * 更新文章操作
     * @param HttpRequest $request
     */
    public function update(HttpRequest $request) {

        $data = $request->getParameter("data");
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

        $data['update_time'] = time();

        parent::update($data,$request);
    }

    /**
     * 批量删除文章
     * @param HttpRequest $request
     */
    public function deletes(HttpRequest $request) {

        $ids=$request->getParameter("ids");
        if(empty($ids)){
            AjaxResult::ajaxResult("error","请选择要删除的文章");
        }

        $service = Beans::get($this->getServiceBean());
        $res = $service->deletes($ids);
        if( $res ) {
            AjaxResult::ajaxSuccessResult();
        }else{
            AjaxResult::ajaxFailtureResult();
        }
    }

    /**
     * 选择文章
     * @param HttpRequest $request
     */
    public function select(HttpRequest $request) {

        $ids = $request->getParameter('ids', 'urldecode|trim');
        $page = $request->getParameter('page', 'intval');
        if ( $page <= 0 ) {
            $page = 1;
        }

        $service = Beans::get('article.article.service');
        $condi = array('media_id' => $this->loginMedia['id']);
        $items = $service->getItems($condi, "id, title, hits, add_time", "id DESC", $page, 10);
        $this->assign('items', $items);

        //获取分页
        $total = $service->count($condi);
        $this->setPage($page);
        $this->getPageData($total);

        $this->assign('selected', explode(',', $ids));
        $this->setView('article/article_select');
    }

}
?>
