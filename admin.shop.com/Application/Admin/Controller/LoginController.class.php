<?php
/**
 * Created by PhpStorm.
 * User: ty
 * Date: 2015/11/11
 * Time: 22:39
 */

namespace Admin\Controller;


use Admin\Model\LoginModel;
use Think\Controller;

class LoginController extends Controller
{
    /**
     * 显示登录页面和验证登录
     */
    public function login(){
          if(IS_POST){
                $post=I("post.",'',false);
              //生成service文件夹中的工具类对象
              $loginService = D('Login','Service');
              $result=$loginService->verifyusr($post);
              if($result!==false){
                  $rows=$loginService->getUserPermissionUrls($result['id']);
                  //存储自动登录的信息
                  if($post['remember']) {
                      $loginService->saveAutoInfo($result['id']);
                  }
                  userUrl($rows);
                  login($result);
                  $this->success('登录成功',U('Index/index'),1);
              }else{
                  $this->error("登录失败");
              }
          }else{
              $this->display('login');
          }
    }

    /**
     * 退出登录
     */
    public function logout(){
          logout();
        $this->redirect('Login/login');
    }
}