<?php
/**
 * Created by PhpStorm.
 * User: ty
 * Date: 2015/11/11
 * Time: 22:46
 */

namespace Admin\Controller;


use Think\Controller;
use Think\Verify;


class VerifyController extends Controller
{
    /**
     * 生成验证码
     */
 public function index(){
     $verify=new Verify();
     $verify->entry();
 }
}