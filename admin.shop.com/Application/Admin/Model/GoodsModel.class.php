<?php
namespace Admin\Model;

use Think\Model;

class GoodsModel extends BaseModel
{
    //自动验证变量
    protected $_validate = array(
        //array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),
        array('name', 'require', '名称不能为空'),
        array('sn', 'require', '货号不能为空'),
        array('goods_category_id', 'require', '父分类不能为空'),
        array('brand_id', 'require', '品牌不能为空'),
        array('supplier_id', 'require', '供货商不能为空'),
        array('shop_price', 'require', '本店价格不能为空'),
        array('market_price', 'require', '市场价格不能为空'),
        array('stock', 'require', '库存不能为空'),
        array('is_on_sale', 'require', '是否上架不能为空'),
        array('keyword', 'require', '关键字不能为空'),
        array('logo', 'require', 'LOGO不能为空'),
        array('status', 'require', '状态不能为空'),
        array('sort', 'require', '排序不能为空'),
    );

    //开启批量验证
    protected $patchValidate = true;

    //自动完成变量
    protected $_auto = array(//array(完成字段1,完成规则,[完成条件,附加规则]),
    );

    /**
     * @return bool|mixed
     * 添加
     */

    public function add($requestrows='')
    {
        //开启事务
        $this->startTrans();

        //计算商品状态值并进行添加
        $this->handleGoodsStatus();
        $id = parent::add();
        if ($id === false) {
            $this->rollback();
            return false;
        }

        //生成货号并进行添加
        $sn = date('Ymd').str_pad($id, 8, '0', STR_PAD_LEFT);
        $result = parent::save(array('sn' => $sn, 'id' => $id));
        if ($result === false) {
            $this->rollback();
            return false;
        }

        //对商品描述进行添加(单独的一张表)
        $result=M('goods_intro')->add(array('goods_id'=>$id,'intro'=>$requestrows['intro']));
        if ($result === false) {
            $this->rollback();
            return false;
        }

        //对商品的相册进行添加(单独的一张表)
        $GoodsGallery=D('GoodsGallery');
        $arr=array();
        foreach($requestrows['gallery_path'] as $value){
            $arr[]=array('goods_id'=>$id,'path'=>$value);
        }
        if(!empty($arr)) {
            $result = $GoodsGallery->addAll($arr);
        }
        if ($result === false) {
            $this->rollback();
            return false;
        }

        //对商品关联文章进行添加,添加到goods_article表中
        $arr=array();
        foreach($requestrows['article_id'] as $row){
            $arr[]=array('goods_id'=>$id,'article_id'=>$row);
        }
        if(!empty($arr)) {
           $result=M('goods_article')->addALL($arr);
        }
        if ($result === false) {
            $this->rollback();
            return false;
        }

        //对会员价格进行添加
          $result=$this->handleGoodsMemberPrice($id,$requestrows);
        if ($result === false) {
            $this->rollback();
            return false;
        }


        $this->commit();
        return $id;

    }

    /**
     * 修改
     */
    public function save($requestrows='')
    {
        $this->startTrans();
        //创建对象修改简介中的内容
        $result=M('goods_intro')->where(array('goods_id'=>$requestrows['id']))->save(array('intro'=>$requestrows['intro']));
        if ($result === false) {
            $this->rollback();
            return false;
        }

        //对商品的相册进行修改(单独的一张表)
        $GoodsGallery=D('GoodsGallery');
        $GoodsGallery->where(array('goods_id'=>$requestrows['id']))->delete();
        if(!empty($requestrows['gallery_path'])) {
           $arr=array();
            foreach ($requestrows['gallery_path'] as $value) {
                $arr[] = array('goods_id' => $requestrows['id'], 'path' => $value);
            }
            $result = $GoodsGallery->addAll($arr);
        }
        if ($result === false) {
            $this->rollback();
            return false;
        }

        //对商品的关联文章进行修改
        $result=M('goods_article')->where(array('goods_id'=>$requestrows['id']))->delete();
        if(!empty($requestrows['article_id'])) {
        $arr=array();
        foreach($requestrows['article_id'] as $row){
            $arr[]=array('goods_id'=>$requestrows['id'],'article_id'=>$row);
        }
            $result=M('goods_article')->addALL($arr);
        }
        if ($result === false) {
            $this->rollback();
            return false;
        }

        //调用商品状态值的计算方法,算出结果
        $this->handleGoodsStatus();
        $result=parent::save();
        if ($result === false) {
            $this->rollback();
            return false;
        }

        //对会员价格进行修改
        $result=$this->handleGoodsMemberPrice($requestrows['id'],$requestrows);
        if ($result === false) {
            $this->rollback();
            return false;
        }

        $this->commit();
        return true;
    }

    /**
     *计算商品状态的值,供添加和修改调用
     */
    private function handleGoodsStatus()
    {
        $status = 0;
        foreach ($this->data['goods_status'] as $value) {
            $status = $value | $status;
        }
        $this->data['goods_status'] = $status;
    }


    private function handleGoodsMemberPrice($id,$requestrows){
        $arr=array();
        foreach($requestrows['price'] as $key=>$row){
            $arr[]=array('goods_id'=>$id,'member_level_id'=>$key,'price'=>$row);
        }
        if(!empty($arr)) {
            M('goods_member_price')->where(array('goods_id'=>$id))->delete();
            return M('goods_member_price')->addAll($arr);
        }
    }
}