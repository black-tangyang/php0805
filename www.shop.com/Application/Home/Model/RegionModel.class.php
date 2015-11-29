<?php
/**
 * Created by PhpStorm.
 * User: ty
 * Date: 2015/11/20
 * Time: 23:28
 */

namespace Home\Model;


use Think\Model;

class RegionModel extends Model
{
    public function getChildren($parent_id=0){
        return $this->field('id,name')->where(array('parent_id'=>$parent_id))->select();
    }
}