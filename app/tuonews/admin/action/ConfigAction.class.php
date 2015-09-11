<?php
namespace admin\action;

use herosphp\bean\Beans;
use herosphp\core\Debug;
use herosphp\core\Loader;
use herosphp\core\WebApplication;
use herosphp\http\HttpRequest;
use herosphp\utils\ArrayUtils;

/**
 * 系统配置 Action
 * @author          yangjian<yangjian102621@163.com>
 */
class ConfigAction extends CommonAction {

    /**
     * 初始化方法
     */
    public function C_start() {
        parent::C_start();
        $this->setServiceBean('admin.config.service');
    }

    /**
     * 系统配置列表
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {

        $configService = Beans::get('admin.config.service');
        $items = $configService->getItems();
        //获取app配置文档
        $wepApp = WebApplication::getInstance();
        $groups = $wepApp->getConfig('system.config.group');

        //将数据分组
        $newItems = array();
        foreach ( $groups as $key => $value ) {
            $newItems[$key] = ArrayUtils::filterArrayByKey('groupkey', $key, $items);
        }

        $this->assign('items', $newItems);
        $this->assign('groups', $groups);
        $this->setView('system/config_index');

    }

    /**
     * 添加管理员操作
     * @param HttpRequest $request
     */
    public function insert( HttpRequest $request ) {

        $data = $request->getParameter('data');
        parent::insert($data);

    }

    public function edit( HttpRequest $request ) {

        parent::edit($request);
        //获取app配置文档
        $wepApp = WebApplication::getInstance();
        $groups = $wepApp->getConfig('system.config.group');
        $this->assign('groups', $groups);
        $this->setView('system/config_edit');
    }

    /**
     * 更新管理员操作
     * @param HttpRequest $request
     */
    public function update( HttpRequest $request ) {

        $data = $request->getParameter('data');
        $password = $request->getParameter('password', 'trim');
        if ( $password != '' ) {
            $password = md5(md5($password));
            $data['password'] = $password;
        }
        parent::update($data, $request);

    }

}
?>
