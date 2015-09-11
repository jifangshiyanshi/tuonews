<?php
namespace mobile\action;

use herosphp\bean\Beans;
use herosphp\core\Loader;
use herosphp\core\WebApplication;
use herosphp\http\HttpRequest;
use herosphp\utils\AjaxResult;
use herosphp\utils\ArrayUtils;

Loader::import('mobile.action.CommonAction', IMPORT_APP);

class SiteAction extends CommonAction {

    private $mediaId = null;

    public function C_start() {
        parent::C_start();
        $webApp = WebApplication::getInstance();
        $request = $webApp->getHttpRequest();
        $this->mediaId = $request->getParameter('mediaId', 'intval');
        if (!$this->mediaId) page404();

        $chanelService = Beans::get('media.chanel.service');
        $chanel = $chanelService->getItems("media_id=$this->mediaId", 'id,name');
        $this->assign('chanel', $chanel);

        $mediaService = Beans::get("media.media.service");
        $mediaInfo = $mediaService->getItem($this->mediaId, 'id,name,logo');
        $mediaInfo['logo'] = getImageThumb($mediaInfo['logo'], '177x98');
        $this->assign('mediaInfo', $mediaInfo);

        $footer['pcUrl'] = url("/site_index_index/?media_id=$this->mediaId");
        $footer['mobileUrl'] = url("/mobile_site_index/?mediaId=$this->mediaId");
        $this->assign('footer', $footer);
    }

    public function index( HttpRequest $request) {

        //获取轮播图的文章
        $mediaService = Beans::get('media.media.service');
        $carousel = $mediaService->getMediaCarousel(5, $this->mediaId);
        foreach ( $carousel as $key => $value ) {
            $carousel[$key]['url'] =  url("/mobile_site_detail/?mediaId=$this->mediaId&id=$value[id]");
        }
        $this->assign('carousel', $carousel);

        $conditions = array(
            'media_id' => $this->mediaId,
        );
        $this->setOrder('sort_num DESC, id DESC');
        $items =  $this->getArticles($conditions, 'id,thumb,title,media_id,add_time,chanel_id,bcontent');
        $this->assign('items', $items);

        $this->setView('site/index');
    }

    public function indexJson ( HttpRequest $request) {
        $conditions = array(
            'media_id' => $this->mediaId,
        );
        $this->setOrder('sort_num DESC, id DESC');
        $items =  $this->getArticles($conditions, 'id,thumb,title,media_id,add_time,chanel_id,bcontent');
        foreach ($items as $key => $value) {
            $items[$key]['thumb'] = getImageThumb($value['thumb'], '90x63');
        }
        if ($items) {
            AjaxResult::ajaxResult(1, 'success', $items);
        } else {
            AjaxResult::ajaxFailtureResult();
        }
    }

    public function chanel( HttpRequest $request) {
        $id = $request->getParameter('id', 'intval');
        if ($id < 0) page404();

        $chanelService = Beans::get('media.chanel.service');
        $chanel = $chanelService->getItem($id, 'id,name');
        $this->assign('title', $chanel);
        $conditions = array(
            'media_chanel' => $id,
            'media_id' => $this->mediaId,
        );
        $items =  $this->getArticles($conditions, 'id,thumb,title,media_id,add_time,chanel_id,bcontent');
        foreach ($items as $key => $value) {
            $items[$key]['thumb'] = getImageThumb($value['thumb'], '90x63');
        }
        $this->assign('items', $items);
        $this->assign('id', $id);
        $this->setView('site/chanel');
    }

    public function chanelJson( HttpRequest $request) {
        $id = $request->getParameter('id', 'intval');
        if ($id < 0) AjaxResult::ajaxFailtureResult();
        $conditions = array(
            'media_chanel' => $id,
            'media_id' => $this->mediaId,
        );
        $items =  $this->getArticles($conditions, 'id,thumb,title,media_id,add_time,chanel_id,bcontent');
        foreach ($items as $key => $value) {
            $items[$key]['thumb'] = getImageThumb($value['thumb'], '90x63');
        }
        if ($items) {
            AjaxResult::ajaxResult(1, 'success', $items);
        } else {
            AjaxResult::ajaxFailtureResult();
        }
    }

    public function detail( HttpRequest $request) {
        $id = $request->getParameter('id', 'intval');
        $service=Beans::get("article.article.service");
        $conditions = array(
            'id' => $id,
        );
        $item = $service->getItem($conditions, 'id,title,bcontent,add_time,media_id');
        if ($item) {
            $condi = array(
                'media_id' => $this->mediaId,
            );
            $alikeArticle = $service->getItems($condi, 'id,title,thumb,add_time,media_id', 'id DESC', 1, 6);
            foreach ($alikeArticle as $value) {
                $mediaIds[] = $value['media_id'];
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
                $alikeArticle[$key]['url'] = url("/mobile_site_detail/?mediaId=$this->mediaId&id=$value[id]");
                $alikeArticle[$key]['thumb'] = getImageThumb($value['thumb'], '90x63');
            }
            $mediainfo = $mediaService->getItem($item['media_id'], 'name');
            $item['media'] = $mediainfo['name'];
            $item['time'] = date('m-d H:i', $item['add_time']);
            $this->assign('article', $item);
            $this->assign('alikeArticle', $alikeArticle);
            $this->setView('site/detail');
        } else {
            page404();
        }
    }

    public function m2Index( HttpRequest $request) {
        $conditions = array(
            'media_id' => $this->mediaId,
        );
        $items =  $this->getArticles($conditions, 'id,thumb,title,media_id,add_time,chanel_id,bcontent');
        $this->assign('items', $items);

        $this->setView('site/m2Index');
    }

    public function m2Chanel( HttpRequest $request) {
        $id = $request->getParameter('id', 'intval');
        if ($id < 0) page404();

        $chanelService = Beans::get('media.chanel.service');
        $chanel = $chanelService->getItem($id, 'id,name');
        $this->assign('title', $chanel);
        $conditions = array(
            'media_chanel' => $id,
            'media_id' => $this->mediaId,
        );
        $items =  $this->getArticles($conditions, 'id,thumb,title,media_id,add_time,bcontent,chanel_id');

        $this->assign('items', $items);
        $this->assign('id', $id);

        $this->setView('site/m2Chanel');
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
            $items[$key]['url'] = url("/mobile_site_detail/?mediaId=$this->mediaId&id=$value[id]");
            $items[$key]['time'] = date("m-d H:i", $value['add_time']);

        }
        return $items;
    }
}
