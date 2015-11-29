<?php
/**
 * Created by PhpStorm.
 * User: ty
 * Date: 2015/11/3
 * Time: 10:23
 */

namespace Admin\Controller;


use Think\Controller;

class BaseController extends Controller
{
    //模型对象属性
    protected $model;
    protected $useallrequestdata=false;
    /**
     * 能够被Controller控制器中构造方法调用的方法
     */
    protected function _initialize(){
        //创建当前控制器表模型对象
        $this->model=D(CONTROLLER_NAME);
    }
    /**
     * 列表显示方法
     */
    public function index()
    {
        //获得传送过来的关键字
        $keyword=I('get.keyword');

        //解码关键字
        // $keyword=urldecode($keyword);

        //将关键字设置成模糊搜索的条件
        $where=array('name'=>array('like',"%{$keyword}%"));


        //创建一个缓存变量__foreword__使编辑,删除修改,添加之后能直接返回到之前的页面
        cookie('__foreword__', $_SERVER['REQUEST_URI']);

        //通过模型调用getResult方法,获得分页工具条html和当前页的数据列表
        $result = $this->model->getResult($where);

        //将工具条和数据列表指派给供应商首页(index页面)
        $this->assign('rows', $result['rows']);
        $this->assign('tool', $result['tool']);

        //显示列表(index)
        $this->assign('title',$this->title);
        $this->display('index');
    }


    /**
     * 添加方法
     */

    public function add()
    {
        if (IS_POST) {
            //create方法接收请求数据
            if ($this->model->create()) {

                //用模型对象存入数据并返回结果
                if ($this->model->add($this->useallrequestdata?I("post."):'') !== false) {
                    $this->success('添加成功', cookie('__foreword__'), 1);
                    return;
                }
            }
            $this->error('操作失败' . showError($this->model));

        } else {
            //调用钩子函数
            $this->getcate();
            $this->assign('title', "添加".$this->title);
            $this->display('edit');
        }
    }



    /**
     * 改变status的方法
     */
    public function changeStatus($id, $status = -1)
    {
        //调用模型类中的changeStatus方法,对数据进行操作并返回结果,(注意这儿的模型类方法changeStatus和控制器中的changeStatus不一样)
        $result = $this->model->changeStatus($id, $status);

        //根据id改变status的值并返回结果
        if ($result !== false) {
            $this->success('操作成功', cookie('__foreword__'), 1);
        } else {
            $this->error('操作失败' . showError($this->model));
        }

    }


    /**
     * 编辑方法
     */

    public function edit()
    {
        if (IS_POST) {

            //接收要修改数据的id
            $id = I('post.id');

            //create方法接收请求数据
            if ($this->model->create()) {

                //用模型对象修改数据并返回结果
                if ($this->model->where(array('id' => $id))->save($this->useallrequestdata?I("post."):'') !== false) {
                    $this->success('修改成功', cookie('__foreword__'), 1);
                    return;
                }
            }
            $this->error('操作失败' . showError($this->model));

        } else {
            //接收请求参数id
            $id = I('get.id');

            //获得请求参数id在供应商表中所在行的记录并传给模板(起到数据回显)
            $row = $this->model->where(array('id' => $id))->select();
            $this->assign($row[0]);

            //调用钩子函数
            $this->getcate($id);

            //将请求参数传给模板
            $this->assign('title', "编辑".$this->title);

            //显示模板
            $this->display('edit');
        }
    }

//插入分类数据的钩子函数
    public function getcate(){

    }
}