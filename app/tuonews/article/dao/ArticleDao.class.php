<?php

namespace article\dao;

use article\dao\interfaces\IArticleDao;
use common\dao\CommonDao;
use herosphp\bean\Beans;
use herosphp\core\Loader;

Loader::import('article.dao.interfaces.IArticleDao');
Loader::import('common.dao.CommonDao');

/**
 * 文章(DAO)接口实现
 * Class ArticleDao
 * @package article\dao
 * @author yangjian102621@163.com
 */
class ArticleDao extends CommonDao implements IArticleDao {

    /**
     * 文章数据表的分表节点数
     */
    const DATA_TABLE_NODES = 4;

    /**
     * 文章数据dao
     * @var \herosphp\model\C_Model
     */
    private $dataDao = null;

    /**
     * 文章标签关联dao
     * @var \herosphp\model\C_Model
     */
    private $tagAssocDao = null;

    /**
     * @param $articleModel
     * @param $tagAssoc
     */
    public function __construct($articleModel, $tagAssoc) {


        $this->setModelDao(Loader::model($articleModel));
        $this->tagAssocDao = Loader::model($tagAssoc);
    }

    /**
     * 添加文章
     * @see \article\dao\interfaces\IArtoneDao::add()
     */
    public function add($data) {
        //开启事务
        $this->beginTransaction();
        $result = $this->getModelDao()->insert($data);

        if ( $result != false ) {

            $data['aid'] = $result;
            $dataDao = $this->getDataDao($result);
            if ( $dataDao->insert($data) ) {

                //处理标签关联数据
                if ( $data['tags'] != '' ) {
                    $this->updateTagsAssoc($result, $data['tags']);
                }
                $this->commit();
            } else {
                $this->rollback();
            }

        } else {
            //操作失败，回滚
            $this->rollback();
        }

        return $result;

    }

    /**
     * 更新文章标签关联数据
     * @param int $aid 文章ID
     * @param string $tagIds 标签ID字符串
     */
    protected function updateTagsAssoc($aid, $tagIds) {

        $tagIds = explode(',', $tagIds);
        foreach ( $tagIds as $value ) {

            if ( intval($value) <= 0 ) {
                continue;
            }

            //如果关联数据已经存在则不插入了
            $condition = array(
                'aid' => $aid,
                'tagid' => $value
            );
            $exists = $this->tagAssocDao->getItem($condition);
            if ( $exists ) {
                continue;
            }
            $this->tagAssocDao->insert($condition);
        }
    }

    /**
     * 更新文章
     * @see \article\dao\interfaces\IArtoneDao::update()
     */
    public function update($data, $id) {
        //开启事务
        $this->beginTransaction();
        $result = $this->getModelDao()->update($data, $id);

        if ( $result != false ) {

            $dataDao = $this->getDataDao($id);
            if ( $dataDao->update($data, $id) ) {

                //处理标签关联数据
                if ( $data['tags'] != '' ) {
                    $this->updateTagsAssoc($id, $data['tags']);
                }

                $this->commit();
                return true;
            } else {
                $this->rollback();
                return false;
            }
        } else {
            //操作失败，回滚
            $this->rollback();
            return false;
        }

    }

    /**
     * 获取文章
     * @see \article\dao\interfaces\IArtoneDao::getItem()
     */
    public function getItem($conditions, $fields, $order, $group, $having) {

        //获取文章基本信息
        $item = $this->getModelDao()->getItem($conditions, $fields, $order, $group, $having);
        if ( !isset($item['id']) ) {
            $item = $this->getModelDao()->getItem($conditions, null, $order, $group, $having);
        }
        //获取问行内容
        $dataDao = $this->getDataDao($item['id']);
        $data = $dataDao->getItem($item['id']);
        //删除data表主键
        unset($data['id']);
        return array_merge($item, $data);

    }

    /**
     * @see \article\dao\interfaces\IArtoneDao::delete()
     */
    public function delete($id) {

        $this->beginTransaction();
        $result = $this->getModelDao()->delete($id);
        if ( $result ) {

            $dataDao = $this->getDataDao($id);
            if ( $dataDao->delete($id) ) {

                //取消文章与图片的绑定关系
                $imageService = Beans::get('image.image.service');
                $imageService->sets("aid", 0, "aid={$id}");

                //删除标签和文章关联
                $this->tagAssocDao->deletes("aid={$id}");

                $this->commit();
            } else {
                $this->rollback();
            }

        } else {
            //删除失败，回滚
            $this->rollback();
        }
        return $result;

    }

    /**
     * @see \article\dao\interfaces\IArtoneDao::deletes()
     */
    public function deletes($conditions) {

        $items = $this->getModelDao()->getItems($conditions, 'id');
        $counter = 0;
        foreach ( $items as $value ) {
            if ( $this->delete($value['id']) ) {
                $counter++;
            }
        }

        //全部删除才认为是成功的。
        return ( $counter == count($items)  );
    }

    /**
     * 获取文章内容表的dao实例
     * @param int $aid 文章ID
     * @return \herosphp\model\C_Model
     */
    public function getDataDao($aid) {

        //获取文章数据表的节点
        $node = $aid % self::DATA_TABLE_NODES;
        $this->dataDao = Loader::model('ArticleData');
        $tableMapping = $this->dataDao->getTableMapping();
        //加载数据表配置
        $dbConfigPath = 'db';
        if ( DB_CFG_PATH != false ) {
            $dbConfigPath = DB_CFG_PATH;
        }
        $tableConfig = Loader::config('table', $dbConfigPath);
        $this->dataDao->setTable($tableConfig[$tableMapping[$node]]);

        return $this->dataDao;
    }

}

?>
