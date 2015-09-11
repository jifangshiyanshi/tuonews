<?php
namespace common\action;

use herosphp\bean\Beans;
use herosphp\cache\CacheFactory;
use herosphp\http\HttpRequest;
use herosphp\utils\AjaxResult;
use herosphp\utils\ArrayUtils;

/**
 * Index Action
 * @author          yangjian<yangjian102621@163.com>
 */
class IndexAction extends CommonAction {

    /**
     * 初始化方法
     */
    public function C_start() {

        parent::C_start();
        //获取友情链接
        $friendLinkService = Beans::get('admin.friendlink.service');
        $friendLinks = $friendLinkService->getFootLinks(40);
        $this->assign('friendLinks', $friendLinks);

        //获取底部导航
        $artoneService = Beans::get('artone.artone.service');
        $footNavis = $artoneService->getFootNavis(6, 'site_bottom', 'sort_num ASC');
        $this->assign('footNavis', $footNavis);

    }

    /**
     * 首页
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {

        $articleService = Beans::get('article.article.service');
        $mediaService = Beans::get('media.media.service');
        $tagService = Beans::get('article.tags.service');
        //获取文章
        $condi = getArticleBasicConditions();
        $fileds = 'id,title,tags,bcontent,chanel_id,media_id,thumb,add_time';
        $items = $articleService->getItems($condi, $fileds, 'add_time DESC', 1, 20);
        //配置缓存
        $cacheInfo = array(
            'baseKey' => '__common',
            'ftype' => 'ajax',
            'factor' => 1,
            'expr' => 300
        );
        $articles = &$this->loadArticleInfo($items, ART_INFO_DEFAULT, $cacheInfo);
        $this->assign('items', $articles);


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

        //首页焦点图
        $indexCarousel = $articleService->getIndexCarousel(4);
        $this->assign('indexRecommend', $indexCarousel);

        //注册seo信息
        $appConfigs = $this->getTemplateVar('appConfigs');
        $this->assign('seoTitle', $appConfigs['site_title']);
        $this->assign('seoKwords', $appConfigs['site_keywords']);
        $this->assign('seoDesc', $appConfigs['site_desc']);

        $this->setView('index');
    }


    /**
     * 金融服务报名
     * @param HttpRequest $request
     */
    public function financeApply( HttpRequest $request ){
        $name = $request -> getParameter( "name", "trim" );
        $mobile = $request -> getParameter( "mobile", "trim" );

        if( !$name || !$mobile ){
            AjaxResult::ajaxResult("0","error",array("msg"=>"姓名和电话不能为空","msgcode"=>"3"));
        }

        $data['name'] = $name;
        $data['mobile'] = $mobile;
        $data['addtime'] = time();


        $financeService = Beans::get('common.finance.service');
        $res = $financeService -> get(array("mobile"=>$mobile));

        if($res) AjaxResult::ajaxResult("0","error",array("msg"=>"此号码已经报名了","msgcode"=>'3'));
        if( $financeService -> add( $data ) ){
            AjaxResult::ajaxResult('1','success',array('msg'=>'您已提交成功！客服将在1-3个工作日内给予回复','msgcode'=>'1'));
        }else{
            AjaxResult::ajaxResult('0','error',array('msg'=>'操作失败','msgcode'=>'2'));
        }

    }

}
?>
