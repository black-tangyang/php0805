<?php
namespace Admin\Model;

use Think\Model;

class DeliveryModel extends BaseModel
{
    //自动验证变量
    protected $_validate = array(
    //array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),
    array('name', 'require', '送货方式名称不能为空'),
array('price', 'require', '运费不能为空'),
array('status', 'require', '状态不能为空'),
array('sort', 'require', '排序不能为空'),
array('is_default', 'require', '是否默认地址不能为空'),
    );

    //开启批量验证
    protected $patchValidate = true;

    //自动完成变量
    protected $_auto = array(//array(完成字段1,完成规则,[完成条件,附加规则]),
    );
}