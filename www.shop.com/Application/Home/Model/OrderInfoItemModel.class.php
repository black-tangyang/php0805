<?php
/**
 * Created by PhpStorm.
 * User: ty
 * Date: 2015/11/22
 * Time: 16:42
 */

namespace Home\Model;


use Think\Model;

class OrderInfoItemModel extends Model
{
       public function addAll($rows){
           $result=parent::addAll($rows);
           //删除购物车中的数据
           /*if($result!==false){
               D('ShoppingCar')->where(array('member_id'=>UID))->delete();
           }*/
           return $result;
       }
}