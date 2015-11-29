<?php
namespace Admin\Model;

use Admin\Service\NestedSetsService;
use Think\Model;

class GoodsCategoryModel extends BaseModel
{
    //自动验证变量
    protected $_validate = array(
    //array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),
    array('name', 'require', '名称不能为空'),
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

    /**
     * @param array $where
     * @return array
     * 查找分类
     */
    public function getResult($where=array())
    {
        //在where条件中添加搜索status不为-1的状态
        $where['status']=array('NEQ', -1);


        //获得当前页的所有记录
        $rows = $this->where($where)->order('lft')->select();


        $result = array(
            'rows' => $rows,
        );
        return $result;
    }

    /**
     * 添加
     */

    public function add(){

        //生成符合分类为插入接口的对象
        $DbMysqlInterfaceIMModel=new DbMysqlInterfaceIMModel();
        //生成分类对象
        $NestedSetsService= new NestedSetsService($DbMysqlInterfaceIMModel,'goods_category','lft','rght','parent_id','id','level');
        //执行插入语句
        $NestedSetsService->insert($this->data['parent_id'], $this->data, 'bottom');
    }

    /**
     * 更新
     */

    public function save(){
        //生成符合分类为插入接口的对象
        $DbMysqlInterfaceIMModel=new DbMysqlInterfaceIMModel();
        //生成分类操作对象
        $NestedSetsService= new NestedSetsService($DbMysqlInterfaceIMModel,'goods_category','lft','rght','parent_id','id','level');
        //执行移动
        $result=$NestedSetsService->moveUnder($this->data['id'], $this->data['parent_id'], $position = 'bottom');
        if($result===false){
            $this->error="父类不能移动到子类中";
            return false;
        }
        //调用父类的方法,保存修改的数据
        parent::save();
    }

    /**
     * @param $id
     * @param $status
     * @return bool
     * 改变状态
     */
    public function changeStatus($id, $status)
    {
        //找到id以及该id作为其他子类的parent_id的子类id
        $sql = "select  child.id   from goods_category as parent,goods_category as child where child.lft>=parent.lft and child.rght<=parent.rght and parent.id = $id";
        $rows = $this->query($sql);
        $ids =  array_column($rows,"id");

        parent::changeStatus($ids,$status);

    }

}