<?php
/**
 * Created by PhpStorm.
 * User: ty
 * Date: 2015/11/14
 * Time: 19:56
 */

namespace Home\Model;


use Think\Model;

class ArticleModel extends Model
{
    public function getArticleList(){
        $sql="SELECT a.`id`,a.`name`,a.`article_category_id` FROM article_category AS ac JOIN article AS a ON ac.`id`=a.`article_category_id` WHERE ac.`is_help`=1;";
        return $this->query($sql);
    }

    public function getFastNews(){
        return $this->field("id,name")->where(array('article_category_id'=>6))->select();
    }
}