<?php
namespace Admin\Controller;


class MenuController extends BaseController
{
    protected $useallrequestdata = true;
//BaseController中有model属性,可以直接调用,操作对应的表
    protected $title = '菜单管理';
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
   public function getcate($id){
       //为edit视图提供父级菜单数据
       $field="id,name,parent_id";
       $rows1=$this->model->getTreeList($field);
       $rows1=json_encode($rows1);
       $this->assign('rows1',$rows1);
       //为edit提供权限数据
       $rows2=D('Permission')->getTreeList($field);
       $rows2=json_encode($rows2);
       $this->assign('rows2',$rows2);
       //>>编辑回显
       if(!empty($id)){
           $permission_list=M('menu_permission')->where(array('menu_id'=>$id))->select();
           $permission_list=array_column($permission_list,'permission_id');
           $this->assign('permission_list',json_encode($permission_list));
       }



   }

}