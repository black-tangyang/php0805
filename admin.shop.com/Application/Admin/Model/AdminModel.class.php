<?php
namespace Admin\Model;

use Think\Model;

class AdminModel extends BaseModel
{
    //自动验证变量
    protected $_validate = array(
    //array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),
        array('username', 'require', '用户名不能为空', ''),
        array('username', '', '用户名重复了', '', 'unique'),
        array('password', 'require', '密码不能为空'),
        array('email', 'require', 'Email不能为空'),
        array('email', 'email', 'Email格式不对'),
        array('email', '', '邮箱重复了', '', 'unique'),
        array('add_time', 'require', '加入时间不能为空'),
        array('last_login_time', 'require', '最后登录时间不能为空'),
        array('salt', 'require', '盐不能为空'),
        array('status', 'require', '状态不能为空'),
        array('sort', 'require', '排序不能为空'),
    );

    //开启批量验证
    protected $patchValidate = true;

    //自动完成变量
    protected $_auto = array(//array(完成字段1,完成规则,[完成条件,附加规则]),
        array('add_time',NOW_TIME),
        array('salt','\Org\Util\String::randString','','function'),
    );


    public function add($requestdata){
        //对密码进行加盐加密
        $this->data['password']=md5($this->data['password'].$this->data['salt']);
        //添加对应admin表里的数据
        $id=parent::add();
        if($id===false){
            return false;
        }
        $result=$this->handleadminrelation($id,$requestdata);
        if($result===false){
            return false;
        }
        return $id;
    }

    public function save($requestdata){
        $result=parent::save();
        if($result===false){
            return false;
        }
        $result1=$this->handleadminrelation($requestdata['id'],$requestdata);
        if($result1===false){
            return false;
        }
        return $result;
    }

    private function handleadminrelation($admin_id,$requestdata){
        //添加对应admin_role表里的数据
        $role_ids=$requestdata['role_ids'];
        $arr=array();
        M('admin_role')->where(array('admin_id'=>$admin_id))->delete();
        foreach($role_ids as $role_id){
            $arr[]=array('admin_id'=>$admin_id,'role_id'=>$role_id);
        }
        if(!empty($arr)) {
            $result = M('admin_role')->addAll($arr);
            if ($result === false) {
                return false;
            }
        }
        //添加对应admin_permission表里的数据
        $permission_ids=$requestdata['permission_ids'];
        $arr=array();
        M('admin_permission')->where(array('admin_id'=>$admin_id))->delete();
        foreach($permission_ids as $permission_id){
            $arr[]=array('admin_id'=>$admin_id,'permission_id'=>$permission_id);
        }
        if(!empty($arr)) {
            $result = M('admin_permission')->addAll($arr);
            if ($result === false) {
                return false;
            }
        }
    }

    /**
     * @param $id
     * 初始化密码
     */

    public function resetPassword($id)
    {
      $this->data=$this->where(array('id'=>$id))->find();
        $this->data['password']=md5('111111'.$this->data['salt']);
        return parent::save();
    }
}