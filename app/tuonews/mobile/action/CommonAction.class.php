<?php
namespace mobile\action;

use herosphp\bean\Beans;
use herosphp\core\Controller;
use herosphp\core\WebApplication;

abstract class CommonAction extends Controller {

    protected $page = 1;

    protected $pagesize = 20;

    protected $order = 'id DESC';

    public function C_start() {
        $webApp = WebApplication::getInstance();
        $request = $webApp->getHttpRequest();

        $page = $request->getParameter('page', 'intval');
        $this->setPage($page > 0 ? $page : 1);
    }

    /**
     * @return int
     */
    public function getPage() {
        return $this->page;
    }

    /**
     * @param int $page
     */
    public function setPage($page) {
        $this->page = $page;
    }

    /**
     * @return int
     */
    public function getPagesize() {
        return $this->pagesize;
    }

    /**
     * @param int $pagesize
     */
    public function setPagesize($pagesize) {
        $this->pagesize = $pagesize;
    }

    /**
     * @return string
     */
    public function getOrder() {
        return $this->order;
    }

    /**
     * @param string $order
     */
    public function setOrder($order) {
        $this->order = $order;
    }
}
