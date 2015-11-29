<?php
/**
 * Created by PhpStorm.
 * User: ty
 * Date: 2015/11/4
 * Time: 16:25
 */

namespace Admin\Controller;


use Think\Controller;
use Think\Upload;

class UploadifyController extends Controller
{
   public function index(){
       if (IS_POST) {
           $dir=I('post.dir');
           if(!is_dir(ROOT_PATH."Uploads/".$dir)){
               mkdir(ROOT_PATH."Uploads/".$dir,0777,ture);
           }
           if(isset($_FILES['Filedata'])) {
               $config = array(
                   'exts'          =>  array(), //允许上传的文件后缀
                   'rootPath'      =>  './Uploads/', //本地保存根路径
       //            'rootPath'      =>  './', //又拍云保存upyun根路径
                   'savePath'      =>  $dir.'/', //保存路径
                 /*  'driver'        =>  'Upyun', //又拍云 文件上传驱动
                   'driverConfig'  =>  array(
                       'host'     => 'v1.api.upyun.com', //又拍云服务器
                       'username' => 'itsource', //又拍云操作员用户
                       'password' => 'itsource', //又拍云操作员密码
                       'bucket'   => 'itsource-'.$dir, //又拍云空间名称
                       'timeout'  => 90, //超时时间), // 又拍云上传驱动配置
                   ), // 上传驱动配置*/
               );
               $upload = new Upload($config);
               $info=$upload->uploadOne($_FILES['Filedata']);
               if($info!==false){
                   echo $info['savepath'].$info['savename'];
               }else{
                   echo '上传失败'.$upload->getError();
               }

           }
   }
   }

}