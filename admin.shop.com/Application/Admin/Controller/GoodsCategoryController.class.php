<?php
namespace Admin\Controller;


class GoodsCategoryController extends BaseController
{
//BaseController中有model属性,可以直接调用,操作对应的表
protected $title='商品分类';
    public function index()
    {
        //获得传送过来的关键字
        $keyword=I('get.keyword');

        //解码关键字
        // $keyword=urldecode($keyword);

        //将关键字设置成模糊搜索的条件
        $where=array('name'=>array('like',"%{$keyword}%"));


        //创建一个缓存变量__foreword__使编辑,删除修改,添加之后能直接返回到之前的页面
        cookie('__foreword__', $_SERVER['REQUEST_URI']);

        //通过模型调用getResult方法,获得分页工具条html和当前页的数据列表
        $result = $this->model->getResult($where);

        //将工具条和数据列表指派给供应商首页(index页面)
        $this->assign('rows', $result['rows']);

        //显示列表(index)
        $this->assign('title',$this->title);
        $this->display('index');
    }


    //插入分类数据的钩子函数
   public function getcate(){
       $rows=$this->model->where("status>=0")->order('lft')->select();
       $rows=json_encode($rows);
       $this->assign('rows',$rows);
   }

}