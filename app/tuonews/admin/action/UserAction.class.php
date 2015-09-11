<?php
namespace admin\action;

use herosphp\bean\Beans;
use herosphp\http\HttpRequest;
use herosphp\utils\AjaxResult;
use herosphp\utils\Page;

/**
 * 前台会员用户 Action
 * @author wangyanjun
 * @modify yangjian
 */
class UserAction extends CommonAction {

    /**
     * 初始化方法
     */
    public function C_start() {
        parent::C_start();
        $this->setServiceBean('user.user.service');
    }

    /**
     * 用户列表
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {

        $condi = array('ischeck' => 1);
        $this->getUserData($condi, $request);
        $this->assign('ischeck', 1);
        $this->setView('user/user_index');

    }

    /**
     * 用户已封号列表
     * @param HttpRequest $request
     */
    public function aborted( HttpRequest $request ) {

        $condi = array('ischeck' => 2);
        $this->getUserData($condi, $request);
        $this->assign('ischeck', 2);
        $this->setView('user/user_index');

    }

    /**
     * 获取用户数据
     * @param $conditions
     * @param HttpRequest $request
     */
    private function getUserData($conditions, HttpRequest $request, $order='id DESC') {

        $username = $request->getParameter('username', 'urldecode|trim');
        $startTime = $request->getParameter('start_time', 'trim');
        $endTime = $request->getParameter('end_time', 'trim');

        $condi = array();
        if ( $username != '' ) {
            $condi['username'] = "%{$username}%";
        }
        if ( $startTime != '' ) {
            $condi['add_time'] = '>='.strtotime($startTime);
        }
        if ( $endTime != '' ) {
            $condi['add_time'] = '<='.strtotime($endTime);
        }

        $condi = array_merge($conditions, $condi);
        $this->setConditions($condi);
        $this->setFields('id,username,nickname,mobile,email,add_time,ischeck');
        $this->setOrder($order);

        parent::index($request);
        $this->assign('params', $request->getParameters());

    }

    /**
     * 用户解除封号列表
     * @param HttpRequest $request
     */
    public function unaborted( HttpRequest $request ) {

        $ids = $request->getParameter('ids');
        $service = Beans::get($this->getServiceBean());

        if ( $service->sets('ischeck', 1, $ids) ) {
            AjaxResult::ajaxResult('ok', '保存成功！');
        } else {
            AjaxResult::ajaxResult('error', '保存失败！');
        }

    }

    /**
     * 快速审核
     * @param HttpRequest $request
     */
    public function quickcheck( HttpRequest $request ) {

        $ids = $request->getParameter('ids');
        $service = Beans::get($this->getServiceBean());

        if ( $service->sets('ischeck', 1, $ids) ) {
            AjaxResult::ajaxResult('ok', '保存成功！');
        } else {
            AjaxResult::ajaxResult('error', '保存失败！');
        }
    }

    /**
     * 批量封号
     * @param HttpRequest $request
     */
    public function abort( HttpRequest $request ) {

        $ids = $request->getParameter('ids');
        $service = Beans::get($this->getServiceBean());
        if ( $service->sets('ischeck', 2, $ids) ) {
            AjaxResult::ajaxResult('ok', '保存成功！');
        } else {
            AjaxResult::ajaxResult('error', '保存失败！');
        }
    }

    /**
     * 添加会员
     * @param HttpRequest $request
     */
    public function add( HttpRequest $request ) {

        $this->showMessage('danger', '该功能暂时已被屏蔽，请到前端注册会员！');
        //$this->setView('user/user_add');

    }

    /**
     * 会员编辑
     * @param HttpRequest $request
     */
    public function edit( HttpRequest $request ) {

        parent::edit($request);
        $this->setView('user/user_edit');
    }

    /**
     * 添加会员操作
     * @param HttpRequest $request
     */
    public function insert( HttpRequest $request ) {

        $data = $request->getParameter('data');
        $data['add_time'] = time();
        if ( $data['password'] == '' ) {
            $data['password'] = 'blog.fiidee.com';
        }
        $data['password'] = md5(md5($data['password']));
        parent::insert($data);
    }

    /**
     * 更新会员操作
     * @param HttpRequest $request
     */
    public function update( HttpRequest $request ) {

        $data = $request->getParameter('data');
        $password = $request->getParameter('password', 'trim');
        if ( $password != '' ) {
            $data['password'] = md5(md5($password));
        }
        parent::update($data, $request);

    }

    /**
     * @param HttpRequest $request
     * 删除操作
     */
    public function delete( HttpRequest $request){
        $id=$request->getParameter("id");
        $service = Beans::get("user.user.service");
        if($service->delete($id)){
            AjaxResult::ajaxSuccessResult();
        }else{
            AjaxResult::ajaxFailtureResult();
        }
    }

//    /**
//     * @param HttpRequest $request
//     * 批量删除
//     */
//    public function deletes(HttpRequest $request){
//        $ids = $request->getParameter('ids');
//        if ( count($ids) == 0 ) {
//            AjaxResult::ajaxResult('error', '您没有删除任何记录！');
//        }
//
//        $service = Beans::get($this->getServiceBean());
//        if ( $service->deletes($ids) ) {
//            AjaxResult::ajaxSuccessResult();
//        } else {
//            AjaxResult::ajaxFailtureResult();
//        }
//    }


      public function finance( HttpRequest $request ){
          $page = $request -> getParameter( "page", "intval" );
          if($page <= 0) $page = 1;
          $financeService = Beans::get('common.finance.service');

          $total = $financeService->count();
          $this->setPage($page);
          $this->getPageData($total);

          $items = $financeService->get(null,"*",'addtime',$this->getPage(), $this->getPagesize());

          $this->assign('items',$items);

          $this->setView('user/user_finance');
      }

    /**
     * 对数据进行分页
     * @param int 总记录数 $total
     */
    protected function getPageData($total) {

        $pageHandler = new Page($total, $this->getPagesize(), $this->getPage(), 3);
        //获取分页数据
        $pageData = $pageHandler->getPageData(DEFAULT_PAGE_STYLE);
        if (!empty($pageData)) {
            $pagemenu = '<ul class="page">';
            if ($pageData['prev'] != '#'){
                $pagemenu .= '<li class="prev"><a href="'.$pageData['prev'].'"><span class="icon icon_page_prev"><</span></a></li>';
            }
            foreach($pageData['list'] as $key => $value) {
                if( $value == '#' ) {
                    $pagemenu .= '<li class="num current">'.$key.'</li>';
                } else {
                    $pagemenu .= '<li class="num"><a href="'.$value.'">'.$key.'</a></li>';
                }
            }
            if ($pageData['next'] != '#'){
                $pagemenu .= '<li class="next"><a href="'.$pageData['next'].'"><span class="icon icon_page_next">></span></a></li>';
            }
            $pagemenu .= '</ul>';

            $this->assign('pagemenu', $pagemenu);
        }
    }

}
?>
