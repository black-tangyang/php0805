<?php
/**
 * Created by PhpStorm.
 * User: ty
 * Date: 2015/11/17
 * Time: 23:12
 */

namespace Home\Controller;


use Think\Controller;

class ShoppingCarController extends Controller
{
    /**
     * 添加商品进入购物车
     */
      public function add(){
          //接收加入购物车的商品数据
          $goodsinfo=I('post.');
             $result=D('ShoppingCar')->add($goodsinfo);
             if($result!==false){
                  $this->success('成功加入购物车',U('Index/index'),1);
              }else{
                  $this->error('加入购物车失败');
              }
      }

    /**
     * 展示购物车列表
     */
    public function index(){
        //>>1.得到购物车中的数据
        $shoppingCarModel = D('ShoppingCar');
        $shoppingCar = $shoppingCarModel->getList();
        //>>2.将购物车中的数据分配到页面上
        $this->assign('shoppingCar',$shoppingCar);
        $this->display('index');
    }
}