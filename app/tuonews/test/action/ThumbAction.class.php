<?php
namespace test\action;

use common\action\CommonAction;
use herosphp\cache\CacheFactory;
use herosphp\http\HttpRequest;
use herosphp\utils\ImageThumb;

/**
 * 缩略图测试
 * @author          yangjian<yangjian102621@163.com>
 */
class ThumbAction extends CommonAction {

    /**
     * @param HttpRequest $request
     */
    public function index(HttpRequest $request) {

        $src = __DIR__.'/test.jpg';

        $thumb = ImageThumb::getInstance();
        //缩放
//        $size = array(800,0);
//        $thumb->setFlag(2); //等比缩放
//        $thumb->makeThumb($size, $src);

        //裁剪
        $position = array(100, 200);
        $size = array(500, 300);
        $thumb->setFlag(0);
        $thumb->crop($position, $size, $src);
        $thumb->showImage();
        die();

    }

}
?>
