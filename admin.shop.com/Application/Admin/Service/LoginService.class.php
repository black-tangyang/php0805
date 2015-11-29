<?php
/**
 * Created by PhpStorm.
 * User: ty
 * Date: 2015/11/12
 * Time: 1:14
 */

namespace Admin\Service;


use Org\Util\String;

class LoginService
{
    /**
     * @param $post
     * 验证用户名和密码
     */
    public function verifyusr($post){
        $email=$post['email'];
        $password=$post['password'];
        $m=D('Admin');
        $row=$m->where("email='{$email}'")->find();
        if($row===null){
            return false;
        }
        $password=md5($password.$row['salt']);
        $result=$m->where("email='{$email}' and password='{$password}'")->field('id,username')->find();
        if($result===null){
            return false;
        }
        return $result;
    }

    /**
     * 保存当前用户拥有的访问权限url
     */
    public function getUserPermissionUrls($admin_id){
        $sql = "select  distinct id,url from permission  where id in
        (select  distinct rp.permission_id from  admin_role as ar  join role_permission as rp on ar.role_id = rp.role_id  where ar.admin_id = $admin_id)
        or id in(select  ap.permission_id from admin_permission as ap where ap.admin_id = $admin_id);";

        $rows =   M()->query($sql);
        return $rows;
    }

    /**
     * @param $admin_id
     * 保存auto_key到数据库,并将auto_key,和id保存到cookie中
     */
    public function saveAutoInfo($admin_id){
        //>>1.随机生成一个auto_key,并将auto_key保存到登录用户记录的数据库中
             $auto_key=String::randString();
             $result=M('admin')->where(array('id'=>$admin_id))->save(array('auto_key'=>$auto_key));
        if($result===false){
            return false;
        }
        //>>2.将auto_key以及用户的id一起保存到缓存中
        $arr=array();
        $arr['auto_key']=$auto_key;
        $arr['id']=$admin_id;
        saveAutoLogin($arr);
    }


    /**
     * 自动登录方法
     */
    public function autoLogin(){
        $arr=saveAutoLogin();
        if($arr!==null) {
            $result = M('admin')->where($arr)->find();
            if ($result !== null) {
                $rows = $this->getUserPermissionUrls($result['id']);
                userUrl($rows);
                login($result);
                redirect(U(CONTROLLER_NAME.'/'.ACTION_NAME));
                exit;
            }
        }
    }


}