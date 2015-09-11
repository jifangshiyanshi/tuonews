<?php
namespace image\service;

use common\service\CommonService;
use herosphp\bean\Beans;
use herosphp\core\Loader;
use image\service\interfaces\IImageService;

Loader::import('image.service.interfaces.IImageService', IMPORT_APP);
Loader::import('common.service.CommonService', IMPORT_APP);

/**
 * 图片空间服务接口实现
 * Class ImageService
 * @package blolg\service
 */
class ImageService extends CommonService implements IImageService {

    /**
     * @see \image\service\interfaces\IImageService::getRemoteImage
     */
    public function getRemoteImage($content, $aid, $module='article') {

        //提取图片链接
        $imagePattern = '/<img.*?src="(.*?)".*?\/>/is';
        $result = preg_match_all($imagePattern, $content, $matches);
        if ( $result ) {
            //获取用户ID
            $articleService = Beans::get('article.article.service');
            $item = $articleService->getItem($aid, 'userid');
            foreach ( $matches[1] as $values ) {
                if ( !$this->isLocalImage($values) ) {

                    //获取文件名
                    $pathinfo = pathinfo($values);
                    //添加图片到图片空间
                    $data = array(
                        'userid' => intval($item['userid']),
                        'aid' => $aid,
                        'module' => $module,
                        'url' => $values,
                        'type' => 'image',
                        'filename' => $pathinfo['basename'],
                        'add_time' => time(),
                        'grabed' => 0,
                    );
                    $this->add($data);
                }
            }
        }
    }

    /**
     * 判断一张图片是否是远程图片还是本地图片
     * @param string $src 图片地址
     * @return boolean
     */
    protected function isLocalImage($src) {

        //绝对地址
        if ( strpos($src, 'http://') === 0 ) {

            //检查是否包含本站域名
            $domain = getConfig('domain');
            if ( strpos($src, $domain) === false ) {
                return false;
            } else {
                return true;
            }

            //相对地址
        } else {
            return true;
        }
    }

}
