<?php
namespace Admin\Model;

use Admin\Service\NestedSetsService;
use Think\Model;

class PermissionModel extends BaseModel
{
    //自动验证变量
    protected $_validate = array(
    //array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),
    array('name', 'require', '权限名称不能为空'),
array('url', 'require', '权限的URL不能为空'),
array('parent_id', 'require', '父权限不能为空'),
array('lft', 'require', '左边界不能为空'),
array('rght', 'require', '右边界不能为空'),
array('level', 'require', '级别不能为空'),
array('status', 'require', '状态不能为空'),
array('sort', 'require', '排序不能为空'),
    );

    //开启批量验证
    protected $patchValidate = true;

    //自动完成变量
    protected $_auto = array(//array(完成字段1,完成规则,[完成条件,附加规则]),
    );


    public function add(){
        $DbMysqlInterfaceIMModel=new DbMysqlInterfaceIMModel();
        $NestedSetsService=new NestedSetsService($DbMysqlInterfaceIMModel,'permission','lft','rght','parent_id','id','level');
        $result=$NestedSetsService->insert($this->data['parent_id'],$this->data,'bottom');
        return $result;
    }

    public function save(){
        $DbMysqlInterfaceIMModel=new DbMysqlInterfaceIMModel();
        $NestedSetsService=new NestedSetsService($DbMysqlInterfaceIMModel,'permission','lft','rght','parent_id','id','level');
        $result=$NestedSetsService->moveUnder($this->data['id'],$this->data['parent_id']);
        if($result===false){
            $this->error="不能移动到其自身以及自身一下的权限";
            return false;
        }
        return parent::save();
    }
}