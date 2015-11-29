<?php
/**
 * Created by PhpStorm.
 * User: ty
 * Date: 2015/11/16
 * Time: 10:02
 */

namespace Home\Model;


use Think\Model;

class GoodsGalleryModel extends Model
{
       //得到对应id的商品的相册
       public function getGoodsGalleryById($id){
              return $this->where(array('goods_id'=>$id))->select();
       }
}