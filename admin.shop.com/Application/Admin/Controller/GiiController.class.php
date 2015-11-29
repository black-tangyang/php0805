<?php
/**
 * Created by PhpStorm.
 * User: ty
 * Date: 2015/11/3
 * Time: 18:37
 */

namespace Admin\Controller;


use Think\Controller;

class GiiController extends Controller
{
public function index(){
    if(IS_POST){
        $table_name=I('post.table_name');
        if($table_name!==''){

            //-------------------------------为模板中的变量准备值
            //定义一个查找模板的路径
            defined('TEMPLATE_PATH') or define('TEMPLATE_PATH',ROOT_PATH.'Template/');

           //将表名转化为规范的类名
            $name = parse_name($table_name,1);
            //查找表名对应的$title
            $sql="SELECT TABLE_COMMENT FROM information_schema.`TABLES` WHERE TABLE_NAME='{$table_name}'";
            $m=M();
            $rows=$m->query($sql);
            $title=$rows[0]['table_comment'];


            //获得了每个字段comment里的信息,加入有类型和值得,直接提出来变成一个独立的元素加入到fields数组中
            $sql = "show full columns from ".$table_name;
            $fields = M()->query($sql);
            $reg1="/(.*)@([a-z]*)\|?(.*)/";
            foreach($fields as &$field){
                if(preg_match($reg1,$field['comment'],$result)){
                    $field['comment']=$result[1];
                    $field['input_type']=$result[2];
                    if(!empty($result[3])){
                        parse_str($result[3],$arr);
                        $field['option_values']=$arr;
                    }
                }
            }
            unset($field);



            //-----------------------------------生成该表对应的控制器
            ob_start();
            require TEMPLATE_PATH."Controller.tpl";
            //获得控制器模板里的内容
            $controller_content=ob_get_clean();
            $controller_content="<?php\r\n".$controller_content;
            $controller_path=APP_PATH."Admin/Controller/".$name."Controller.class.php";
            file_put_contents($controller_path,$controller_content);




            //-----------------------------------生成该表对应的模型
            ob_start();
            require TEMPLATE_PATH."Model.tpl";
            //获得模型模板中的内容
            $model_content=ob_get_clean();
            $model_content="<?php\r\n".$model_content;
            $model_path=APP_PATH."Admin/Model/".$name."Model.class.php";
            file_put_contents($model_path,$model_content);



            //-----------------------------------生成表对应的视图
            ob_start();
            require TEMPLATE_PATH."index.tpl";
            $view_content=ob_get_clean();
            $view_path=APP_PATH."Admin/View/".$name;
            if(!is_dir($view_path)){
                mkdir($view_path,0777,true);
            }
            $view_path=$view_path."/index.html";
            file_put_contents($view_path,$view_content);

            ob_start();
            require TEMPLATE_PATH."edit.tpl";
            $view_content=ob_get_clean();
            $view_path=APP_PATH."Admin/View/".$name."/edit.html";
            file_put_contents($view_path,$view_content);


        }else{
            echo "未填写表名";
        }
    }else{
        $this->assign('title','gii');
        $this->display('index');
    }

}
}