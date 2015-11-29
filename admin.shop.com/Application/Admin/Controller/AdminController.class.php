<?php
namespace Admin\Controller;


class AdminController extends BaseController
{
//BaseController中有model属性,可以直接调用,操作对应的表
    protected $title = '管理员';
    protected $useallrequestdata = true;

    //在edit.html视图显示之前为视图准备数据
    public function getcate($id)
    {
        //为视图准备角色的数据
        $rolelist = D('Role')->getShowList('', 'id,name');
        $this->assign('rolelist', $rolelist);
        //为视图准备权限树数据
        $field = "id,name,parent_id";
        $rows = D('Permission')->getTreeList($field);
        $rows = json_encode($rows);
        $this->assign('rows', $rows);
        //>>提供编辑回显的数据
        if (!empty($id)) {
            $role_permission_list = M('admin_permission')->where(array('admin_id' => $id))->select();
            $permission_list = array_column($role_permission_list, 'permission_id');
            $this->assign('permission_list', json_encode($permission_list));
        }
    }

    /**
     * @param $id
     * 初始化密码
     */
    public function resetPassword($id)
    {
        $result=$this->model->resetPassword($id);
        if($result===false){
            $this->error('重置密码失败!');
        }else{
            $this->success('重置密码成功!',cookie('__forward__'));
        }
    }


}