<?php
/**
 * Created by PhpStorm.
 * User: ty
 * Date: 2015/10/31
 * Time: 20:29
 */

namespace Admin\Model;

use Think\Model;

class SupplierModel extends BaseModel
{
    //自动验证变量
    protected $_validate = array(
        //array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),
        array('name', 'require', '供应商名字不能为空'),
        array('name', '', '供应商名字重名T_T', '', 'unique'),
        array('sort', 'require', '排序不能为空'),
    );

    //开启批量验证
    protected $patchValidate = true;

    //自动完成变量
    protected $_auto = array(//array(完成字段1,完成规则,[完成条件,附加规则]),
    );
}