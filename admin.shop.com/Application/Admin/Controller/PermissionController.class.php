<?php
namespace Admin\Controller;


class PermissionController extends BaseController
{
//BaseController中有model属性,可以直接调用,操作对应的表
protected $title='权限';

    public function index()
    {

        //创建一个缓存变量__foreword__使编辑,删除修改,添加之后能直接返回到之前的页面
        cookie('__foreword__', $_SERVER['REQUEST_URI']);

        //通过模型调用得到当前页的数据列表
        $result = $this->model->getTreeList();

        //将数据列表指派给供应商首页(index页面)
        $this->assign('rows', $result);

        //显示列表(index)
        $this->assign('title',$this->title);
        $this->display('index');
    }


    /**
     * 调用钩子函数
     */
    public function getcate(){
        //要查找的字段
        $field='id,name,parent_id';
        //查询权限表中的权限(这儿限制传送url过去,否则组件会自动为节点增加a标签)
         $rows=$this->model->getTreeList($field);
        //转为json字符串发送过去(因为第三方组件ztree只能接受json字符串)
         $rows=json_encode($rows);
        //传送过去
         $this->assign('rows',$rows);

    }



}