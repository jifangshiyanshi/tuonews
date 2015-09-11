<?php

namespace models;

use herosphp\model\C_Model;

class ArticleCommentModel extends  C_Model{

    public function __construct(){
        parent::__construct('article_comment');
    }

}