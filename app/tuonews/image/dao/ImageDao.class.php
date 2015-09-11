<?php

namespace image\dao;

use common\dao\CommonDao;
use herosphp\core\Loader;
use image\dao\interfaces\IImageDao;

Loader::import('image.dao.interfaces.IImageDao');
Loader::import('common.dao.CommonDao');

/**
 * 图片空间(DAO)接口实现
 * Class ImageDao
 * @package image\dao
 * @author yangjian102621@163.com
 */
class ImageDao extends CommonDao implements IImageDao {

    /**
     * @see \image\dao\interfaces\IImageDao::add
     */
    public function add($data) {

        //检查该用户图片空间中是否已经有这张图片
        $exists = $this->getItem("userid={$data['userid']} AND url='{$data['url']}'");
        if ( $exists ) {
            return true;
        } else {
            return $this->getModelDao()->insert($data);
        }

    }
}

?>
