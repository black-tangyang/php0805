<?php
/**
 * Created by PhpStorm.
 * User: ty
 * Date: 2015/11/20
 * Time: 23:45
 */

namespace Home\Controller;


use Think\Controller;

class RegionController extends Controller
{
      public function getChildren($parent_id){
          $result=D('Region')->getChildren($parent_id);
          $this->ajaxReturn($result);
      }
}