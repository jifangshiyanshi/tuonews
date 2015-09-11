<?php
namespace common\action;

use herosphp\cache\CacheFactory;
use herosphp\http\HttpRequest;
use herosphp\utils\AjaxResult;

/**
 * 公共缓存 Action
 * @author          yangjian<yangjian102621@163.com>
 */
class CacheAction extends CommonAction {

    /**
     * 自动保存
     * @param HttpRequest $request
     */
    public function autoSave(HttpRequest $request){

        $userid = $request->getParameter('userid', 'intval');
        $data = $request->getParameter('data');
        $cacheKey = $request->getParameter('cache_key', 'trim');

        $CACHER = CacheFactory::create('file');
        $cacheKey = md5($cacheKey.$userid);
        if ( $CACHER->set($cacheKey, $data) ) {
            AjaxResult::ajaxSuccessResult();
        } else {
            AjaxResult::ajaxFailtureResult();
        }

    }

}
?>
