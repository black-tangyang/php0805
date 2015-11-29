<?php
/**
 * Created by PhpStorm.
 * User: ty
 * Date: 2015/11/3
 * Time: 11:03
 */

namespace Admin\Model;

use Think\Model;
use Think\Page;

class BaseModel extends Model
{

    /**
     * @return array
     * 生成分页工具和获得当前页列表
     */
    public function getResult($where=array())
    {
        //在where条件中添加搜索status不为-1的状态
        $where['status']=array('NEQ', -1);

        //用基础模型Model中的集合count方法的到数据表中的总条数
        $total = $this->where($where)->count();

        //设置每页有多少条
        $pagesize = PAGE_SIZE;

        //使用page类创建page对象
        $page = new Page($total, $pagesize);

        //得到page类生成的html代码
        $html = $page->show();

        //获得当前页的所有记录
        $rows = $this->where($where)->limit($page->firstRow, $page->listRows)->select();

        //将所有工具条html和当前页面的记录组成一个数组并返回
        $result = array(
            'rows' => $rows,
            'tool' => $html,
        );
        return $result;
    }

    /**
     * 获取status=1并且通过sort排序的数据
     * @return mixed
     */
    public function getShowList($wheres=array(),$field="*"){
        $wheres['status'] = 1;
        return $this->where($wheres)->field($field)->order('sort')->select();
    }






    /**
     * 改变status的状态
     */

    public function changeStatus($id, $status)
    {
        //构建需要修改的数组
        $arr = array('status' => $status);

        //如果状态为-1(及移除操作的时候)同时要修改name字段,为name字段加上_del
        if ($status == -1) {
            $arr['name'] = array('exp', "CONCAT(name,'_del')");//exp这个地方只支持小写,大写没有效果
        }
        //返回结果
        $this->where(array('id' => array('in', $id)));
        return parent::save($arr);

    }

    /**
     * @param string $field
     * @return mixed
     * 得到分类数表
     */
    public function getTreeList($field='*'){
        return $this->where("status>0")->field($field)->order('lft')->select();
    }

}