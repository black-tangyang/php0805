<?php
/**
 * Created by PhpStorm.
 * User: ty
 * Date: 2015/11/20
 * Time: 23:21
 */

namespace Home\Controller;


use Think\Controller;

class OrderInfoController extends Controller
{
    /**
     * 该类创建对象时,会执行的方法
     */
    public function _initialize(){
        if(!isLogin()) {
            cookie('__LOGIN_RETURN_URL__',$_SERVER['REQUEST_URI']);
            $this->error('请登录!',U('Member/login'));
        }
    }


    public function index(){
        //为页面准备数据
          //>>1.准备收货人地址的数据
        $addresses=D('Address')->getAddresses(UID);
          //>>2.准备送货方式的数据
        $deliverys=D('Delivery')->getDeliverys();
          //>>3.得到支付方式的列表
        $getPayTypes=D('PayType')->getPayTypes();
          //>>4.得到购物车中的数据
        $shoppingCars = D('ShoppingCar')->getList();


        $this->assign('addresses',$addresses);//为视图指派收货人地址数据
        $this->assign('deliverys',$deliverys);//为视图指派送货方式的数据
        $this->assign('getPayTypes',$getPayTypes);//为视图指派支付方式的数据
        $this->assign('shoppingCars',$shoppingCars);//将购物车中的数据分配到页面上
        $this->display('index');
    }

    public function pay($order_id){
        $orderinfo=D('OrderInfo')->get($order_id);
        $this->assign($orderinfo);
        $this->display('pay');
    }

    /**
     * 提交订单
     */
    public function add(){
        $param=I("post.");
        $m=D('OrderInfo');
        //添加订单到数据库中
        $result=$m->add($param);
        if($result!==false){
            $this->success('提交订单成功',U('pay',array('order_id'=>$result)),1);
        }else{
            $this->error('提交订单失败'.$m->getError());
        }
    }

    public function doPay($id){
        echo "ok";
    }

}