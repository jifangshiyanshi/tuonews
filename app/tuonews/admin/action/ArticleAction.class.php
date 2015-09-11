<?php
namespace admin\action;

use herosphp\bean\Beans;
use herosphp\http\HttpRequest;
use herosphp\utils\AjaxResult;
use herosphp\utils\ArrayUtils;

/**
 * 文章 Action
 * @author          yangjian<yangjian102621@163.com>
 */
class ArticleAction extends CommonAction {

    /**
     * 初始化方法
     */
    public function C_start() {
        parent::C_start();
        $this->setServiceBean('article.article.service');

        //获取所有的频道
        $chanelService = Beans::get('admin.chanel.service');
        $chanels = $chanelService->getItems(null, 'id,pid,name,seo_title', 'sort_num ASC');
        //提取一级频道
        $topChanels = ArrayUtils::filterArrayByKey('pid', 0, $chanels);
        $tchanelIds = array();
        foreach ( $topChanels as $key => $value ) {
            $topChanels[$key]['sub'] = ArrayUtils::filterArrayByKey('pid', $value['id'], $chanels);
            $tchanelIds[] = $value['id'];
        }

        //提取子频道
        $subChanels = ArrayUtils::filterArrayByKey('pid', $tchanelIds, $chanels);

        $this->assign('chanels', ArrayUtils::changeArrayKey($chanels, 'id'));
        $this->assign('topChanels', $topChanels);
        $this->assign('subChanels', $subChanels);

    }

    /**
     * 文章列表
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {

        $conditions = array('trash' => 0, 'ischeck' => 1);
        $this->getData($conditions, $request);
        //注册操作
        $this->assign('opt', 'index');
        $this->setView('article/article_index');
        $this->assign('search_url', url('/admin_article_index'));

    }

    /**
     * 文章回收站
     * @param HttpRequest $request
     */
    public function trash( HttpRequest $request ) {

        $this->getData(array('trash' => 1), $request);
        //注册操作
        $this->assign('opt', 'trash');
        $this->setView('article/article_index');
        $this->assign('search_url', url('/admin_article_trash'));
    }

    /**
     * 文章审核
     * @param HttpRequest $request
     */
    public function check( HttpRequest $request ) {

        $this->getData(array('ischeck' => 0, 'trash' => 0), $request);
        //注册操作
        $this->assign('opt', 'check');
        $this->setView('article/article_index');
        $this->assign('search_url', url('/admin_article_check'));
    }

    /**
     * 推荐栏文章
     * @param HttpRequest $request
     */
    public function recommend( HttpRequest $request ) {

        $recid = $request->getParameter('recid', 'intval');
        //查找推荐位置
        $artRecService = Beans::get('article.rec.service');
        $recommends = $artRecService->getItems();
        $aids = array();
        if ( $recid > 0 ) {
            $item = $artRecService->getItem($recid);
            if ( $item['aids'] != '' ) {
                $aids = explode(',', $item['aids']);
            }
        } else {
            $recommends = $artRecService->getItems();
            foreach ( $recommends as $value ) {
                if ( $value['aids'] != '' ) {
                    $aids = array_merge($aids, explode(',', $value['aids']));
                }
            }
        }
        //如果没有1个
        if ( empty($aids) ) {
            $aids[] = "''";
        }
        $conditions = array('id' => "#IN ".implode(',', $aids)."");
        $this->getData($conditions, $request);
        $this->assign('recommends', $recommends);
        $this->setView('article/article_recommend');
    }

    /**
     * 获取数据
     * @param array $conditions
     * @param HttpRequest $request
     */
    private function getData( array $conditions, HttpRequest $request ) {

        $title = $request->getParameter('title', 'urldecode|trim');
        $startTime = $request->getParameter('start_time', 'trim');
        $endTime = $request->getParameter('end_time', 'trim');
        $chanelId = $request->getParameter('chanel_id', 'intval');

        //标题筛选
        if ( $title != '' ) {
            $conditions['title'] = '%'.$title.'%';
        }

        //频道筛选
        if ( $chanelId > 0 ) {
            $conditions['chanel_id'] = $chanelId;
        }

        //筛选时间
        if ( $startTime != '' ) {
            $conditions['add_time'] = '>='.strtotime($startTime);
        }
        if ( $endTime != '' ) {
            $conditions['#add_time'] = '<='.strtotime($endTime);
        }

        $this->setFields('id,userid,chanel_id,media_id,title,author,add_time,hits');
        $this->setConditions($conditions);
        $this->setOrder('add_time DESC');
        parent::index($request);

        //初始化来源
        $mediaIds = array();
        $items = $this->getTemplateVar('items');
        foreach ( $items as $value ) {
            $mediaIds[] = $value['media_id'];
        }
        if ( !empty($items) ) {
            $mediaService = Beans::get('media.media.service');
            $medias = $mediaService->getItems($mediaIds, 'id,name');
            $medias = ArrayUtils::changeArrayKey($medias, 'id');
            foreach ( $items as $key => $value ) {
                if ( $value['media_id'] == 0 ) {
                    $items[$key]['media'] = '驼牛网';
                    continue;
                }
                $items[$key]['media'] = $medias[$value['media_id']]['name'];
            }

            $this->assign('items', $items);
        }

        //注册搜索变量
        $params = $request->getParameters();
        $params['title'] = urldecode($params['title']);
        $this->assign('params', $params);

    }

    /**
     * @param HttpRequest $request
     */
    public function add(HttpRequest $request) {

        //初始化文章推荐位置
        $this->setView('article/article_add');
    }

    /**
     * 添加文章操作
     * @param HttpRequest $request
     */
    public function insert(HttpRequest $request) {

        $data = $request->getParameter('data');
        $data['update_time'] = time();
        $data['add_time'] = time();
        //默认审核
        $data['ischeck'] = 1;

        //是否定时发布
        $publish = $request->getParameter('publish');
        if ( $publish == 1 ) {
            $data['publish_time'] = time();
        } else {
            $data['publish_time'] = strtotime($request->getParameter('publish_time', 'trim'));
        }

        //如果有标签则先插入标签
        if ( trim($data['tags']) != '' ) {
            $tagService = Beans::get('article.tags.service');
            $tags = explode(',', $data['tags']);
            $tagIds = array();
            foreach ( $tags as $value ) {
                $id = $tagService->add(array('name' => $value));
                if ( $id > 0 ) {
                    $tagIds[] = $id;
                }
            }
        }
        $data['tags'] = implode(',', $tagIds);

        //插入文章
        parent::insert($data, $request);
    }

    /**
     * @param HttpRequest $request
     */
    public function edit(HttpRequest $request) {

        parent::edit($request);
        //初始化文章推荐位置
        $this->setView('article/article_edit');

        $item = $this->getTemplateVar('item');
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

        //注册图片空间的用户id
        if ( $item['userid'] > 0 ) {
            $this->assign('userid', $item['userid']);
            $this->assign('mediaId', $item['media_id']);

            $_SESSION['front_userid'] = $item['userid'];
            $_SESSION['front_mediaId'] = $item['media_id'];
        }

    }

    /**
     * 更新文章
     * @param HttpRequest $request
     */
    public function update(HttpRequest $request) {

        $data = $request->getParameter('data');
        $data['update_time'] = time();

        //是否定时发布
        $publish = $request->getParameter('publish');
        if ( $publish == 0 ) {
            $data['publish_time'] = strtotime($request->getParameter('publish_time', 'trim'));
            //更改审核状态
            $data['ischeck'] = 0;
        } else {
            $data['publish_time'] = 0;
            $data['ischeck'] = 1;
        }

        //如果有标签则先插入标签
        $tag_bak = $request->getParameter('tag_bak', 'trim');
        if ( trim($data['tags']) != $tag_bak ) {
            $tagService = Beans::get('article.tags.service');
            $tags = explode(',', $data['tags']);
            $tagIds = array();
            foreach ( $tags as $value ) {
                $id = $tagService->add(array('name' => $value));
                if ( $id > 0 ) {
                    $tagIds[] = $id;
                }
            }
            $data['tags'] = implode(',', $tagIds);

            //不更改标签
        } else {
            unset($data['tags']);
        }

        parent::update($data, $request);
    }

    /**
     * 回收站操作，删除 OR 还原
     * @param HttpRequest $request
     */
    public function doTrash( HttpRequest $request ) {

        $ids = $request->getParameter('ids');
        $trash = $request->getParameter('trash', 'intval');
        if ( count($ids) == 0 ) {
            AjaxResult::ajaxResult('error', '您没有更改任何记录！');
        }

        $service = Beans::get($this->getServiceBean());
        if ( $service->sets('trash', $trash, $ids) ) {
            AjaxResult::ajaxSuccessResult();
        } else {
            AjaxResult::ajaxFailtureResult();
        }
    }

    /**
     * 审核操作，审核 OR 取消审核
     * @param HttpRequest $request
     */
    public function doCheck(HttpRequest $request) {

        $ids = $request->getParameter('ids');
        $check = $request->getParameter('check', 'intval');
        if ( count($ids) == 0 ) {
            AjaxResult::ajaxResult('error', '您没有更改任何记录！');
        }

        $service = Beans::get($this->getServiceBean());
        if ( $service->sets('ischeck', $check, $ids) ) {

            if ( $check == 1 ) {
                //新增一条系统消息提示已经审核
                $messageService = Beans::get('user.message.service');
                $items = $service->getItems($ids, 'userid, title');
                foreach ( $items as $value ) {
                    $data = array(
                        'sender' => 0,
                        'receiver' => $value['userid'],
                        'content' => '您发表的文章“'.$value['title'].'”已通过审核。',
                        'send_time' => time(),
                        'isread' => 0,
                    );
                    $messageService->add($data);
                }
            }
            AjaxResult::ajaxSuccessResult();
        } else {
            AjaxResult::ajaxFailtureResult();
        }

    }

    /**
     * 物理删除文章
     * @param HttpRequest $request
     */
    public function deletes( HttpRequest $request ) {

        $ids = $request->getParameter('ids');
        if ( count($ids) == 0 ) {
            AjaxResult::ajaxResult('error', '您没有删除任何记录！');
        }

        $service = Beans::get($this->getServiceBean());
        if ( $service->deletes($ids) ) {
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

        $aids = $request->getParameter('aids', 'urldecode|trim');

        $conditions = array('trash' => 0, 'ischeck' => 1);
        $this->setPagesize(12);
        $this->getData($conditions, $request);
        $this->setView('article/article_select');

        $__aids = explode(',', $aids);
        $this->assign('aids', $aids);
        $this->assign('__aids', $__aids);

    }

}
?>
