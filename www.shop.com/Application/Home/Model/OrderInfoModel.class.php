<?php
/**
 * Created by PhpStorm.
 * User: ty
 * Date: 2015/11/20
 * Time: 23:22
 */

namespace Home\Model;


use Org\Util\String;
use Think\Model;

class OrderInfoModel extends Model
{
    public function add($requestData){
        $this->startTrans();
        //获得购物车中的数据
        $rows=D('ShoppingCar')->getList();
        $price=0;
        foreach($rows as $row) {
            //算出购物车的总价
            $price += $row['shop_price'] * $row['num'];
        }
        $file=fopen('./stock.lock','r+');//创建文件,存储锁的状态
        //判断商品库存是否充足
        if(flock($file,LOCK_EX)) {//上锁
            foreach($rows as $row){
                $one = D('Goods')->where(array('id' => $row['goods_id']), array('stock' => array('EGT', $row['num'])))->find();
                if (empty($one)) {
                    //库存不足的情况
                    $this->error = $row['name'] . "库存数量不足";
                    $this->rollback();
                    return false;
                } else {
                    //库存数量充足的情况
                    $result = M('goods')->where(array('id' => $row['goods_id']))->setDec('stock', $row['num']);//修改库存
                    if ($result === false) {
                        $this->error = "修改" . $row['name'] . "商品库存失败";
                        $this->rollback();
                        return false;
                    }
                }
            }
        }
        flock($file,LOCK_UN);//解锁
        fclose($file);//关闭文件

        //准备订单数据
        $orderinfo=array();

         //>>1.根据用户的地址id找到用户地址信息
        $address_id=$requestData['address_id'];
        $address=D('Address')->get($address_id);
        $orderinfo=array_merge($orderinfo,$address);

         //>>2.根据用户的运送id获得运送方式信息
        $delivery_id=$requestData['delivery_id'];
        $delivery=D('Delivery')->get($delivery_id);
        $orderinfo=array_merge($orderinfo,$delivery);

         //>>3.根据用户的付款方式id,获得付款方式信息
        $paytype_id=$requestData['pay_type_id'];
        $paytype=D('PayType')->get($paytype_id);
        $orderinfo=array_merge($orderinfo,$paytype);

         //>>4.准备会员id和会员时间
        $orderinfo['member_id']=UID;
        $orderinfo['inputtime']=NOW_TIME;

         //>>5.准备下单时的订单状态
        $orderinfo['order_status'] = 0;
        $orderinfo['shipping_status'] = 0;
        $orderinfo['pay_status'] = 0;

         //>>6.根据购物明细算出总价格
        $orderinfo['price'] = $price+$orderinfo['delivery_price'];  //明细的价格总和  与   运费的价格
        //将数据添加进订单中
        $order_info_id = parent::add($orderinfo);
        if($order_info_id===false){
            $this->error = '保存失败!';
            $this->rollback();
            return false;
        }

        //准备订单明细表数据
         //>>1.得到购物车中的明细
        $rows=D('ShoppingCar')->getList();
        foreach($rows as &$row){
            $row['order_info_id']=$order_info_id;
            $row['price']=$row['shop_price'];
        }
         //>>2.放入订单明细表中
        $result=D('OrderInfoItem')->addAll($rows);
        if($result===false){
            $this->error="保存订单明细失败";
            $this->rollback();
            return false;
        }


        //准备发票数据
        $invoiceinfo=array();
        $invoiceinfo['order_info_id']=$order_info_id;
        $invoice_type=$requestData['invoice_type'];
        $invoice_name=$address['receiver'];
         if($invoice_type){
             $invoice_name=$requestData['invoice_name'];
         }
        $invoiceinfo['name']=$invoice_name;
        $invoiceinfo['content']=$requestData['invoce_content'];
        $invoiceinfo['price']=$price;
        $invoice_id=D('Invoice')->add($invoiceinfo);
        if($invoice_id===false){
            $this->error='保存发票信息失败';
            $this->rollback();
            return false;
        }

        //保存发票id到对应订单中
        $arr=array('id'=>$order_info_id,'invoice_id'=>$invoice_id);
        //保存货号到订单中,货号等于:当前时间+id组成的20位数字
        $sn = date('Ymd').str_pad($order_info_id,12,0,STR_PAD_LEFT);
        $arr['sn']=$sn;
        $result=parent::save($arr);
        if($result===false){
            $this->error='更新订单信息失败';
            $this->rollback();
            return false;
        }

        $this->commit();
        return $order_info_id;
    }

    public function get($id){
       return $this->field('id,sn,price,pay_type_id')->where(array('id'=>$id))->find();
    }
}