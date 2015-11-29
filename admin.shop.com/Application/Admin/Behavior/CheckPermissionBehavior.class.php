<?php
namespace Admin\Behavior;

use Think\Behavior;

class CheckPermissionBehavior extends Behavior
{
    public function run(&$params)
    {
        //
       //判断当前访问的url在不在这个数组中,如果在就直接访问
        $accessarr=array('Login/login','Login/logout');
        $requestURL = CONTROLLER_NAME.'/'.ACTION_NAME;
        if(in_array($requestURL,$accessarr)){
            return;
        }

        //判断用户是否登录,如果未登录直接重定向到登录页面
        if(!islogin()){
            $loginService = D('Login','Service');
            $loginService->autoLogin();
            redirect(U('Login/login'),1,'请登陆!');
            exit;
        }

        //判断是否是超级管理员
        if(isSuperUser()){
            return;
        }

        //最后在判断是否有访问某个控制器里方法的权限;
        $arr=userUrl();
        $arr=array_column($arr,'url');
        if(!in_array($requestURL,$arr)){
            echo "没有该权限";
            exit;
        }

    }

}