<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function menu(){

        //为视图准备数据
        $field='id,name,parent_id,url,level';
        $menulist=$this->getUserMenu();
        $this->assign('menulist',$menulist);

        //显示视图
        $this->display('menu');
    }

    /**
     * @param $field
     * 得到用户权限对应的菜单项
     */

    private function getUserMenu(){
        $arr=userUrl();
        $arr=array_column($arr,'id');
        $permission_id=implode(',',$arr);
        $sql="select distinct m.id,m.name,m.url,m.level,m.parent_id from menu as m join menu_permission as mp on m.id=mp.menu_id where mp.permission_id in ($permission_id)";
        return M()->query($sql);
    }

}