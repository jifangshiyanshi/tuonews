<?php
/**
 * 媒体文章推荐位置Model
 * @author  yangjian <yangjian102621@163.com>
 */

namespace models;

use herosphp\model\C_Model;

class MediaArticleRecModel extends C_Model {

    public function __construct() {

        parent::__construct('media_article_rec');
        $this->setPrimaryKey('id');

    }
}
