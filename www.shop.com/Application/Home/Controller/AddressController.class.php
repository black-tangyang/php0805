<?php
/**
 * Created by PhpStorm.
 * User: ty
 * Date: 2015/11/20
 * Time: 22:45
 */

namespace Home\Controller;


use Think\Controller;

class AddressController extends Controller
{

    public function _initialize(){
        if(!isLogin()){
            cookie('__LOGIN_RETURN_URL__',$_SERVER['REQUEST_URI']);
            $this->error('请登录!',U('Member/login'));
        }
    }

    public function index(){
        //获得三级联动菜单中省份的信息
        $provinceinfos=D('Region')->getChildren();
        $this->assign('provinceinfos',$provinceinfos);

        //查找用户所保存的地址
        $addresses=D('Address')->getAddresses(UID);
        $this->assign('addresses',$addresses);
        $this->display('index');
    }

    /**
     * 添加用户地址
     */
    public function add(){
        $model=D('Address');
        $data=$model->create();
        if(empty($data['id'])) {
            $result = $model->add();
            if ($result !== false) {
                $this->success('添加成功', U('index'));
            } else {
                $this->error('添加失败');
            }
        }else{
            $result = $model->save();
            if ($result !== false) {
                $this->success('修改成功', U('index'));
            } else {
                $this->error('修改失败');
            }
        }
    }



    /**
     * 删除地址
     */
    public function remove($id){
        $model=D('Address');
        $result=$model->remove($id);
        if($result!==false){
            $this->success('删除成功',U('index'));
        }else{
            $this->error('删除失败');
        }
    }

    /**
     * 修改地址
     */
    public function edit($id){
        $addressModel = D('Address');
        $address = $addressModel->find($id);
        $this->ajaxReturn($address);
    }
}