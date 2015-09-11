<?php

namespace article\service\interfaces;
use common\service\interfaces\ICommonService;
use herosphp\core\Loader;

Loader::import('common.service.interfaces.ICommonService', IMPORT_APP);
/**
 * 文章服务接口
 * Interface IArticleService
 */
interface IArticleService extends ICommonService {

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
     * 获取跟指定文章相似的文章
     * @param int $aid 文章ID
     * @param int $num 获取数据条数
     * @param string $field 查询字段
     * @return mixed
     */
    public function getAlikeArticles($aid, $num, $field=null);

    /**
     * 获取文章热门排行
     * @param int $rows
     * @param string 内容字段
     * @return mixed
     */
    public function getHotRank($rows=10, $field=null);

    /**
     * 获取文章周排行
     * @param int $rows
     * @param string 内容字段
     * @return mixed
     */
    public function getWeekRank($rows=10, $field=null);

    /**
     * 获取编辑推荐文章
     * @param int $rows
     * @param string 内容字段
     * @return mixed
     */
    public function getEditorRecommend($rows=10, $field=null);

    /**
     * 获取首页轮播资讯
     * @param $rows
     * @param string 内容字段
     * @return mixed
     */
    public function getIndexCarousel($rows, $field=null);

}
