<?php

namespace article\service\interfaces;

use common\service\interfaces\ICommonService;
use herosphp\core\Loader;

Loader::import('common.service.interfaces.ICommonService', IMPORT_APP);

/**
 * 文章标签服务接口
 * Interface IArticleTagService
 */
interface IArticleTagService extends ICommonService {

    /**
     * 获取搜索热门标签
     * @param int $num 获取标签个数
     * @param string $field 获取内容字段
     * @return mixed
     */
    public function getHotTags($num=4, $field='id,name');
}
?>
