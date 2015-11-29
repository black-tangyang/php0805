<?php
namespace Admin\Controller;


class RoleController extends BaseController
{
//BaseController中有model属性,可以直接调用,操作对应的表
protected $title='角色';
    protected $useallrequestdata=ture;

    //为添加,修改分配视图分配数据
    public function getcate($id){
        //要查找的字段
        $field='id,name,parent_id';
        //查询权限表中的权限(这儿限制传送url过去,否则组件会自动为节点增加a标签)
        $rows=D('Permission')->getTreeList($field);
        //转为json字符串发送过去(因为第三方组件ztree只能接受json字符串)
        $rows=json_encode($rows);
        //传送过去
        $this->assign('rows',$rows);
        //>>提供编辑回显的数据
        if(!empty($id)){
           $role_permission_list=M('role_permission')->where(array('role_id'=>$id))->select();
            $permission_list=array_column($role_permission_list,'permission_id');
            $this->assign('permission_list',json_encode($permission_list));
        }
    }
}