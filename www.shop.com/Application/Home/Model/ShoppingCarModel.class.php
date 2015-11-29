<?php
/**
 * Created by PhpStorm.
 * User: ty
 * Date: 2015/11/17
 * Time: 23:12
 */

namespace Home\Model;


use Think\Model;

class ShoppingCarModel extends Model
{
    /**
     * @param $goodsinfo
     * 添加商品进入购物车
     */
    public function add($goodsinfo){
        //判断用户是否登录
        if(!isLogin()){
            //未登录将购买商品存入cookie中
            $this->addCookie($goodsinfo);
        }else{
            //登录将购买商品存入数据库
            $this->addDb($goodsinfo);
        }
    }

    /**
     * @param $goodsinfo
     * 添加商品进入cookie购物车方法
     */
    private function addCookie($goodsinfo){
        //判断用户是否是第一次添加商品进入cookie购物车
        $shoppingcar=cookie('SHOPPINGCAR');
        if(empty($shoppingcar)){
            //第一次添加商品
            $shoppingcar=array();
        }else{
            $shoppingcar=unserialize($shoppingcar);
        }
        //不为空是,查找是否购物车中有和本次加入的商品相同
        $tag=true;
            foreach ($shoppingcar as &$item){
                if($goodsinfo['goods_id']==$item['goods_id']){
                    $item['num']=$item['num']+$goodsinfo['num'];
                    $tag=false;
                    break;
                }
            }
        //根据tag判断是否将整条数据插入购物车(如果tag为false就证明之前购物车中存在同样的商品,就已经修改了他的数量了,不用再插入数据)
        if($tag) {
            $shoppingcar[] = $goodsinfo;
        }
        $shoppingcar=serialize($shoppingcar);
        cookie('SHOPPINGCAR',$shoppingcar);
    }

    /**
     * @param $goodsinfo
     * 将商品信息添加到数据库的购物车中
     */
    private function addDb($goodsinfo){
         $goodsinfo['member_id']=UID;
        //判断是否购物车中已经存在该商品
        if($this->where("member_id={$goodsinfo['member_id']} and goods_id={$goodsinfo['goods_id']}")->count()){
            //改变购物车中已经存在的商品的数量
            $this->where(array('member_id'=>$goodsinfo['member_id'],'goods_id'=>$goodsinfo['goods_id']));
            return parent::setInc('num',$goodsinfo['num']);
        }else{
            //直接将商品加入购物车
            parent::add($goodsinfo);
        }
    }


    /**
     * 登录时调用此方法,将cookie中的购物车存入数据库中的购物车
     */
    public function cookie2Db(){
        $goods_list=cookie('SHOPPINGCAR');
      if(!empty($goods_list)){
          $goods_list=unserialize($goods_list);
          foreach($goods_list as $item){
              $this->addDb($item);
          }
          cookie('SHOPPINGCAR',null);
      }
    }



    /**
     *1. 没有登录从cookie中获取
     *2. 登录的话从数据库中获取
     */
    public function getList(){
        if(!isLogin()){
            //>>1.没有登录从cookie中获取
            $shoppingCar = cookie('SHOPPINGCAR');
            $shoppingCar = unserialize($shoppingCar);
            //>>2.需要重构$shoppingCar中的数据
            $this->buildShoppingCar($shoppingCar);
            return $shoppingCar;
        }else{
            //>>2.登录的话从数据库中获取
            $member_id=UID;
            $shoppingCar = $this->field('goods_id,num')->where(array('member_id'=>$member_id))->select();
            $this->buildShoppingCar($shoppingCar);
            return $shoppingCar;
        }
    }
    private function buildShoppingCar(&$shoppingCar){
        foreach($shoppingCar as &$item){
            //>>1.需要根据item中的goods_id从goods表中查询出 name,logo,shop_price
            $row = M('Goods')->field('name,logo,shop_price')->find($item['goods_id']);
            $item = array_merge($item,$row);
        }
    }

}