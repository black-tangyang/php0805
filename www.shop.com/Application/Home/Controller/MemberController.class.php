<?php
/**
 * Created by PhpStorm.
 * User: ty
 * Date: 2015/11/16
 * Time: 20:05
 */

namespace Home\Controller;


use Think\Controller;

class MemberController extends Controller
{
    /**
     * 验证js传递过来的表单元素值是否已经使用
     */
    public function check(){
        //js验证插件接收传递过来的要验证的值
        $get=I('get.');
        //创建对象调用方法进行验证
        $result=D('Member')->check($get);
        //将结果转为json对象响应回去
        $this->ajaxReturn($result);
    }

    /**
     * 注册用户
     */
    public function regist(){
        if(IS_POST) {
            //>>1.注册前先进行验证码的验证
            $verify=I('post.checkcode');
            if($verify!=session('PHONE_VERIFY')){
             $this->error('验证码错误');
            }
            //>>2.建立模型插入注册数据
            $membermodel=D('Member');
            if($membermodel->create()!==false){
            $result=$membermodel->add();
            if($result!==false){
                //注册成功
                $this->success('注册成功',U('login'),1);
               }
            }else{
                $this->error('注册失败');
            }

        }else{
            $this->display('regist');
        }
    }


    /**
     * @param $tel
     * 根据电话号码
     * 发送手机短信验证码
     */
    public function sendSMS($tel){
         //根据电话号码发送验证码
        $return=D('Member')->sendSMS($tel);
        //返回发送是否成功的结果
        $this->ajaxReturn($return);
    }

    /**
     * 激活用户
     */
    public function activeUser($id,$mail_key){
        $result=D('Member')->activeUser($id,$mail_key);
        if($result===false){
            $this->error('激活失败!');
        }else {
            $this->success("激活成功!", U('login'));
        }
    }

    /**
     * 用户登录
     */
    public function login(){
        if(IS_POST){
         //>>1.接收用户的用户名,密码
            $post=I('post.');
            //$username=I('post.username');
            //$password=I('post.password');
            //>>2.将用户名密码传入进行验证
            $m=D('Member');
            $result=$m->login($post);
            //>>3.根据判断用户是否登录成功
            if(is_array($result)){
                $arr=array(
                    'user_id'=>$result['id'],
                    'username'=>$result['username'],
                );
                defined('UID') or define('UID',$result['id']);
                D('ShoppingCar')->cookie2Db();
                login($arr);
                $url=U('Index/index');
                $login_return_url=cookie('__LOGIN_RETURN_URL__');
                if(!empty($login_return_url)){
                     $url=$login_return_url;
                }
                $this->success('登录成功',$url,1);
            }else{
                $this->error("登录失败".$m->getError());
            }

        }else{
            $this->display();
        }
    }

    /**
     * 退出登录
     */
    public function logout(){
        logout();
        $this->success('退出成功',U('Index/index'));
    }
}