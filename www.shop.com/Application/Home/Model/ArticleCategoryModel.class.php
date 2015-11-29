<?php
/**
 * Created by PhpStorm.
 * User: ty
 * Date: 2015/11/14
 * Time: 15:33
 */

namespace Home\Model;


use Think\Model;

class ArticleCategoryModel extends Model
{
    public function getArticleCategoryList($field='*'){
        //判断redis缓存是否为空(前提是配置了S方法,将缓存存到了redis中,否则S方法是存到本地中的)
        $goodscategorylist=S('goodscategorylist');
        if(empty($goodscategorylist)){
            //搜索分类列表
            $goodscategorylist = $this->where("status>0 && is_help=1")->field($field)->select();
            if($goodscategorylist===false) {
                return;
            }
            //将搜索出的分类列表存到缓存中
            S('goodscategorylist', $goodscategorylist);
        }
        return $goodscategorylist;
    }


}