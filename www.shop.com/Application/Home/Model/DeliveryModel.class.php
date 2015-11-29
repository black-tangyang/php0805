<?php
/**
 * Created by PhpStorm.
 * User: ty
 * Date: 2015/11/22
 * Time: 11:22
 */

namespace Home\Model;


use Think\Model;

class DeliveryModel extends Model
{
     public function getDeliverys(){
         return $this->where('status>0')->select();
     }

    /**
     * 根据快递的id得到快递的信息
     */
    public function get($id){
        return $this->field('id as delivery_id,name as delivery_name,price as delivery_price')->where(array('id'=>$id))->find();
    }
}
