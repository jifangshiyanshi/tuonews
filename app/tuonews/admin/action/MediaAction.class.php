<?php
namespace admin\action;

use herosphp\bean\Beans;
use herosphp\http\HttpRequest;
use herosphp\utils\AjaxResult;
use herosphp\utils\ArrayUtils;

/**
 * 用户 Action
 * @author          yangjian<yangjian102621@163.com>
 * @modify          wangyanjun
 */
class mediaAction extends CommonAction {

    /**
     * 初始化方法
     */
    public function C_start() {
        parent::C_start();
        $this->setServiceBean('media.media.service');
    }

    /**
     * 已认证媒体列表
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {

        $conditions = array("ischeck" => 1);
        $this->getData($conditions, $request);
        $this->setView('media/media_index');

    }

    /**
     * 未审核媒体列表
     * @param HttpRequest $request
     */
    public function apply( HttpRequest $request ) {

        $conditions=array( "ischeck" => '0' );
        $this->getData($conditions, $request);
        $this->setView('media/media_apply');

    }

    /**
     * 审核失败媒体列表
     * @param HttpRequest $request
     */
    public function checkfail( HttpRequest $request ) {

        $conditions=array( "ischeck" => '-1' );
        $this->getData($conditions, $request);
        $this->setView('media/media_checkfail');

    }

    /**
     * 获取媒体数据列表
     * @param HttpRequest $request
     * @param array $conditions 查询初始条件
     */
    private function getData( $conditions, HttpRequest $request, $order='id DESC' ) {

        $name = $request->getParameter('name', 'urldecode|trim');
        $startTime = $request->getParameter('start_time', 'trim');
        $endTime = $request->getParameter('end_time', 'trim');
        $chanelId = $request->getParameter('media_type', 'intval');

        //标题筛选
        if ( $name != '' ) {
            $conditions['name'] = '%'.$name.'%';
        }

        //频道筛选
        if ( $chanelId > 0 ) {
            $conditions['media_type'] = $chanelId;
        }

        //筛选时间
        if ( $startTime != '' ) {
            $conditions['add_time'] = '>='.strtotime($startTime);
        }
        if ( $endTime != '' ) {
            $conditions['add_time'] = '<='.strtotime($endTime);
        }
        $this->setFields('id,name,userid,media_type,add_time,check_note');
        $this->setConditions($conditions);
        $this->setOrder($order);

        parent::index($request);

        //初始化媒体用户名
        $items = $this->getTemplateVar('items');
        $userIds = array();
        foreach ( $items as $value ) {
            $userIds[] = $value['userid'];
        }
        $userService = Beans::get('user.user.service');
        if ( !empty($userIds) ) {
            $users = $userService->getItems($userIds, 'id,username, nickname');
            $users = ArrayUtils::changeArrayKey($users, 'id');

            foreach ( $items as $key => $value ) {
                $items[$key]['username'] = $users[$value['userid']]['username'];
                $items[$key]['nickname'] = $users[$value['userid']]['nickname'];
            }
            $this->assign('items', $items);
        }

        //媒体类型
        $TypeService=Beans::get("media.type.service");
        $mediaType=$TypeService->getItems();
        $this->assign("mediaType",$mediaType);
        $this->assign("params",$request->getParameters());

    }

    /**
     * 添加媒体
     * @param HttpRequest $request
     */
    public function add( HttpRequest $request ) {

        $this->showMessage('danger', '该功能已被屏蔽，请到前端会员中心申请入驻媒体！');

        $TypeService=Beans::get("media.type.service");
        $RecService =Beans::get("media.rec.service");
        $rec=$RecService->getItems();
        $this->assign("rec",$rec);
        $mediaType=$TypeService->getItems();
        $this->assign("mediaType",$mediaType);
        $this->setView('media/media_add');

    }

    /**
     * 媒体编辑
     * @param HttpRequest $request
     */
    public function edit( HttpRequest $request ) {

        $TypeService = Beans::get("media.type.service");
        $RecService = Beans::get("media.rec.service");
        $rec = $RecService->getItems();
        $this->assign("rec",$rec);
        $mediaType = $TypeService->getItems();
        $this->assign("mediaType",$mediaType);
        parent::edit($request);
        $this->setView('media/media_edit');
    }

    /**
     * 添加媒体操作
     * @param HttpRequest $request
     */
    public function insert( HttpRequest $request ) {

        $data = $request->getParameter('data');
        $data['add_time'] = time();
        $data['check_time']=time();
        $data['check_id']=$this->loginUser['id'];
        $data["rec_position"]=implode(",",$data["rec_position"]);
        parent::insert($data);
    }

    /**
     * 更新媒体操作
     * @param HttpRequest $request
     */
    public function update( HttpRequest $request ) {

        $data = $request->getParameter('data');
        parent::update($data, $request);

    }

    /**
     * @param HttpRequest $request
     * 删除操作
     */
    public function delete( HttpRequest $request){

        parent::delete($request);
    }

    /**
     * @param HttpRequest $request
     * 批量删除
     */
    public function deletes(HttpRequest $request){

        parent::deletes($request);
    }

    /**
     * 选择文章
     * @param HttpRequest $request
     */
    public function select(HttpRequest $request) {

        $mids = $request->getParameter('mids', 'trim');
        $name = $request->getParameter('name', 'urldecode|trim');

        $conditions = array('ischeck' => 1);
        if ( $name != '' ) {
            $conditions['name'] = '%'.$name.'%';
        }
        $this->setPagesize(12);
        $this->setConditions($conditions);
        parent::index($request);
        $this->setView('media/media_select');

        $mids = explode(',', $mids);
        $this->assign('mids', $mids);
        $this->assign('params', $request->getParameters());

    }

    /**
     * 批量审核并开通媒体站
     * @param HttpRequest $request
     */
    public function multiCheck(HttpRequest $request) {

        $ids = $request->getParameter('ids');
        $service = Beans::get($this->getServiceBean());
        $data = array(
            'check_time' => time(),
            'check_id' => $this->loginUser['id'],
            'ischeck' => 1
        );

        //审核并开通媒体站
        if ( $service->updates($data, $ids) && $service->openSite($ids) ) {

            //新增一条系统消息提示已经审核
            $messageService = Beans::get('user.message.service');
            $items = $service->getItems($ids, 'userid, name');
            foreach ( $items as $value ) {
                $data = array(
                    'sender' => 0,
                    'receiver' => $value['userid'],
                    'content' => '您申请的媒体“'.$value['name'].'”已通过审核。',
                    'send_time' => time(),
                    'isread' => 0,
                );
                $messageService->add($data);
            }

            AjaxResult::ajaxSuccessResult();
        } else {
            AjaxResult::ajaxFailtureResult();
        }

    }

    /**
     * 审核失败并记录审核备注
     * @param HttpRequest $request
     */
    public function unCheck(HttpRequest $request) {

        $id = $request->getParameter('id', 'intval');
        $checkNote = $request->getParameter('check_note', 'trim');
        $service = Beans::get($this->getServiceBean());
        $data = array(
            'check_time' => time(),
            'check_id' => $this->loginUser['id'],
            'check_note' => $checkNote,
            'ischeck' => -1
        );

        //更新审核信息
        if ( $service->update($data, $id) ) {

            //新增一条系统消息提示审核失败
            $messageService = Beans::get('user.message.service');
            $item = $service->getItem($id, 'userid, name');
            $data = array(
                'sender' => 0,
                'receiver' => $item['userid'],
                'content' => '您申请的媒体“'.$item['name'].'”审核失败。原因是“'.$checkNote.'”',
                'send_time' => time(),
                'isread' => 0,
            );
            $messageService->add($data);
            AjaxResult::ajaxSuccessResult();
        } else {
            AjaxResult::ajaxFailtureResult();
        }

    }
}
?>
