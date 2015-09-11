<?php
namespace article\action;

use herosphp\bean\Beans;
use herosphp\cache\CacheFactory;
use herosphp\core\Loader;
use herosphp\http\HttpRequest;
use herosphp\utils\AjaxResult;

Loader::import('article.action.ArticleCommonAction', IMPORT_APP);

/**
 * 资讯文章 Action
 * @author          yangjian<yangjian102621@163.com>
 */
class ArticleAction extends ArticleCommonAction {

    /**
     * 频道页文章列表
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {

        $page = $request->getParameter('page', 'intval');
        $id = $request->getParameter('id','intval');

        if ( $id <= 0 ) page404();

        $chanelService = Beans::get('admin.chanel.service');
        $articleService = Beans::get('article.article.service');
        $mediaService = Beans::get('media.media.service');
        $tagService = Beans::get('article.tags.service');

        $condi = array();
        $baseCondi = getArticleBasicConditions();
        //获取所有子频道
        $chanels = $chanelService->getItems("pid={$id}", "id", "sort_num ASC");
        //获取频道信息
        $item = $chanelService->getItem($id, 'seo_title, seo_desc, seo_kword');
        $chanelIds = array($id);
        if( $chanels ) {
            foreach ( $chanels as $value ) {
                $chanelIds[] = $value['id'];
            }
        }
        $chanelIds = implode(',', $chanelIds);
        $condi['chanel_id'] = '#IN '.$chanelIds;
        if ( empty($condi) ) {
            $condi = $baseCondi;
        } else {
            $condi = array_merge($condi, $baseCondi);
        }
        //获取分页
        $total = $articleService->count($condi);
        $this->setPage($page);
        $this->getPageData($total);

        //获取文章
        $items = $articleService->getItems($condi, 'id,title,thumb,add_time,chanel_id, tags,media_id,bcontent',
            'add_time DESC', $this->getPage(), $this->getPagesize());

        $cacheInfo = array(
            'baseKey' => 'article',
            'ftype' => 'list',
            'factor' => $id.'-'.$page
        );
        $aricles = &$this->loadArticleInfo($items, ART_INFO_DEFAULT, $cacheInfo);
        $this->assign('items', $aricles);

        //获取热点排行文章
        $hotRanks = $articleService->getHotRank(10, 'id,title');
        $this->assign('hotRanks', $hotRanks);

        //获取周排行
        $weekRanks = $articleService->getWeekRank(10, 'id,title');
        $this->assign('weekRanks', $weekRanks);

        //获取编辑推荐的文章
        $editorRec = $articleService->getEditorRecommend(10);
        $this->assign('editorRec', $editorRec);

        //获取推荐媒体信息
        $niulanMedia = $mediaService->getRecommendMedia(4, 'niulan');
        $this->assign('niulanMedia', $niulanMedia);
        //驼牛联盟
        $tnlm = $mediaService->getRecommendMedia(8, 'tuoniulianmeng');
        $this->assign('tnlm', $tnlm);

        //获取热门标签
        $hotTags = $tagService->getHotTags(12);
        $this->assign('hotTags', $hotTags);

        //注册页面seo信息
        $this->assign('seoTitle', $item['seo_title'].' - 驼牛网');
        $this->assign('seoKwords', $item['seo_kword']);
        $this->assign('seoDesc', $item['seo_desc']);

        $this->setView('article_index');
    }

    /**
     * 文章详情页面
     * @param HttpRequest $request
     */
    public function detail(HttpRequest $request)
    {

        $id = $request->getParameter('id', 'intval');
        if ($id <= 0) page404();

        //获取文章信息
        $condi = getArticleBasicConditions();
        $condi['id'] = $id;
        $articleService = Beans::get('article.article.service');
        $item = $articleService->getItem($condi, "id,title, chanel_id, media_id, bcontent,tags, zan_times, kwords, add_time");
        if (!$item) page404();
        //更新点击率
        $articleService->increase('hits', 1, $id);

        //获取频道,标签和媒体宿主
        $chanelService = Beans::get('admin.chanel.service');
        $tagService = Beans::get('article.tags.service');
        $mediaService = Beans::get('media.media.service');
        $userService = Beans::get('user.user.service');

        if ($item['tags'] != '') {
            $item['tags'] = $tagService->getItems("id in({$item['tags']}) AND name != ''", 'id,name');
        }
        if ($item['media_id'] > 0) {
            $media = $mediaService->getItem($item['media_id'], 'name');
            $item['media'] = $media['name'];
        } else {
            $item['media'] = '驼牛网';
        }
        if ($item['chanel_id'] > 0) {
            $chanel = $chanelService->getItem($item['chanel_id'], 'id, name');
            $item['chanel'] = $chanel['name'];
        }

        //获取热点排行文章
        $hotRanks = $articleService->getHotRank(10, 'id,title');
        $this->assign('hotRanks', $hotRanks);

        //获取周排行
        $weekRanks = $articleService->getWeekRank(10, 'id,title');
        $this->assign('weekRanks', $weekRanks);

        //获取编辑推荐的文章
        $editorRec = $articleService->getEditorRecommend(10);
        $this->assign('editorRec', $editorRec);

        //获取推荐媒体信息
        $niulanMedia = $mediaService->getRecommendMedia(4, 'niulan');
        $this->assign('niulanMedia', $niulanMedia);

        //获取热门标签
        $hotTags = $tagService->getHotTags(12);
        $this->assign('hotTags', $hotTags);

        //获取相关文章
        $alikeArticles = $articleService->getAlikeArticles($item['id'], 4);
        $this->assign('alikeArticles', $alikeArticles);


        //--获取文章评论
        $commentService = Beans::get('article.service.comment');
        $commentList = $commentService->getComment($id);

        //以id为键
        $pidList = array();
        foreach ($commentList as $val) {
            array_push($pidList, $val['pid']);
        }
        //获取各个评论的上一级

        $preComment = array();
        if ($pidList) {
            $preComment = $commentService->getCommentsById($pidList);
        }
        $commentList = array_merge( $commentList, $preComment );

        $temp = array();
        foreach($commentList as $val ){
            $temp[$val['id']] = $val;
        }
        $this->assign('commentList',$temp);
        $this->assign( 'aid', $id );



       //获取评论的用户
        $userlist = array();
        if($commentList){
            foreach($commentList as $key => $val ){
                array_push($userlist,$val['uid']);
            }
        }
        $userlist = array_unique( $userlist );

        //获取评论的用户信息
        $userlist = $userService -> getUsers( $userlist );
       //变成以用户id为键的 数组
        $users = array();
        foreach( $userlist as  $val ) {
            $users[$val['id']] = $val;
        }
       $this->assign( 'users', $users );




        //获取媒体信息
        $imageClass = 'logo';
        $circleClass = '';
        if ( $item['media_id'] > 0 ) {
            $mediaInfo = $mediaService->getItem($item['media_id'], "id, name, media_type,nickname, logo, intro");
            $condi = getArticleBasicConditions();
            $condi['media_id'] = $item['media_id'];
            $mediaArticles = $articleService->getItems($condi, "id, title", 'id DESC' ,1 ,4);
            $this->assign('mediaArticles', $mediaArticles);

            //判断媒体类型
            $mediaTypeService = Beans::get('media.type.service');
            $type = $mediaTypeService->getItem($mediaInfo['media_type'], 'tkey');
            if($type['tkey'] != 'qunmei') {
                $imageClass = 'face';
                $circleClass = 'aside_publish_user';
            }
        }

        $this->assign('imageClass', $imageClass);
        $this->assign('circleClass', $circleClass);

        $loginUser = $userService->getLoginUser();

        //判断是否已收藏
        if ( $loginUser ) {

            $collectService = Beans::get('user.collect.service');
            $collectCondi = array(
                'userid' => $this->loginUser['id'],
                'aid' => $item['id']
            );
            if( $collectService->count($collectCondi) > 0 ) {
                $item['collection'] = 1;
            } else {
                $item['collection'] = 0;
            }
        }

        //判断是否已被点赞
        if ( $loginUser ) {
            $CACHER = CacheFactory::create('file');
            $key = md5($loginUser['id'].$id);
            $item['zan'] = $CACHER->get($key);
        } else {
            $item['zan'] = 0;
        }

        $this->assign('item', $item);
        $this->assign('mediaInfo', $mediaInfo);
        $this->setView('article_detail');

        //注册页面seo信息
        $this->assign('seoTitle', $item['title'].' - 驼牛网');
        //如果没有关键字，则使用标签
        if ( !$item['kwords'] ) {
            foreach( $item['tags'] as $value ) {
                $item['kwords'] .= $value['name'].',';
            }
        }
        $this->assign('seoKwords', $item['kwords']);
        $this->assign('seoDesc', $item['bcontent']);


    }

    /**
     * 首页获取更多
     * @param HttpRequest $request
     */
    public function ajaxArticle( HttpRequest $request ) {

        $page = $request->getParameter('page', 'intval');
        $pagesize = $request->getParameter('pagesize', 'intval');
        if ( $page <= 0 ) $page = $this->page;

        if ( $pagesize <= 0 ) $pagesize = 20;

        $articleService = Beans::get('article.article.service');
        $condi = getArticleBasicConditions();
        $items = $articleService->getItems($condi, 'id,chanel_id,title,kwords,bcontent,tags,media_id,add_time,thumb',
            'id DESC', $page, $pagesize);

        $cacheInfo = array(
            'baseKey' => '__common',
            'ftype' => 'ajax',
            'factor' => $page,
            'expr' => 300
        );
        $articles = &$this->loadArticleInfo($items, ART_INFO_DEFAULT, $cacheInfo);
        foreach ($articles as $key => $value) {
            $articles[$key]['add_time'] = date('m-d H:i', $value['add_time']);
        }
        AjaxResult::ajaxResult('1', 'success', $articles);
    }

    /**
     * 收藏文章
     * @param HttpRequest $request
     */
    public function collection( HttpRequest $request ) {

        $id = $request->getParameter('id', 'intval');
        if ( $id <= 0 ) {
            AjaxResult::ajaxFailtureResult();
        }

        $collectService = Beans::get('user.collect.service');
        $userService = Beans::get('user.user.service');
        $articleService = Beans::get('article.article.service');
        $loginUser = $userService->getLoginUser();

        if( $loginUser ) {

            $condi = array('userid' => $loginUser['id'], 'aid' => $id);
            if ( $collectService->count($condi) > 0 ) {
                AjaxResult::ajaxResult(1, 'on');
            }
            $data['userid'] = $loginUser['id'];
            $data['aid'] = $id;
            $data['add_time'] = time();
            if ( $collectService->add($data) ) {

                $articleService->increase('collect_times', 1, $id);
                AjaxResult::ajaxResult(1, 'on');

            } else {
                AjaxResult::ajaxResult(0, 'error');
            }

        } else {
            AjaxResult::ajaxResult(0, 'login');
        }
    }

    /**
     * 取消收藏文章
     * @param HttpRequest $request
     */
    public function uncollection(HttpRequest $request){

        $id = $request->getParameter('id', 'intval');
        if ( $id <= 0 ) {
            AjaxResult::ajaxFailtureResult();
        }

        $collectService = Beans::get('user.collect.service');
        $userService = Beans::get('user.user.service');
        $articleService = Beans::get('article.article.service');
        $loginUser = $userService->getLoginUser();

        if( $loginUser ) {

            $condi = array('userid' => $loginUser['id'], 'aid' => $id);
            if ( $collectService->count($condi) == 0 ) {
                AjaxResult::ajaxResult(1, 'off');
            }

            if ( $collectService->deletes($condi) ) {

                $articleService->reduce('collect_times', 1, $id);
                AjaxResult::ajaxResult(1, 'off');

            } else {
                AjaxResult::ajaxResult(0, 'error');
            }
        } else {
            AjaxResult::ajaxResult(0, 'login');
        }
    }

    /**
     * 点赞文章
     * @param HttpRequest $request
     */
    public function zan( HttpRequest $request ) {  

        $id = $request->getParameter('id', 'intval');
        if ( $id <= 0 ) {
            AjaxResult::ajaxFailtureResult();
        }
        $userService = Beans::get('user.user.service');
        $articleService = Beans::get('article.article.service');
        $loginUser = $userService->getLoginUser();

        if( $loginUser ) {
            if ( $articleService->increase('zan_times', 1, $id) ) {
                $CACHER = CacheFactory::create('file');
                $key = md5($loginUser['id'].$id);
                $CACHER->set($key, 1);
                AjaxResult::ajaxResult(1, 'success');
            } else {
                AjaxResult::ajaxResult(0, 'error');
            }
        } else {
            AjaxResult::ajaxResult(0, 'login');
        }
    }

    /**
     * 自动获取标签
     * @param HttpRequest $request
     */
    public function fetchTags(HttpRequest $request) {

        $data = $request->getParameter('data', 'trim');
        Loader::import('extend.word.WordSplit', IMPORT_CUSTOM);
        $words = \WordSplit::split($data);
        if ( !empty($words) ) {
            AjaxResult::ajaxResult('ok', implode(',', $words));
        } else {
            AjaxResult::ajaxFailtureResult();
        }
    }


    /**
     * 详情页评论
     * @param HttpRequest $request
     */
    public function ajaxComment( HttpRequest $request ){
       
        $commentLenMin = 2;
        $commentLenMax = 300;
        $data = $request -> getParameter('data','trim');//评论内容
        $pid = $request->getParameter('pid','intval');
        $aid = $request->getParameter('aid','intval');


        $len = strlen($data);
        if(! ($len> $commentLenMin  && $len < $commentLenMax )){
            AjaxResult::ajaxResult('0','error',array('msgcode'=>'1','msg'=>'字数不符合 要求：大于'.$commentLenMin.' 小于'.$commentLenMax));
        }


        $userService = Beans::get('user.user.service');
        $loginUser = $userService->getLoginUser();
        if(!$loginUser){
            AjaxResult::ajaxResult('0','error',array('msgcode'=>'2','msg'=>'用户没有登录'));
        }
        $uid = $loginUser['id'];


        //获取评论内容 用户的id
        //确定好pid 和 id
        $data = array('aid'=>$aid,'uid'=>$uid,'pid'=>$pid,'comment'=>$data,'createtime'=>time());
        $commentService = Beans::get('article.service.comment');
        if($insertId = $commentService -> insertComment($data)){
            //当前条目
            $data['id'] = $insertId;
            $data['createtime'] = date('Y-d-m H:i',$data['createtime']);
            $users = array( $uid );

            //查找上一条
            $preComment = $commentService -> getCommentById($data['pid']);
            if( $preComment ){
                array_push($users, $preComment['uid']);
            }

            $users = array_unique( $users );

            //查找用户信息  以id为键
            $usersTmp = $userService ->getUsers($users);
            foreach( $usersTmp as $val ){
                $users[$val['id']] = $val;
            }

            $requestData = array('commentList'=>array(
                'cur'=>array(
                    $data
                ),
                'pre'=>array(
                    $preComment
                )),

                'users'=>$users
                );

            if(!$preComment){
                $requestData['commentList']['pre'] = 0;
            }


            AjaxResult::ajaxResult( '1','success',$requestData );  //返回信息 格式array('commentList'=>array('cur'=>'','pre'=>array()), 'users'=>array();) 如果是第一次回复 pre就是空
        }else{
            AjaxResult::ajaxResult('0','error',array('msgcode'=>'3','msg'=>'提交失败'));
        }

    }


    /**
     * 获取更多详情页评论
     * @param HttpRequest $request
     */
    public function ajaxCommentMore( HttpRequest $request ){
        $page = $request->getParameter( 'curpage', 'intval' );
        $aid = $request->getParameter( 'aid', 'intval' );
        $page++;
        $commentService = Beans::get('article.service.comment');

        //第一级评论
        $firstLevelcommentList = $commentService -> getComment( $aid , $page );
        if(!$firstLevelcommentList){
            AjaxResult::ajaxResult('0','error',array('msg'=>'没有了','msgcode'=>'1'));
        }

        $pidList = array();
        foreach( $firstLevelcommentList as $val ){
            array_push( $pidList, $val['pid'] );
        }


        //上一级评论
        $secondLevelCommentList = $commentService -> getCommentsById( $pidList );



        $users = array();
        $firstLevel = array();//以评论id为键
        $secondLevel = array();

        foreach( $firstLevelcommentList as $val ){
            array_push( $users, $val['uid'] );
            $firstLevel[$val['id']] = $val;
        }
        foreach( $secondLevelCommentList as $val ){
            array_push( $users, $val['uid']);
            $secondLevel[$val['id']] = $val;
        }


        $users = array_unique($users);



        $userService = Beans::get('user.user.service');
        $usersTmp = $userService ->getUsers($users);
        foreach( $usersTmp as $val ){
            $users[$val['id']] = $val;
        }

        $requestData = array(
            "firstLevel" => $firstLevel,
            "secondLevel" => $secondLevel,
            "users" => $users
        );

        AjaxResult::ajaxResult( '1', 'success', $requestData );

    }
}
?>
