<?php
namespace admin\action;

use herosphp\bean\Beans;
use herosphp\http\HttpRequest;
use herosphp\utils\AjaxResult;
use herosphp\utils\ArrayUtils;

/**
 * 菜单 Action
 * @author          yangjian<yangjian102621@163.com>
 */
class MenuAction extends CommonAction {

    /**
     * 菜单分组
     * @var array
     */
    private $menuGroups;

    /**
     * 初始化方法
     */
    public function C_start() {
        parent::C_start();
        $this->setServiceBean('admin.menu.service');
    }

    /**
     * 菜单列表
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {

        $adminMenuService = Beans::get("admin.menu.service");
        //初始化菜单分组
        $this->getMenuGroups();
        //一级菜单
        $items = array();
        //二级菜单
        $subItems = array();
        foreach ( $this->menuGroups as $value ) {

            $groupItems = $adminMenuService->getItems("groupkey='{$value['tkey']}' AND pid=0",null,"sort_num ASC");
            $items[$value['tkey']] = $groupItems;
            foreach ( $groupItems as $val ) {
                $subItems[$val['id']] = $adminMenuService->getItems("pid={$val['id']}", null,"sort_num ASC");
            }
        }
        $this->assign('items', $items);
        $this->assign('subitems', $subItems);
        $this->setView('system/menu_index');

    }

    /**
     * 添加菜单
     * @param HttpRequest $request
     */
    public function add( HttpRequest $request ) {

        $pid = $request->getParameter('pid', 'trim');
        $groupService  = Beans::get('admin.menuGroup.service');
        $menuService = Beans::get('admin.menu.service');
        $groupkey = null;
        //添加子菜单
        if ( $pid > 0 ) {
            //查找该菜单所属的groupkey
            $item = $menuService->getItem($pid, 'groupkey');
            $groupkey = $item['groupkey'];
            $this->assign('pid', $pid);

        } else {
            //默认加载一个分组的所有一级菜单
            $item = $groupService->getItem(null, 'tkey', 'sort_num ASC');
            $groupkey = $item['tkey'];
        }
        $menuData = $menuService->getItems("pid=0 AND groupkey='{$groupkey}'", null, 'sort_num ASC');
        $this->assign('menuData', $menuData);
        $this->assign('groupkey', $groupkey);
        $this->setView('system/menu_add');
        $this->getMenuGroups();

    }

    /**
     * 菜单编辑
     * @param HttpRequest $request
     */
    public function edit( HttpRequest $request ) {

        $id = $request->getParameter('id', 'intval');
        $menuService = Beans::get($this->getServiceBean());
        $item = $menuService->getItem($id);

        $menuData = $menuService->getItems("pid=0 AND groupkey='{$item['groupkey']}'", null, 'sort_num ASC');
        $this->assign('menuData', $menuData);
        $this->assign('item', $item);
        $this->setView('system/menu_edit');
        $this->getMenuGroups();
    }

    /**
     * 添加菜单操作
     * @param HttpRequest $request
     */
    public function insert( HttpRequest $request ) {

        $data = $request->getParameter('data');
        $service = Beans::get($this->getServiceBean());
        $data['add_time'] = time();
        if ( $service->add($data) ) {
            //更新菜单缓存
            $service->updateMenuCache();
            AjaxResult::ajaxSuccessResult();
        } else {
            AjaxResult::ajaxFailtureResult();
        }

    }

    /**
     * 更新菜单操作
     * @param HttpRequest $request
     */
    public function update( HttpRequest $request ) {

        $data = $request->getParameter('data');
        $id = $request->getParameter('id', 'intval');
        if ( $id <= 0 ) {
            AjaxResult::ajaxResult('error', INVALID_ARGS);
        }

        $service = Beans::get($this->getServiceBean());
        if ( $service->update($data, $id) ) {
            //更新菜单缓存
            $service->updateMenuCache();
            AjaxResult::ajaxSuccessResult();
        } else {
            AjaxResult::ajaxFailtureResult();
        }

    }

    /**
     * 快速保存
     * @param HttpRequest $request
     */
    public function quicksave( HttpRequest $request ) {

        $hids = $request->getParameter('hids');
        $datas = $request->getParameter('data');
        $service = Beans::get($this->getServiceBean());
        $counter = 0;
        // 保存数据
        foreach ( $hids as $key => $id ) {
            if ( $service->update($datas[$key], $id) ) {
                $counter++;
            }
        }

        //只要一条数据保存成功，则该操作成功
        if ( $counter > 0 ) {
            //更新菜单缓存
            $service->updateMenuCache();
            AjaxResult::ajaxResult('ok', '保存成功！');
        } else {
            AjaxResult::ajaxResult('error', '保存失败！');
        }
    }

    /**
     * 删除单条数据
     * @param HttpRequest $request
     */
    public function delete( HttpRequest $request ) {

        $id = $request->getParameter('id', 'intval');
        if ( $id <= 0 ) AjaxResult::ajaxResult('error', INVALID_ARGS);
        $service = Beans::get($this->getServiceBean());
        if ( $service->delete($id) ) {
            //更新菜单缓存
            $service->updateMenuCache();
            AjaxResult::ajaxSuccessResult();
        } else {
            AjaxResult::ajaxFailtureResult();
        }
    }

    /**
     * 获取顶级菜单
     */
    private function getMenuGroups() {

        //获取菜单分组
        $groupService = Beans::get('admin.menuGroup.service');
        $menuGroups = $groupService->getItems(null, 'id,name,tkey');
        $this->menuGroups = ArrayUtils::changeArrayKey($menuGroups, 'tkey');
        $this->assign('menuGroups', $this->menuGroups);
    }

    /**
     * 获取指定分组的一级菜单
     * @param HttpRequest $request
     */
    public function getTopMemnu(HttpRequest $request) {

        $groupkey = $request->getParameter('groupkey', 'trim');
        $menuService = Beans::get('admin.menu.service');
        $items = $menuService->getItems("pid=0 AND groupkey='{$groupkey}'", null, "sort_num ASC");
        if ( !empty($items) ) {
            AjaxResult::ajaxResult('ok', $items);
        } else {
            AjaxResult::ajaxFailtureResult();
        }
    }

}
?>
