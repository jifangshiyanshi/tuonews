<?php
namespace admin\action;

use herosphp\bean\Beans;
use herosphp\cache\CacheFactory;
use herosphp\http\HttpRequest;
use herosphp\utils\AjaxResult;

/**
 * 系统模板（邮件，短信） Action
 * @author          yangjian<yangjian102621@163.com>
 */
class STemplateAction extends CommonAction {

    /**
     * 自动保存的key
     * @var string
     */
    protected static $AUTO_SAVE_KEY = 'message_template_autosave';

    /**
     * 初始化方法
     */
    public function C_start() {
        parent::C_start();
        $this->setServiceBean('admin.messageTemplate.service');

        //获取应用配置文档配置参数
        $templateTypes = getConfig('message.template.type');
        $messageTags = getConfig('message.template.tags');

        $this->assign('templateTypes', $templateTypes);
        $this->assign('messageTags', $messageTags);
    }

    /**
     * 模板列表
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {

        $this->setOrder('sort_num ASC');
        parent::index($request);
        $this->setView('system/template_index');

    }

    /**
     * 添加模板
     * @param HttpRequest $request
     */
    public function add( HttpRequest $request ) {

        //首先查看是否有草稿
        $CACHER = CacheFactory::create('file');
        $key = md5(self::$AUTO_SAVE_KEY.$this->loginUser['id']);
        $item = $CACHER->get($key, 0);

        //获取系统配置
        $configService = Beans::get('admin.config.service');
        $autoSaveInterval = $configService->getVarValue('basic', 'autosave_interval');

        $this->assign('item', $item);
        $this->assign('autoSaveInterval', intval($autoSaveInterval));
        $this->setView('system/template_add');
        $this->assign('autoSaveKey', self::$AUTO_SAVE_KEY);

    }

    /**
     * 模板编辑
     * @param HttpRequest $request
     */
    public function edit( HttpRequest $request ) {

        parent::edit($request);
        $this->setView('system/template_edit');
    }

    /**
     * 添加模板操作
     * @param HttpRequest $request
     */
    public function insert( HttpRequest $request ) {

        $data = $request->getParameter('data');
        $data['add_time'] = time();
        $data['update_time'] = time();

        //检验模板key是否唯一
        $this->checkField('tkey', $data['tkey']);

        $service = Beans::get($this->getServiceBean());
        if ( $service->add($data) ) {

            //清除自动保存草稿
            $CACHER = CacheFactory::create('file');
            $key = md5(self::$AUTO_SAVE_KEY.$this->loginUser['id']);
            $CACHER->delete($key);
            AjaxResult::ajaxSuccessResult();
        } else {
            AjaxResult::ajaxFailtureResult();
        }
    }

    /**
     * 更新模板操作
     * @param HttpRequest $request
     */
    public function update( HttpRequest $request ) {

        $data = $request->getParameter('data');
        $data['update_time'] = time();

        $id = $request->getParameter('id', 'intval');
        if ( $id <= 0 ) {
            AjaxResult::ajaxResult('error', INVALID_ARGS);
        }

        //检验模板key唯一性
        $tkey_bak = $request->getParameter('tkey_bak', 'trim');
        if ( $tkey_bak != trim($data['tkey']) ) {
            $this->checkField('tkey', $data['tkey']);
        }

        $service = Beans::get($this->getServiceBean());
        if ( $service->update($data, $id) ) {
            AjaxResult::ajaxSuccessResult();
        } else {
            AjaxResult::ajaxFailtureResult();
        }

    }

}
?>
