<?php
namespace admin\action;

use herosphp\bean\Beans;
use herosphp\http\HttpRequest;
use herosphp\utils\AjaxResult;

/**
 * 菜单分组 Action
 * @author          yangjian<yangjian102621@163.com>
 */
class MenuGroupAction extends CommonAction {

    /**
     * 初始化方法
     */
    public function C_start() {
        parent::C_start();
        $this->setServiceBean('admin.menuGroup.service');
    }

    /**
     * 菜单分组列表
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {

        $this->setOrder('sort_num ASC');
        parent::index($request);
        $this->setView('system/menuGroup_index');

    }

    /**
     * 添加菜单分组
     * @param HttpRequest $request
     */
    public function add( HttpRequest $request ) {

        $this->setView('system/menuGroup_add');

    }

    /**
     * 菜单分组编辑
     * @param HttpRequest $request
     */
    public function edit( HttpRequest $request ) {

        parent::edit($request);
        $this->setView('system/menuGroup_edit');
    }

    /**
     * 添加菜单分组操作
     * @param HttpRequest $request
     */
    public function insert( HttpRequest $request ) {

        $data = $request->getParameter('data');
        $this->checkField('tkey', $data['tkey']);
        $data['add_time'] = time();
        parent::insert($data);
    }

    /**
     * 更新菜单分组操作
     * @param HttpRequest $request
     */
    public function update( HttpRequest $request ) {

        $data = $request->getParameter('data');
        $tkeyBak = $request->getParameter('tkey_bak');
        //修改了tkey需要重新验证
        if ( $tkeyBak != trim($data['tkey']) ) {
            $this->checkField('tkey', $data['tkey']);
        }
        parent::update($data, $request);

    }

}
?>
