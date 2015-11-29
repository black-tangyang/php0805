<?php
/**
 * Created by PhpStorm.
 * User: ty
 * Date: 2015/11/6
 * Time: 22:00
 */

namespace Admin\Model;


class DbMysqlInterfaceIMModel implements DbMysqlInterfaceModel
{
    public function connect()
    {
        echo "connent";
        exit;
    }

    public function disconnect()
    {
        echo "disconnect";
        exit;
    }

    public function free($result)
    {
        echo "free";
        exit;
    }

    public function query($sql, array $args = array())
    {
        //接收实际传过来的参数
        $arr=func_get_args();
        //调用构建sql的方法
        $sql=$this->buildSQL($arr);
        return M()->execute($sql);
    }

    //构建sql的方法
    public function buildSQL($arr){
        $sql=array_shift($arr);
        // dump($arr);
        $sqlarr=preg_split('/\?[FNT]/',$sql);
        // dump($sqlarr);
        $sql='';
        foreach($arr as $key=>$value){
            $sql.=$sqlarr[$key].$value;
        }
        return $sql;
    }


    public function insert($sql, array $args = array())
    {
        $params = func_get_args();
        $sql = $params[0];
        $sql =  str_replace('?T',$params[1],$sql);

        //将插入的值的连接
        $values = array();
        foreach($params[2] as $k=>$v){
            if($k=='id'){//为什么加id会报错
                continue;
            }
            $values[] = "$k='$v'";
        }
        $values = implode(',',$values);

        //将插入的值替换到$sql中
        $sql =  str_replace('?%',$values,$sql);
        $result = M()->execute($sql);
        if($result!==false){
            //执行成功之后要返回id
            return M()->getLastInsID();
        }else{
            return false;//执行失败,返回false
        }
    }

    public function update($sql, array $args = array())
    {
        echo "update";
        exit;
    }

    public function getAll($sql, array $args = array())
    {
        echo "getAll";
        exit;
    }

    public function getAssoc($sql, array $args = array())
    {
        echo "getAssoc";
        exit;
    }

    public function getRow($sql, array $args = array())
    {
       //接收实际传过来的参数
        $arr=func_get_args();
        //调用构建sql的方法
        $sql=$this->buildSQL($arr);

        $result=M()->query($sql);
        if(!empty($result)){
            return $result[0];
        }
    }

    public function getCol($sql, array $args = array())
    {
        echo "getCol";
        exit;
    }

    public function getOne($sql, array $args = array())
    {
        $arr=func_get_args();
        $sql=$this->buildSQL($arr);
        $result=M()->query($sql);
        //获取结果中的第一个值
        $values = array_values($result[0]);
        return $values[0];

    }

}