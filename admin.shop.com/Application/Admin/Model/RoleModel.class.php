<?php
namespace Admin\Model;

use Think\Model;

class RoleModel extends BaseModel
{
    //自动验证变量
    protected $_validate = array(
    //array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),
    array('name', 'require', '角色名称不能为空'),
array('status', 'require', '状态不能为空'),
array('sort', 'require', '排序不能为空'),
    );

    //开启批量验证
    protected $patchValidate = true;

    //自动完成变量
    protected $_auto = array(//array(完成字段1,完成规则,[完成条件,附加规则]),
    );

    public function add($resquestdata){
        //调用父类中的add方法将添加表中的数据插入进去(除了角色和权限的关系)
        $id=parent::add();
        if($id===false){
            return false;
        }
        //插入角色和权限的关系进出role_permission表
        $this->handle_role_permission($id,$resquestdata['permission_ids']);
        return $id;
    }

    public function save($resquestdata){
       $result=parent::save();
        if($result===false){
            return false;
        }
        //修改角色和权限的关系进出role_permission表
        $this->handle_role_permission($resquestdata['id'],$resquestdata['permission_ids']);
        return $result;

    }

   /**
    *     //插入角色和权限的关系进出role_permission表
    */
    private function handle_role_permission($role_id,$permission_ids){
        $arr=array();
        foreach($permission_ids as $permission_id){
            $arr[]=array('role_id'=>$role_id,'permission_id'=>$permission_id);
        }
        M('role_permission')->where(array('role_id'=>$role_id))->delete();
        if(!empty($arr)){
            $result=M('role_permission')->addAll($arr);
            if($result===false){
                return false;
            }
        }
    }


}