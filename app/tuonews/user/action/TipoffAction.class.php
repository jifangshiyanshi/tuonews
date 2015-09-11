<?php
namespace user\action;

use common\action\NeedLoginAction;
use herosphp\bean\Beans;
use herosphp\core\WebApplication;
use herosphp\http\HttpRequest;
use herosphp\utils\AjaxResult;

/**
 * 用户爆料 Action
 * @author          yangjian<yangjian102621@163.com>
 */
class TipoffAction extends NeedLoginAction {

    private $tipoffService = null;

    protected $page = 1;

    protected $pagesize = 20;


    public function C_start() {
        parent::C_start();

        $webApp = WebApplication::getInstance();
        $request = $webApp->getHttpRequest();
        $currentOpt = $request->getAction().'@'.$request->getMethod();
        $this->assign("currentOpt", $currentOpt);

        $this->tipoffService = Beans::get('tipoff.tipoff.service');
    }

    /**
     * 添加爆料界面
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {
        $this->setView('tipoff/index');
    }

    /**
     * 爆料列表
     * @param HttpRequest $request
     */
    public function lists(HttpRequest $request) {
        $conditions = array('userid'=>$this->loginUser['id']);
        $order = 'add_time DESC';
        $items = $this->tipoffService->getItems($conditions, null, $order);
        $this->assign('items', $items);
        $this->setView('tipoff/list');
    }

    /**
     * 添加爆料操作
     * @param HttpRequest $request
     */
    public function insert(HttpRequest $request) {
        $data = $request->getParameter('data');
        $data['userid'] = $this->loginUser['id'];
        $data['add_time'] = time();
        $success = $this->tipoffService->add($data);
        if($success) {
            AjaxResult::ajaxSuccessResult();
        } else {
            AjaxResult::ajaxFailtureResult();
        }
    }

    /**
     * 修改爆料界面
     * @param HttpRequest $request
     */
    public function edit(HttpRequest $request) {
        if ($request->getParameter('id', 'intval')) {
            $id = $request->getParameter('id', 'intval');
            $item = $this->tipoffService->getItem($id);
            $this->assign('item', $item);
            $this->setView('tipoff/add');
        } else {
            page404();
        }
    }

    /**
     * 更新爆料操作
     * @param HttpRequest $request
     */
    public function update(HttpRequest $request) {

    }

    /**
     * 彻底删除爆料
     * @param HttpRequest $request
     */
    public function delete(HttpRequest $request) {
        if ($request->getParameter('id', 'intval')) {
            $id = $request->getParameter('id', 'intval');
            $item = $this->tipoffService->getItem($id);
            $this->assign('item', $item);
            $this->setView('tipoff/add');
        } else {
            page404();
        }
    }

    /**
     * 爆料详情
     * @param HttpRequest $request
     */
    public function detail(HttpRequest $request) {
        if ($request->getParameter('id', 'intval')) {
            $id = $request->getParameter('id', 'intval');
            $conditions = array('userid'=>$this->loginUser['id'], 'id'=>$id);
            $items = $this->tipoffService->getItem($conditions);
            $this->assign('items', $items);
            $this->setView('tipoff/detail');
        } else {
            page404();
        }
    }


}
?>
