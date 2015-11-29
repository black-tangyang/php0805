<?php
namespace Admin\Model;

use Think\Model;

class ArticleModel extends BaseModel
{
    //自动验证变量
    protected $_validate = array(
    //array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),
    array('name', 'require', '标题不能为空'),
array('article_category_id', 'require', '文章分类不能为空'),
array('times', 'require', '浏览次数不能为空'),
array('inputtime', 'require', '录入时间不能为空'),
array('status', 'require', '状态不能为空'),
array('sort', 'require', '排序不能为空'),
    );

    //开启批量验证
    protected $patchValidate = true;

    //自动完成变量
    protected $_auto = array(//array(完成字段1,完成规则,[完成条件,附加规则]),
        array('inputtime',NOW_TIME),
    );
}