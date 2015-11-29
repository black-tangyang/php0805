<?php
/**
 * Created by PhpStorm.
 * User: ty
 * Date: 2015/11/20
 * Time: 22:46
 */

namespace Home\Model;


use Think\Model;

class AddressModel extends Model
{
    protected $_auto = array(
        array('member_id',UID)
    );

    /**
     * 查询用户所保存的地址
     */
    public function getAddresses($member_id){
        $sql="SELECT a.id,a.receiver,a.is_default,a.detail_address,a.tel,province.name AS province_name,city.name AS city_name,area.name AS area_name FROM address AS a
JOIN region AS province ON province.`id`=a.`province_id`
JOIN region AS city ON city.`id`=a.`city_id`
JOIN region AS `area` ON `area`.`id`=a.`area_id`
WHERE member_id=$member_id;";
        return M()->query($sql);
    }

    /**
     * 添加地址进地址表
     */
    public function add(){
        if($this->data['is_default']){
            $this->where(array('member_id'=>UID));
            parent::save(array('is_default'=>0));
        }
       return parent::add();
    }


    /**
     * 删除地址
     */
    public function remove($id){
        return $this->where(array('id'=>$id))->delete();
    }

    /**
     * 修改数据
     */
    public function save(){
        if(isset($this->data['is_default'])){
            $this->where(array('member_id'=>UID));
            parent::save(array('is_default'=>0));
        }
        return parent::save();
    }

    /**
     * 根据id得到一行地址数据(提供给订单使用)
     */
    public function get($id){
        $this->field("a.receiver,a.detail_address,a.tel,a.province_id,province.name as province_name,a.city_id,city.name as city_name,a.area_id,area.name as area_name")->
        alias('a')->join('__REGION__ as  province  on a.province_id = province.id');
        $this->join('__REGION__ as  city  on a.city_id = city.id');
        $this->join('__REGION__ as  area  on a.area_id = area.id');
        return $this->where(array('a.id'=>$id))->find();
    }
}