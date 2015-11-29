<?php
/**
 * Created by PhpStorm.
 * User: ty
 * Date: 2015/11/22
 * Time: 11:45
 */

namespace Home\Model;


use Think\Model;

class PayTypeModel extends Model
{
    /**
     * 得到支付方式列表
     */
     public function getPayTypes(){
         return $this->where('status>0')->select();
     }

    /**
     * 根据id得到一行数据
     */
    public function get($id){
      return $this->field('id as pay_type_id,name as pay_type_name')->where(array('id'=>$id))->find();
    }
}