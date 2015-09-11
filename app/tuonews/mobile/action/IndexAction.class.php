<?php
namespace mobile\action;

use herosphp\bean\Beans;
use herosphp\core\Loader;
use herosphp\http\HttpRequest;
use herosphp\utils\AjaxResult;
use herosphp\utils\ArrayUtils;

Loader::import('mobile.action.CommonAction', IMPORT_APP);

/**
 * 驼牛网M站
 * @package mobile\action
 */
class IndexAction extends CommonAction {

    /**
     * 首页
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request) {
        //获取导航
        $service = Beans::get('admin.chanel.service');
        $chanels = $service->getItems('pid = 0', 'id,name', 'sort_num ASC');
        foreach ($chanels as $key => $value) {
            $chanels[$key]['url'] = url("/mobile_index_channel/?id=$value[id]");
        }
        $this->assign('chanels', $chanels);

        //获取推荐文章
        $this->getArticlePosition('index_carousel');

        //获取文章
        $conditions = getArticleBasicConditions();
        $items =  $this->getArticles($conditions, 'id,thumb,title,media_id,add_time,chanel_id');
        foreach ($items as $key => $value) {
            $items[$key]['thumb'] = getImageThumb($value['thumb'], '90x63');
        }
        $this->assign('items', $items);

        $this->setView('index/index');
    }

    /**
     * 首页获取更多
     * @param HttpRequest $request
     */
    public function indexJson( HttpRequest $request) {
        $conditions = getArticleBasicConditions();
        $items = $this->getArticles($conditions, 'id,thumb,title,media_id,add_time,chanel_id');
        foreach ($items as $key => $value) {
            $items[$key]['thumb'] = getImageThumb($value['thumb'], '90x63');
        }
        if ($items) {
            AjaxResult::ajaxResult(1, 'success', $items);
        } else {
            AjaxResult::ajaxFailtureResult();
        }
    }

    /**
     * 文章详情页
     * @param HttpRequest $request
     */
    public function detail( HttpRequest $request ) {
        $id =$request->getParameter('id', 'intval');
        if ($id < 0) page404();
        $alikeNum = 6;

        $service = Beans::get('article.article.service');
        $condition  = array(
            'id' => $id,
            'ischeck' => 1,
        );
        $item = $service->getItem($condition, 'id,title,bcontent,add_time,media_id');
        if ($item) {
            $alikeArticle = $service->getAlikeArticles($id, $alikeNum, 'id,title,thumb,media_id');
            foreach ($alikeArticle as $key => $value) {
                $mediaIds[] = $value['media_id'];
                $alikeArticle[$key]['thumb'] = getImageThumb($value['thumb'], '90x60');
            }
            //获取来源
            $mediaService = Beans::get('media.media.service');
            $medias = $mediaService->getItems($mediaIds, 'id,name');
            $medias = ArrayUtils::changeArrayKey($medias, 'id');
            foreach ($alikeArticle as $key => $value) {
                if ($value['media_id'] != 0) {
                    $alikeArticle[$key]['media'] = $medias[$value['media_id']]['name'];
                } else {
                    $alikeArticle[$key]['media'] = '驼牛网';
                }
            }
            if ($item['media_id'] == 0) {
                $item['media'] = '驼牛网';
            } else {
                $mediainfo = $mediaService->getItem($item['media_id'], 'name');
                $item['media'] = $mediainfo['name'];
            }
            $item['time'] = date('m-d H:i', $item['add_time']);
            $this->assign('item', $item);
            $this->assign('alikeArticle', $alikeArticle);
            $this->setView('index/detail');
        } else {
            page404();
        }
    }

    /**
     * 媒体列表页
     * @param HttpRequest $request
     */
    public function media( HttpRequest $request ) {
        $id = $request->getParameter('id', 'intval');
        $mediaService = Beans::get('media.media.service');
        $mediaConditions = array(
            'id' => $id,
            'ischeck' => 1
        );
        $mediaInfo = $mediaService->getItem($mediaConditions, 'id,name,logo,intro,media_type');

        if (!$mediaInfo) page404();

        $mediaTypeService = Beans::get('media.type.service');
        $mediaType = $mediaTypeService->getItems(null, 'id,name,tkey', 'sort_num ASC');
        foreach ($mediaType as $key => $value) {
            if ($mediaInfo['media_type'] == $value['id']) {
                $mediaType[$key]['current'] = 'on';
                $mediaType[$key]['url'] = '#';
                if ($value['tkey'] == 'qunmei') {
                    $mediaInfo['url'] = url("/mobile_site_index/?mediaId=$id");
                }
                 if ($value['tkey'] == 'gemei') {
                    $mediaInfo['gemei'] = 1;
                }
            } else {
                $mediaType[$key]['url'] = url("/mobile_index_medialist/?id=$value[id]");
            }
        }
        $this->assign('mediaType', $mediaType);

        //获取文章
        $conditions = getArticleBasicConditions();
        $conditions['media_id'] = $mediaInfo['id'];
        $items =  $this->getArticles($conditions, 'id,thumb,title,media_id,add_time,chanel_id');
        foreach ($items as $key => $value) {
            $items[$key]['thumb'] = getImageThumb($value['thumb'], '90x63');
        }

        $mediaInfo['logo'] = getImageThumb($mediaInfo['logo'], '218x128');
        $this->assign('id', $id);
        $this->assign('items', $items);
        $this->assign('mediaInfo', $mediaInfo);


        $this->setView('index/media');
    }

    public function mediaJson( HttpRequest $request) {
        $id = $request->getParameter('id');
        $mediaService = Beans::get('media.media.service');
        $mediaConditions = array(
            'id' => $id,
            'ischeck' => 1
        );
        $mediaInfo = $mediaService->getItem($mediaConditions, 'id');
        if (!$mediaInfo) AjaxResult::ajaxFailtureResult();
        $conditions = getArticleBasicConditions();
        $conditions['media_id'] = $mediaInfo['id'];
        $items = $this->getArticles($conditions, 'id,thumb,title,media_id,add_time,chanel_id');
        foreach ($items as $key => $value) {
            $items[$key]['thumb'] = getImageThumb($value['thumb'], '90x63');
        }
        if ($items) {
            AjaxResult::ajaxResult(1, 'success', $items);
        } else {
            AjaxResult::ajaxFailtureResult();
        }
    }


    /**
     * 频道页
     * @param HttpRequest $request
     */
    public function channel( HttpRequest $request ) {

        $id = $request->getParameter('id', 'intval');
        $sid = $request->getParameter('sid', 'intval');
        if ($id < 0 || $sid < 0) page404();

        $chanelService = Beans::get('admin.chanel.service');
        //获取一级频道
        $levelOne = $chanelService->getItems('pid=0', 'id,name', 'sort_num ASC');
        foreach ($levelOne as $key => $value) {
            if ($value['id'] == $id) {
                $levelOne[$key]['current'] = 'on';
            }
            $levelOne[$key]['url'] = url("/mobile_index_channel/?id=$value[id]");
        }
        $this->assign('levelOne', $levelOne);
        //获取二级频道
        $levelTwo = $chanelService->getItems("pid=$id", 'id,name', 'sort_num ASC');
        foreach ($levelTwo as $key => $value) {
            if ($value['id'] == $sid) {
                $levelTwo[$key]['current'] = 'on';
            }
            $levelTwo[$key]['url'] = url("/mobile_index_channel/?id=$id&sid=$value[id]");
            $ids[] = $value['id'];
        }
        array_unshift($levelTwo, array(
            'name' => '全部',
            'url' => url("/mobile_index_channel/?id=$id"),
            'current' => $sid ? '' : 'on',
        ));
        $this->assign('levelTwo', $levelTwo);

        $ids = implode(',', $ids);
        $conditions = getArticleBasicConditions();
        if ($ids) {
            $conditions['chanel_id'] = $sid ? $sid : "#IN $ids";
            $items = $this->getArticles($conditions, 'id,chanel_id,media_id,title,bcontent,add_time,thumb');
            foreach ($items as $key => $value) {
                if ($value['thumb'] == '') {
                    $items[$key]['thumb'] = '/res/global/images/reception/mobile_default_647.jpg';
                }
            }
            $this->assign('items', $items);
        }
        $this->assign('id', $id);
        $this->assign('sid', $sid);
        $this->setView('index/channel');
    }

    /**
     * 频道页获取更多
     * @param HttpRequest $request
     */
    public function chanelJson( HttpRequest $request) {
        //获取所有子频道
        $id = $request->getParameter('id', 'intval');
        $sid = $request->getParameter('sid', 'intval');
        $chanelService = Beans::get('admin.chanel.service');

        if (!$sid) {
            $chanelsId = $chanelService->getItems("pid=$id", 'id');
            if ($chanelsId) {
                foreach ($chanelsId as $value) {
                    $ids[] = $value['id'];
                }
            }
        }

        $ids = implode(',', $ids);
        $conditions = getArticleBasicConditions();
        $conditions['chanel_id'] = $sid ? $sid : "#IN $ids";
        $items = $this->getArticles($conditions, 'id,chanel_id,media_id,title,bcontent,add_time,thumb');
        foreach ($items as $key => $value) {
            if ($value['thumb'] == '') {
                $items[$key]['thumb'] = '/res/global/images/reception/mobile_default_647.jpg';
            }
        }
        if ($items) {
            AjaxResult::ajaxResult(1, 'success', $items);
        } else {
            AjaxResult::ajaxFailtureResult();
        }
    }


    /**
     * 媒体新闻列表页
     * @param HttpRequest $request
     */
    public function medialist( HttpRequest $request ) {
        $mediaTypeId = $request->getParameter('id', 'intval');
        $mediaTypeService = Beans::get('media.type.service');
        $mediaService = Beans::get('media.media.service');

        if ($this->getPage() == 1) {

            $mediaType = $mediaTypeService->getItems(null, 'id,name,tkey', 'sort_num ASC');
            foreach ($mediaType as $key => $value) {
                if ( ($mediaTypeId < 0 || empty($mediaTypeId)) && $value['tkey'] == 'qunmei') {
                    $mediaTypeId = $value['id'];
                }
                if ($value['id'] == $mediaTypeId) {
                    $mediaType[$key]['current'] = 'on';
                    if ($value['tkey'] == 'qunmei') {
                        $this->assign('css', 1);
                    }
                }
                $mediaType[$key]['url'] = url("/mobile_index_medialist/?id=$value[id]");
            }

            $this->assign('mediaType', $mediaType);


            $conditions = array(
                'media_type' => $mediaTypeId
            );
            $items = $mediaService->getItems($conditions, 'id,name,logo,intro', 'add_time DESC', $this->getPage(), $this->getPagesize());
            foreach ($items as $key => $value) {
                $items[$key][url] = url("/mobile_index_media/?id=$value[id]");
                if ($value['logo'] == '') {
                    $items[$key]['logo'] = '/res/global/images/reception/mobile_default_180.jpg';
                }
            }
            $this->assign('items', $items);
            $this->assign('id', $mediaTypeId);

            $this->setView('index/medialist');

        } else {
            $conditions = array(
                'media_type' => $mediaTypeId
            );
            $items = $mediaService->getItems($conditions, 'id,name,logo,intro', 'add_time DESC', $this->getPage(), $this->getPagesize());
            foreach ($items as $key => $value) {
                $items[$key][url] = url("/mobile_index_media/?id=$value[id]");
                if ($value['logo'] == '') {
                    $items[$key]['logo'] = '/res/global/images/reception/mobile_default_180.jpg';
                }
            }
            if ($items) {
                AjaxResult::ajaxResult(1, 'success', $items);
            } else {
                AjaxResult::ajaxResult(0, 'error');
            }
        }
    }

    /**
     * 获取文章内容
     * @param $conditions
     * @param $fields
     * @param $order
     * @param $page
     * @param $pagesize
     * @param $group
     * @param $having
     * @return array
     */
    protected function getArticles($conditions, $fields) {
        $service = Beans::get('article.article.service');
        $items = $service->getItems($conditions, $fields, $this->getOrder(), $this->getPage(), $this->getPagesize());

        foreach ($items as $value) {
            $chanels[] = $value['chanel_id'];
            $medias[] = $value['media_id'];
        }
        $chanels = array_unique($chanels);
        $medias = array_unique($medias);
        $chanelService = Beans::get('admin.chanel.service');
        $chanel = $chanelService->getItems($chanel, 'id, name');
        $mediaService = Beans::get('media.media.service');
        $medias = $mediaService->getItems($medias,'id,name');
        foreach ($chanel as $value) {
            $chanels[$value['id']] = $value['name'];
        }
        foreach ($medias as $value) {
            $medias[$value['id']] = $value['name'];
        }

        foreach ($items as $key => $value) {
            $items[$key]['chanel'] = $chanels[$value['chanel_id']];
            if ($value['media_id'] == 0) {
                $items[$key]['media'] = '驼牛网';
                $items[$key]['media_url'] = '#';
            } else {
                $items[$key]['media'] = $medias[$value['media_id']];
                $items[$key]['media_url'] = url("/mobile_index_media/?id=$value[media_id]");
            }


            $items[$key]['url'] = url("/mobile_index_detail/?id=$value[id]");
            $items[$key]['time'] = date("m-d H:i", $value['add_time']);
        }
        return $items;
    }

    /**
     * 获取推荐位文章
     * @param string $position  文章推荐位key
     */
    public function getArticlePosition($position = null) {
        if (!$position) page404();
        $articlePositionService =Beans::get('article.rec.service');
        $conditions['position'] = $position;
        $articlePosition = $articlePositionService->getItem($conditions);
        $articleService = Beans::get('article.article.service');
        if (!empty($articlePosition['aids'])) {
            $articleConditions = array('id'=>"#IN $articlePosition[aids]");
            $indexPosition = $articleService->getItems($articleConditions, 'id,title,thumb', 'id desc', 1, 1);
            $indexPosition = $indexPosition[0];
            $indexPosition['url'] = url("/mobile_index_detail/?id=$indexPosition[id]");
            $indexPosition['thumb'] = getImageThumb($indexPosition['thumb'], '653x366');
            $this->assign('indexPosition', $indexPosition);
        }
    }
}
?>
