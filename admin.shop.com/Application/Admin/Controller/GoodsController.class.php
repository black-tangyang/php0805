<?php
namespace Admin\Controller;


class GoodsController extends BaseController
{
//BaseController中有model属性,可以直接调用,操作对应的表
protected $title='商品';

    /**
     * 钩子函数提供给父类
     */
    public function getcate()
    {
        //建立商品分类对象查找出商品分类的所有数据
        $rows = D('GoodsCategory')->getShowList();
        $rows = json_encode($rows);
        $this->assign('rows', $rows);

        //建立品牌对象查找出品牌的所有数据
        $rows = D('Brand')->getShowList();
        $this->assign('brandlist', $rows);

        //建立供货商对象查找出供货商的所有数据
        $rows = D('Supplier')->getShowList();
        $this->assign('Supplierlist', $rows);

        //建立会员等级对象,查找出id,name
        $rows = D('MemberLevel')->getShowList();
        $this->assign('MemberLevellist', $rows);

        //>>4.当编辑时
        $id = I('get.id', '');
        if (!empty($id)) {
            //>>a.查询`goods_intro`表(简介),获得里面的简介,然后传给视图,回显商品简介
            $intro = M('goods_intro')->getFieldByGoods_id($id, 'intro');
            $this->assign('intro', $intro);

            //>>b.查询`goods_gallery`表(相册),获得里面的相册路径,以及id,这儿将接受的id名字变为goods_gallery_id在传入视图
            //避免和商品的id起冲突
            $GoodsGallery = D('GoodsGallery');
            $goods_gallery_rows = $GoodsGallery->getGalleryByGoods_id($id);
            $this->assign('goods_gallery_rows', $goods_gallery_rows);

            //>>c.查找关联文章
            $goods_article = M('goods_article');
            $sql = "SELECT  a.id,a.name  FROM goods_article as ga  join article as a on ga.article_id = a.id  where  ga.goods_id = {$id};";
            $goods_articlelist = $goods_article->query($sql);
            $this->assign('goods_articlelist', $goods_articlelist);

            //>>d.回显会员价格
            $goods_member_pricelist = M('goods_member_price')->field("member_level_id,price")->where(array('goods_id' => $id))->select();
            $member_level_id = array_column($goods_member_pricelist, 'member_level_id');
            $price = array_column($goods_member_pricelist, 'price');
            $arr = array_combine($member_level_id, $price);
            $this->assign('pricearr', $arr);
        }
    }

    /**
     * 添加
     */
    public function add()
    {
        if (IS_POST) {
           //接收post的值
            $requestrows=I('post.');
            //接收post中intro的值,让他不做编码处理,并将它覆盖$requestrows中的intro
            $requestrows['intro']=I('post.intro','',false);
            //create方法接收请求数据
            if ($this->model->create()) {

                //用模型对象存入数据并返回结果
                if ($this->model->add($requestrows) !== false) {
                    $this->success('添加成功', cookie('__foreword__'), 1);
                    return;
                }
            }
            $this->error('操作失败' . showError($this->model));

        } else {
            //调用钩子函数
            $this->getcate();
            $this->assign('title', "添加".$this->title);
            $this->display('edit');
        }
    }




    /**
     * 编辑方法
     */

    public function edit()
    {
        if (IS_POST) {

            //接收post的值
            $requestrows=I('post.');
            //接收post中intro的值,让他不做编码处理,并将它覆盖$requestrows中的intro
            $requestrows['intro']=I('post.intro','',false);

            //create方法接收请求数据
            if ($this->model->create()) {

                //用模型对象修改数据并返回结果
                if ($this->model->save($requestrows) !== false) {
                    $this->success('修改成功', cookie('__foreword__'), 1);
                    return;
                }
            }
            $this->error('操作失败' . showError($this->model));

        } else {

            //接收请求参数id
            $id = I('get.id');

            //获得请求参数id在供应商表中所在行的记录并传给模板(起到数据回显)
            $row = $this->model->where(array('id' => $id))->select();
            $this->assign($row[0]);

            //调用钩子函数
            $this->getcate();

            //将请求参数传给模板
            $this->assign('title', "编辑".$this->title);

            //显示模板
            $this->display('edit');
        }
    }

}