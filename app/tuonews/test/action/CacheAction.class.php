<?php
namespace test\action;

use common\action\CommonAction;
use herosphp\cache\CacheFactory;
use herosphp\http\HttpRequest;

/**
 * 缓存测试
 * @author          yangjian<yangjian102621@163.com>
 */
class CacheAction extends CommonAction {

    /**
     * @param HttpRequest $request
     */
    public function index(HttpRequest $request) {

        $CACHER = CacheFactory::create('file');
        $key = 'admin.menu.data';
        //$CACHER->set($key, '测试缓存,fuck it');
        __print($CACHER->get($key, 0));
        die();

    }

}
?>
