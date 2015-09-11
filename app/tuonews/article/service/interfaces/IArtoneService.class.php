<?php

namespace article\service\interfaces;
use common\service\interfaces\ICommonService;
use herosphp\core\Loader;

Loader::import('common.service.interfaces.ICommonService', IMPORT_APP);
/**
 * 单文章文章服务接口
 * Interface IArticleService
 */
interface IArtoneService extends ICommonService {

    /**
     * 网站底部单文章缓存key
     */
    const FOOT_NAVIS_CACHE = 'site_bottom_artone';

    /**
     * 更新文章内容表的字段
     * @param string $content 文章内容
     * @param int $id 文章ID
     * @return mixed
     */
    public function setContent($content, $id);

    /**
     * 获取文章内容
     * @param int $id 文章ID
     * @return mixed
     */
    public function getContent($id);

    /**
     * 获取底部导航单文章
     * @param $rows
     * @param $postion
     * @return mixed
     */
    public function getFootNavis($rows, $position);

    /**
     * 删除底部单文章的缓存
     * @return mixed
     */
    public function deleteFootNavisCache();

    /**
     * 获取媒体单文章(带缓存)
     * @param $mediaId 媒体ID
     * @return mixed
     */
    public function getMediaArtone($mediaId);

}
