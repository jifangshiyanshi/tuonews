<?php

namespace image\service\interfaces;
use common\service\interfaces\ICommonService;
use herosphp\core\Loader;

Loader::import('common.service.interfaces.ICommonService', IMPORT_APP);
/**
 * 图片空间服务接口
 * Interface IBlogService
 */
interface IImageService extends ICommonService {

    /**
     * 提取远程文章图片，并存入图片数据库
     * @param string $content 文章内容
     * @param int $aid 文章ID
     * @param string $module 图片所属模块，用来确定图片所在文章的数据表
     * @return mixed
     */
    public function getRemoteImage($content, $aid, $module='article');
}
?>