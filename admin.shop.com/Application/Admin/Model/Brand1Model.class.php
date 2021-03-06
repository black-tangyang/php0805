<?php
namespace Admin\Model;

use Think\Model;

class Brand1Model extends BaseModel
{
    //自动验证变量
    protected $_validate = array(
    //array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),
    array('name', 'require', '品牌名称不能为空'),
array('url', 'require', '品牌网址不能为空'),
array('logo', 'require', '品牌LOGO不能为空'),
array('status', 'require', '状态显示不能为空'),
array('sort', 'require', '排序不能为空'),
    );

    //开启批量验证
    protected $patchValidate = true;

    //自动完成变量
    protected $_auto = array(//array(完成字段1,完成规则,[完成条件,附加规则]),
    );
}