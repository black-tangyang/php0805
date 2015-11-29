namespace Admin\Model;

use Think\Model;

class <?php echo $name;?>Model extends BaseModel
{
    //自动验证变量
    protected $_validate = array(
    //array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),
    <?php
    foreach($fields as $field){
    if($field['key']=='PRI' || $field['null']=="YES"){
          continue;
    }
    echo "array('{$field['field']}', 'require', '{$field['comment']}不能为空'),\r\n";
    }

    ?>
    );

    //开启批量验证
    protected $patchValidate = true;

    //自动完成变量
    protected $_auto = array(//array(完成字段1,完成规则,[完成条件,附加规则]),
    );
}