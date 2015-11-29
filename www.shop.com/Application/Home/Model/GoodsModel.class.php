<?php
/**
 * Created by PhpStorm.
 * User: ty
 * Date: 2015/11/14
 * Time: 20:54
 */

namespace Home\Model;


use Think\Model;

class GoodsModel extends Model
{
    /**
     * 得到商品状态以及对应的行的数组
     */
   public function getGoodsstatusRowsArr(){

        $arr1=$arr2=$arr4=$arr8=$arr16=array();
       //搜索出goods中的5个字段的列表,并且能够显示的商品
       $list=$this->field('id,name,shop_price,goods_status,logo')->where("is_on_sale=1 and status>0")->order('sort')->select();
       foreach($list as $row){
           if(($row['goods_status']&1)>0){
               if(count($arr1)<5) {
                   $arr1[] = $row;
               }
           }
           if(($row['goods_status']&2)>0){
               if(count($arr2)<5) {
                   $arr2[] = $row;
               }
           }
           if(($row['goods_status']&4)>0){
               if(count($arr4)<5) {
                   $arr4[] = $row;
               }
           }
           if(($row['goods_status']&8)>0){
               if(count($arr8)<5) {
                   $arr8[] = $row;
               }
           }
           if(($row['goods_status']&16)>0){
               if(count($arr16)<5) {
                   $arr16[] = $row;
               }
           }
       }
       return array($arr1,$arr2,$arr4,$arr8,$arr16);
   }

    //得到对应id的商品信息
    public function getGoodsInfoById($id){
       return $this->where(array('id'=>$id))->where("is_on_sale=1 and status>0")->find();
    }
}