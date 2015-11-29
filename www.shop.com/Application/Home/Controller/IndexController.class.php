<?php
namespace Home\Controller;

use Think\Cache\Driver\Redis;
use Think\Controller;

class IndexController extends Controller
{
    public function _initialize(){
        //查找商品分类数据,并将数据指派给视图
        $field='id,name,parent_id,level';
        $goodscategorylist=D('GoodsCategory')->getGoodsCategoryList($field);
        $this->assign('goodscategorylist',$goodscategorylist);

        //查找文章帮助分类数据,并将数据指派给视图
        $field='id,name';
        $articlecategoryList=D('ArticleCategory')->getArticleCategoryList($field);
        $this->assign('articlecategoryList',$articlecategoryList);

        //查找文章数据,并指派给视图,让其显示在对应分类下
        $articleList=D('Article')->getArticleList();
        $this->assign('articleList',$articleList);

        //查找文章快报数据,并指派给视图
        $fastnews=D('Article')->getFastNews();
        $this->assign('fastnews',$fastnews);
    }

    public function index()
    {
        //得到商品状态以及对应的行的数组
        $arr=D('Goods')->getGoodsstatusRowsArr();
        $this->assign(
            array(
                'arr1'=>$arr[0],
                'arr2'=>$arr[1],
                'arr4'=>$arr[2],
                'arr8'=>$arr[3],
                'arr16'=>$arr[4],
                'isNotHiddenMenu'=>false,
                'meta_title'=>'京西商城首页',
            )
        );
        $this->display('index');
    }

    public function show($id)
    {

        //得到对应id的商品信息
        $goodsinfo=D('Goods')->getGoodsInfoById($id);

        //得到对应id的商品相册
        $goodsgallery=D('GoodsGallery')->getGoodsGalleryById($id);
        $goodsinfo['goodsgallery']=array_column($goodsgallery,'path');

        //得到对应的id商品的分类(从父类到子类都得到)
        $goodsinfo['goodscategory']=D('GoodsCategory')->getParentCategory($goodsinfo['goods_category_id']);

        $this->assign($goodsinfo);
        $this->assign('isNotHiddenMenu',true);
        $this->assign('meta_title','商品列表');
        $this->display('show');
    }


    public function lst()
    {
        $this->assign('isNotHiddenMenu',true);
        $this->assign('meta_title','京西商城---XXXX商品');
        $this->display('lst');
    }

    /**
     * 得到用户的登录信息
     */
    public function getUserName(){
        if(login()){
            $userinfo=login();
            $logouturl=U('Member/logout');
            $userinfo['logouturl']=$logouturl;
            $this->ajaxReturn($userinfo);
        }
    }

    /**
     * 增加某一商品浏览次数一次
     */
    public function lookGoodsTimes($goods_id){
        $redis= new \Redis();
        $redis->connect('127.0.0.1');
        $redis->incr("goods_click_times:$goods_id");
    }

    public function goodsClickTimesRedis2Db(){
         //获取redis中商品id以及访问量次数
        $redis= new \Redis();
        $redis->connect('127.0.0.1');
        $arrkeys=$redis->keys('goods_click_times:*');
        $arrvalue=$redis->mget($arrkeys);
        foreach($arrkeys as $i=>$key){
            $key=ltrim($key,'goods_click_times:');
            $m=D('GoodsTimes');
            $count=$m->where(array('goods_id'=>$key))->count();
            if($count>0){
                $m->where(array('goods_id'=>$key))->setInc('times',$arrvalue[$i]);
            }else{
                $m->add(array('goods_id'=>$key,'times'=>$arrvalue[$i]));
            }
        }
        $redis->del($arrkeys);

    }
}