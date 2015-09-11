<?php
namespace admin\action;

use herosphp\bean\Beans;
use herosphp\core\Controller;
use herosphp\core\WebApplication;
use herosphp\http\HttpRequest;
use herosphp\session\Session;
use herosphp\utils\AjaxResult;
use herosphp\utils\ArrayUtils;
use herosphp\utils\Page;

define('INVALID_ARGS', '参数错误！');

/**
 * Admin 模块通用 Action
 * @author          yangjian<yangjian102621@163.com>
 */
class CommonAction extends Controller {

    /**
     * 当前页面
     * @var int
     */
    protected $page = 1;

    /**
     * 没页显示多少条记录
     * @var int
     */
    protected $pagesize = 20;

    /**
     * 查询条件
     * @var string|array
     */
    protected $conditions;

    /**
     * 排序方式
     * @var string|array
     */
    protected $order;

    /**
     * 分组字段
     * @var string
     */
    protected $group;

    /**
     * 分组条件
     * @var string|array
     */
    protected $having;

    /**
     * 查询字段
     * @var string|array
     */
    protected $fields;

    /**
     * 管理员用户
     * @var array
     */
    protected $loginUser;

    /**
     * Beans服务的key
     * @var string
     */
    protected $serviceBean;

    /**
     * 初始化方法
     */
    public function C_start() {

        parent::C_start();

        $webApp = WebApplication::getInstance();
        $request = $webApp->getHttpRequest();

        //验证登录
        $adminService = Beans::get('admin.admin.service');
        $this->loginUser = $adminService->getLoginUser();
        if ( !$this->loginUser ) {
            $this->location(url("/admin_login_index"));
        } else {
            $this->assign('loginUser', $this->loginUser);
        }

        //获取菜单分组
        $groupService = Beans::get('admin.menuGroup.service');
        $menuService = Beans::get('admin.menu.service');
        $__menuGroups = ArrayUtils::changeArrayKey($groupService->getGroupCache(), 'id');
        //初始化左侧菜单的选中状态
        $currentOpt = '/'.$request->getModule().'_'.$request->getAction().'_'.$request->getMethod();
        Session::start();
        $mid = $request->getParameter('m', 'intval');
        if ( $mid > 0 ) {
            $_SESSION['m'] = $mid;
            $menu = $menuService->getItem($mid);
            $mpid = $menu['pid'];
            $mgroup = $menu['groupkey'];
            $_SESSION['mpid'] = $mpid;
            $_SESSION['mgroup'] = $mgroup;
        } else {
            $mpid = $_SESSION['mpid'];
            $mgroup = $_SESSION['mgroup'];
            $mid = $_SESSION['m'];
        }
        //获取菜单数据
        $permissions = $adminService->getPermissions();
        $systemMenu = $menuService->getMenuByUser($this->loginUser);
        //__print($systemMenu);die();
        $this->assign('__menuGroups', $__menuGroups);
        $this->assign('systemMenu', $systemMenu);
        $this->assign('mpid', $mpid);
        $this->assign('mgroup', $mgroup);
        $this->assign('mid', $mid);
        $this->assign('currentOpt', $currentOpt);

        //权限认证
        $opt = $request->getAction().'@'.$request->getMethod();
        if ( !$adminService->hasPermission($opt, $permissions) ) {
            //判断请求的类型,如果是ajax请求则使用ajax返回
            if ( strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {
                AjaxResult::ajaxResult('error', "您没有权限进行该操作，请联系管理员添加权限！");
            } else {
                $this->showMessage('danger', '您没有权限进行该操作，请联系管理员添加权限！');
            }
        }

        //初始化url
        $insert_url = '/'.$request->getModule().'_'.$request->getAction().'_'.'insert';
        $update_url = '/'.$request->getModule().'_'.$request->getAction().'_'.'update';
        $add_url = '/'.$request->getModule().'_'.$request->getAction().'_'.'add';
        $index_url = '/'.$request->getModule().'_'.$request->getAction().'_'.'index';
        $quicksave_url = '/'.$request->getModule().'_'.$request->getAction().'_'.'quicksave';

        $this->assign('insert_url', url($insert_url));
        $this->assign('update_url', url($update_url));
        $this->assign('add_url', url($add_url));
        $this->assign('index_url', url($index_url));
        $this->assign('quicksave_url', url($quicksave_url));
        //$this->assign('permissions', $permissions);

        $this->assign('emptyRecord', 'O(∩_∩)O~ 抱歉，暂无记录！');

    }

    /**
     * 首页列表
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {
        $this->page = $request->getParameter('page', 'intval');
        if ( $this->page <=0 ) {
            $this->page = 1;
        }
        $service = Beans::get($this->getServiceBean());
        $total = $service->count($this->getConditions());
        $items = $service->getItems($this->getConditions(), $this->getFields(), $this->getOrder(),
            $this->getPage(), $this->getPagesize(), $this->getGroup(), $this->getHaving());
        //初始化分页类
        $pageHandler = new Page($total, $this->getPagesize(), $this->getPage(), 4);

        //获取分页数据
        $pageData = $pageHandler->getPageData(DEFAULT_PAGE_STYLE);
        //组合分页HTML代码
        if ( $pageData ) {
            $pagemenu = '<ul>';
            $pagemenu .= '<li class="previous"><a class="fui-arrow-left" href="'.$pageData['prev'].'"></a></li> ';
            foreach ( $pageData['list'] as $key => $value ) {
                if ( $key == $this->page ) {
                    $pagemenu .= '<li class="active"><a href="#fakelink">'.$key.'</a></li> ';
                } else {
                    $pagemenu .= '<li><a href="'.$value.'">'.$key.'</a></li> ';
                }
            }
            $pagemenu .= '<li class="next"><a class="fui-arrow-right" href="'.$pageData['next'].'"></a></li> ';
            $pagemenu .= '</ul>';
            $pagemenu .= '<div class="page-input"><input type="text" class="form-control input-sm" value="'.$this->page.'"> ';
            $pagemenu .= '<a href="javascript:void(0);" class="btn btn-primary btn-sm" url="'.$pageData['url'].'" id="page-goto">确定</a></div> ';
        }

        $this->assign('pagemenu', $pagemenu);
        $this->assign('items', $items);
    }

    /**
     * 编辑操作
     * @param HttpRequest $request
     * @return void
     */
    public function edit(HttpRequest $request) {

        $id = $request->getParameter('id', 'intval');
        if ( $id <= 0 ) {
            $this->showMessage('danger', INVALID_ARGS);
        } else {

            $service = Beans::get($this->getServiceBean());
            $item = $service->getItem($id);
            $this->assign('item', $item);

        }
    }

    /**
     * 插入数据
     * @param array $data
     */
    public function insert( $data ) {

        $service = Beans::get($this->getServiceBean());

        if ( $service->add($data) ) {
            AjaxResult::ajaxSuccessResult();
        } else {
            AjaxResult::ajaxFailtureResult();
        }
    }

    /**
     * 更新数据
     * @param array $data
     * @param HttpRequest $request
     */
    public function update( $data, HttpRequest $request ) {

        if ( !$data ) AjaxResult::ajaxFailtureResult();

        $id = $request->getParameter('id', 'intval');
        if ( $id <= 0 ) AjaxResult::ajaxResult('error', INVALID_ARGS);

        $service = Beans::get($this->getServiceBean());
        if ( $service->update($data, $id) ) {
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
            AjaxResult::ajaxSuccessResult();
        } else {
            AjaxResult::ajaxFailtureResult();
        }
    }

    /**
     * 删除多条数据
     * @param HttpRequest $request
     */
    public function deletes( HttpRequest $request ) {

        $ids = $request->getParameter('ids');
        if ( empty($ids) ) AjaxResult::ajaxResult('error', INVALID_ARGS);
        $service = Beans::get($this->getServiceBean());
        if ( $service->deletes($ids) ) {
            AjaxResult::ajaxSuccessResult();
        } else {
            AjaxResult::ajaxFailtureResult();
        }
    }

    /**
     * 检验某个字段的值是否在数据库中存在，用于保持某个字段的唯一性
     * @param string $field 字段值
     * @param string $value 字段名
     */
    protected function checkField($field, $value) {

        $value = trim($value);
        $service = Beans::get($this->getServiceBean());
        $exists = $service->getItem(array($field => $value));
        if ( $exists ) {
            AjaxResult::ajaxResult('error', "{$value} 在数据库中已存在，请更换！");
        }

    }

    /**
     * 信息显示模板
     * @param $type 消息类型 info warnning success danger
     * @param $message
     * @param $url
     */
    public function showMessage( $type, $message, $url ) {

        $url = url("/admin_common_message/type-{$type}-message-".urlencode($message)."-url-".urlencode($url));
        $this->location($url);

    }

    /**
     * @param HttpRequest $request
     */
    public function message( HttpRequest $request ) {

        $this->assign('type', $request->getParameter('type'));
        $this->assign('message', $request->getParameter('message', 'urldecode'));
        $this->assign('url', $request->getParameter('url', 'urldecode'));
        $this->setView('message');

    }

    /**
     * @param array|string $conditions
     */
    public function setConditions($conditions)
    {
        $this->conditions = $conditions;
    }

    /**
     * @return array|string
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * @param array|string $fields
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
    }

    /**
     * @return array|string
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param string $group
     */
    public function setGroup($group)
    {
        $this->group = $group;
    }

    /**
     * @return string
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param array|string $having
     */
    public function setHaving($having)
    {
        $this->having = $having;
    }

    /**
     * @return array|string
     */
    public function getHaving()
    {
        return $this->having;
    }

    /**
     * @param array|string $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * @return array|string
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param int $page
     */
    public function setPage($page)
    {
        $this->page = $page;
    }

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param int $pagesize
     */
    public function setPagesize($pagesize)
    {
        $this->pagesize = $pagesize;
    }

    /**
     * @return int
     */
    public function getPagesize()
    {
        return $this->pagesize;
    }

    /**
     * @param string $serviceBean
     */
    public function setServiceBean($serviceBean)
    {
        $this->serviceBean = $serviceBean;
    }

    /**
     * @return string
     */
    public function getServiceBean()
    {
        return $this->serviceBean;
    }

}
?>
