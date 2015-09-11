<?php
namespace user\action;

use common\action\NeedLoginAction;
use herosphp\bean\Beans;
use herosphp\core\Debug;
use herosphp\core\WebApplication;
use herosphp\http\HttpRequest;
use herosphp\utils\AjaxResult;
use herosphp\utils\Page;

/**
 * 用户中心 Action
 * @author          yangjian<yangjian102621@163.com>
 */
class UcenterAction extends NeedLoginAction {

    private $userService = null;

    private $mediaService = null;

    /**
     * 初始化方法
     */
    public function C_start() {

        parent::C_start();

        $webApp = WebApplication::getInstance();
        $request = $webApp->getHttpRequest();

        $this->userService = Beans::get('user.user.service');
        $this->mediaService = Beans::get('media.media.service');

        $currentOpt = $request->getAction().'@'.$request->getMethod();
        $this->assign("currentOpt", $currentOpt);

    }

    /**
     * 用户中心首页
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {
        $mediaManagerService = Beans::get('media.manager.service');
        $items = $mediaManagerService->getItems("userid={$this->loginUser['id']}");
        foreach($items as $value) {
            $ids[] = $value['media_id'];
        }
        $ids = implode(",", $ids);

        if ($ids) {
            $conditions['id'] = "#IN $ids";
            $medias = $this->mediaService->getItems($conditions);
            foreach ($medias as $key => $value) {
                if (!$value['domain']) {
                    $value['domain'] = url("/site_index_index/?media_id=$value[id]");
                } else {
                    $value['domain'] = 'http://' . $value['domain'];
                }
                if ($value['media_type'] == 1) {
                    $return['qunmei'][] = $value;
                } elseif ($value['media_type'] == 2) {
                    $return['zimei'][] = $value;
                } else {
                    $return['qiye'][] = $value;
                }
            }
        }
        $this->assign('medias', $return);
        $this->setView('index');
    }

    /**
     * 编辑用户资料界面
     * @param HttpRequest $request
     */
    public function profile(HttpRequest $request) {

        $this->setView('ucenter/profile');

    }

    /**
     * 更新用户信息
     * @param HttpRequest $request
     */
    public function update(HttpRequest $request) {

        $data = $request->getParameter('data');

        $UserService = Beans::get('user.user.service');
        if ( $UserService->update($data, $this->loginUser['id']) ) {

            $this->updateLoginUser($data);
            AjaxResult::ajaxSuccessResult();

        } else {
            AjaxResult::ajaxResult('error', '操作失败');
            AjaxResult::ajaxFailtureResult();
        }

    }

    /**
     * 更新已登录用户
     * @param $data 需要更新的数据
     */
    private  function updateLoginUser($data) {

        if ( is_array($data) ) {
            $user = array_merge($this->loginUser, $data);
            $userService = Beans::get('user.user.service');
            $userService->setLoginUser($user);
        }

    }

    /**
     * 重新绑定手机
     * @param HttpRequest $request
     */
    public  function bindMobile(HttpRequest $request) {

        $mobile = $request->getParameter('mobile', 'trim');
        $password = $request->getParameter('password', 'trim');
        $authcode = $request->getParameter('authcode', 'trim');

        //验证登录密码
        $userService = Beans::get('user.user.service');
        $conditions = array(
            'username' => $this->loginUser['username'],
            'password' => md5(md5($password))
        );
        if ( $userService->count($conditions) == 0 ) {
            AjaxResult::ajaxResult('error', '登录密码错误！');
        }

        //验证授权码
        $__authcode = getMobileCode($mobile, 600);
        if ( $__authcode != $authcode ) {
            AjaxResult::ajaxResult('error', '授权码错误！');
        }

        $data = array('mobile' => $mobile, 'mobile_check' => 1);
        if ( $userService->update($data, $this->loginUser['id']) ) {
            $this->updateLoginUser($data);
            AjaxResult::ajaxSuccessResult();
        } else {
            AjaxResult::ajaxFailtureResult();
        }

    }

    /**
     * 重新绑定邮箱
     * @param HttpRequest $request
     */
    public  function bindEmail(HttpRequest $request) {

        $email = $request->getParameter('email', 'trim');
        $password = $request->getParameter('password', 'trim');
        $authcode = $request->getParameter('authcode', 'trim');

        //验证登录密码
        $userService = Beans::get('user.user.service');
        $conditions = array(
            'username' => $this->loginUser['username'],
            'password' => md5(md5($password))
        );
        if ( $userService->count($conditions) == 0 ) {
            AjaxResult::ajaxResult('error', '登录密码错误！');
        }

        //验证授权码
        $__authcode = getEmailCode($email, 1800);
        if ( $__authcode != $authcode ) {
            AjaxResult::ajaxResult('error', '授权码错误！');
        }

        $data = array('email' => $email, 'email_check' => 1);
        if ( $userService->update($data, $this->loginUser['id']) ) {
            $this->updateLoginUser($data);
            AjaxResult::ajaxSuccessResult();
        } else {
            AjaxResult::ajaxFailtureResult();
        }

    }

    /**
     * 用户订阅列表
     * @param HttpRequest $request
     */
    public function subscribe(HttpRequest $request) {

        $mediaOrderService = Beans::get('media.order.service');
        $articleService = Beans::get('article.article.service');

        //查询用户订阅的媒体id
        $mediaOrderConditions = array('userid' => $this->loginUser['id']);
        $mediaFields = 'media_id';
        $medias = $mediaOrderService->getItems($mediaOrderConditions, $mediaFields);
        foreach($medias as $value) {
            $ids[] = $value['media_id'];
        }
        $ids = implode(",", $ids);

        if ( $ids ) {
            //查询订阅的文章
            $conditions = getArticleBasicConditions();
            $conditions['media_id'] = "#IN $ids";
            $order = 'add_time desc';
            $this->loadArticles($conditions, null, $order, $this->page, $this->pagesize);
            $this->getPageData($articleService->count($conditions));

        }

        $this->setView('ucenter/subscribe');
    }

    /**
     * 用户收藏列表
     * @param HttpRequest $request
     */
    public function collection(HttpRequest $request) {
        $collectService = Beans::get('user.collect.service');
        $articleService = Beans::get('article.article.service');

        //查询用户收藏的文章id
        $articleOrderConditions = array('userid' => $this->loginUser['id']);
        $articleFields = 'aid';
        $order = 'add_time DESC';
        $articles = $collectService->getItems($articleOrderConditions, $articleFields, $order, $this->page, $this->pagesize);
        foreach($articles as $value) {
            $ids[] = $value['aid'];
        }
        $ids = implode(",", $ids);


        if ( $ids ) {
            //查询订阅的文章
            $conditions = getArticleBasicConditions();
            $conditions['id'] = "#IN $ids";
            $order = 'add_time desc';
            $this->loadArticles($conditions, null, $order, $this->page, $this->pagesize);
            $this->getPageData($articleService->count($conditions));
        }

        $this->setView('ucenter/collection');
    }

    /**
     * 删除收藏
     * @param HttpRequest $request
     */
    public function delCollection(HttpRequest $request) {
        if ($request->getParameter('id', 'intval')) {
            $id = $request->getParameter('id', 'intval');

            $service = Beans::get('user.collect.service');
            $conditions['userid'] = $this->loginUser['id'];
            $conditions['aid'] = $id;
            if ($service->deletes($conditions)) {
                $this->location(url("/user_ucenter_collection"));
            } else {
                //todo
                $this->location(url("/user_ucenter_collection"));
            }
        }
    }

    /**
     * 获取多变文章内容
     * @param $having
     */
    private function loadArticles($conditions, $fields, $order, $page, $pagesize) {
        $articleService = Beans::get('article.article.service');
        $articles = $articleService->getItems($conditions, $fields, $order, $page, $pagesize);
        foreach ($articles as $key => $value) {
            $value['tags'] = explode(',', $value['tags']);
            $articles[$key]['tags'] = $value['tags'];
            foreach($value['tags'] as $v) {
                $tag[] = $v;
            }
            $chanel[] = $value['chanel_id'];
        }
        $tag = array_unique($tag);
        $chanel = array_unique($chanel);

        $tagService = Beans::get('article.tags.service');
        $tag = $tagService->getItems($tag, 'id,name');
        $chanelService = Beans::get('admin.chanel.service');
        $chanel = $chanelService->getItems($chanel, 'id, name');

        foreach($tag as $value) {
            $tags[$value['id']] = $value['name'];
        }

        foreach($chanel as $value) {
            $chanels[$value['id']] = $value[name];
        }
        $this->assign('tags', $tags);
        $this->assign('chanels', $chanels);
        $this->assign('articles', $articles);
    }

    /**
     * 用户订阅媒体列表
     * @param HttpRequest $request
     */
    public function subscribeMedia(HttpRequest $request) {
        $mediaOrderService = Beans::get('media.order.service');
        $articleTagsService = Beans::get('article.tags.order');
        $mediaService = Beans::get('media.media.service');
        $articleService = Beans::get('article.article.service');
        $tagService = Beans::get('article.tags.service');

        $mediaOrderConditions = array('userid' => $this->loginUser['id']);
        $mediaFields = 'media_id';
        $medias = $mediaOrderService->getItems($mediaOrderConditions, $mediaFields);
        foreach($medias as $value) {
            $ids[] = $value['media_id'];
        }
        $ids = implode(",", $ids);
        if($ids) {
            $medias = $mediaService->getItems(array('id' => "#IN $ids"));
            $sum = $articleService->getItems(array('media_id'=>"#IN $ids"), 'count(*) as total,media_id', null ,null ,null, 'media_id');
            foreach($medias as $value) {
                foreach ($sum as $v) {
                    if ($v[media_id] == $value[id]) {
                        $value[sum] = $v[total];
                    }
                }
                if($value[media_type] == 1) {
                    $qunmei[] = $value;
                } elseif ($value[media_type] == 2) {
                    $zimei[] = $value;
                } else {
                    $qiye[] = $value;
                }
            }
        }


        $articleTagsConditions = array('userid' => $this->loginUser['id']);
        $tagFields = 'tagid';
        $tags = $articleTagsService->getItems($articleTagsConditions, $tagFields);
        foreach ($tags as $value) {
            $tagIds[] = $value['tagid'];
        }
        $ids = implode(",", $tagIds);
        if($ids) {
            $tagConditions = array('id'=>"#IN $ids");
            $items = $tagService->getItems($tagConditions, 'id,name,intro');
        }


        $this->assign('tags', $items);
        $this->assign('qunmei', $qunmei);
        $this->assign('zimei', $zimei);
        $this->assign('qiye', $qiye);

        $this->setView('ucenter/subscribeMedia');
    }

    /**
     * 修改用户密码界面
     * @param HttpRequest $request
     */
    public function password(HttpRequest $request) {
        $this->setView('ucenter/password');
    }

    /**
     * 修改用户密码操作
     * @param HttpRequest $request
     */
    public function updatePass(HttpRequest $request) {
        $oldpass = $request->getParameter('oldpass', 'trim');
        $newpass = $request->getParameter('newpass', 'trim');
        $repass = $request->getParameter('repass', 'trim');

        if ( $newpass != $repass )
            AjaxResult::ajaxResult('error', '两次输入密码不一致');

        //检验原密码是否正确
        $oldpass = md5(md5($oldpass));
        $item = $this->userService->getItem($this->loginUser['id']);
        if ( $item['password'] != $oldpass )
            AjaxResult::ajaxResult('error', '原密码错误');

        $data = array('password' => md5(md5($newpass)));
        $success = $this->userService->update($data, $this->loginUser['id']);
        if( $success ) {
            AjaxResult::ajaxResult('success', '修改成功');
        }
    }

    /**
     * 媒体申请列表
     * @param HttpRequest $request
     */
    public function mediaApplyList(HttpRequest $request) {
        $mediaService = Beans::get('media.media.service');
        $conditions['ischeck'] = 0;
        $conditions['userid'] = $this->loginUser['id'];
        $order = 'add_time DESC';
        $items = $mediaService->getItems($conditions, null, $order);
        foreach ($items as $key => $value) {
            if ($value[media_type] == 1) {
                $items[$key][mediaType] = '群媒';
            } elseif ($value[media_type] == 2) {
                $items[$key][mediaType] = '自媒体';
            } else {
                $items[$key][mediaType] = '企业';
            }

            if ($value[ischeck] == 0) {
                $items[$key][ischeck] = '未审核';
            } elseif ($value[ischeck] == 1) {
                $items[$key][ischeck] = '审核通过';
            } else {
                $items[$key][ischeck] = '审核失败';
            }
        }
        $this->assign('items',$items);

        $this->setView('ucenter/mediaApplyList');
    }
    /**
     * 媒体申请详情页
     * @param HttpRequest $request
     */
    public function mediaApplyDetail(HttpRequest $request) {
        if ($request->getParameter('id', 'intval')) {
            $id = $request->getParameter('id', 'intval');
            $mediaService = Beans::get('media.media.service');
            $item = $mediaService->getItem($id);

            if ($item[ischeck] == 0) {
                $item[ischeck] = '未审核';
            } elseif ($item[ischeck] == 1) {
                $item[ischeck] = '审核通过';
            } else {
                $item[ischeck] = '审核失败';
            }

            if ($item[media_type] == 1) {
                $item[mediaType] = '群媒';
            } elseif ($item[media_type] == 2) {
                $item[mediaType] = '自媒体';
            } else {
                $item[mediaType] = '企业';
            }

            $this->assign('item',$item);

            $this->setView('ucenter/mediaApplyDetail');
        } else {
            page404();
        }

    }
    /**
     * 媒体申请
     * @param HttpRequest $request
     */
    public function mediaApply(HttpRequest $request) {

        $id = $request->getParameter('id', 'intval');
        $this->assign('id', $id);
        if ($id == 1) {
            $this->setView('ucenter/mediaApply');
        } elseif ($id == 2) {
            $this->setView('ucenter/self_mediaApply');
        } else {
            $this->setView('ucenter/companyApply');
        }
    }

    /**
     * 媒体添加操作
     * @param HttpRequest $request
     */
    public function mediaAdd(HttpRequest $request) {

        $data = $request->getParameter('data');

        $data['userid'] = $this->loginUser['id'];
        $data['add_time'] = time();
        $data['name'] = $data['nickname'];

        $service = Beans::get('media.media.service');

        $conditions['userid'] = $this->loginUser['id'];
        $conditions = array('userid' => $this->loginUser['id'], 'ischeck' => '#IN 0,1');
        $num = $service->count($conditions);
        if ($num > 0) {
            AjaxResult::ajaxResult('bug', '会员登记不够或您尚未开通该服务，等级功能稍后开放（或联系客服开通服务）');
        }

        if ($service->add($data)) {
            AjaxResult::ajaxSuccessResult();
        } else {
            AjaxResult::ajaxFailtureResult();
        }

    }

}
?>
