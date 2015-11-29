<?php
/**
 * Created by PhpStorm.
 * User: ty
 * Date: 2015/11/14
 * Time: 13:42
 */

namespace Home\Model;


use Think\Model;

class GoodsCategoryModel extends Model
{
     public function getGoodsCategoryList($field='*'){
         return $this->where("status>0")->field($field)->order('lft')->select();
     }

    public function getParentCategory($categoryid){
         $sql="SELECT b.`id`,b.`name` FROM goods_category AS a,goods_category AS b WHERE a.id={$categoryid} AND  b.`lft`<=a.`lft` AND b.`rght`>=a.`rght` ORDER BY b.`lft`;";
         return M()->query($sql);
    }
}