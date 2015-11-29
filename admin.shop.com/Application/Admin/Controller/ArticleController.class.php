<?php
namespace Admin\Controller;


class ArticleController extends BaseController
{
//BaseController中有model属性,可以直接调用,操作对应的表
    protected $title='文章';


    //准备文章分类数据
    public function getcate(){
       $ArticleCategoryModel=D("ArticleCategory");
        //用文章分类模型查找文章分类的数据
        $articlecatelist=$ArticleCategoryModel->getShowList();
        $this->assign('articlecatelist',$articlecatelist);
    }


    public function add()
    {
        if (IS_POST) {
            //create方法接收请求数据
            if ($data=$this->model->create()) {
                $data['content']=I('post.content','',false);
                //用模型对象存入数据并返回结果
                if ($this->model->add($data) !== false) {
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

    public function search($keyword){
        $where=array('name'=>array('like',"%{$keyword}%"),'status'=>1);
        $articlelist=$this->model->where($where)->field("id,name")->select();
        $this->ajaxReturn($articlelist);
    }

}