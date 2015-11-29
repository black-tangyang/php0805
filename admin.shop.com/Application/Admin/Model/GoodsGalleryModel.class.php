<?php
/**
 * Created by PhpStorm.
 * User: ty
 * Date: 2015/11/9
 * Time: 15:30
 */

namespace Admin\Model;


use Think\Model;

class GoodsGalleryModel extends Model
{
public function getGalleryByGoods_id($goods_id){
    return $this->where(array('goods_id'=>$goods_id))->select();

}
}