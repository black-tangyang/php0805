<?php
/**
 * Created by PhpStorm.
 * User: ty
 * Date: 2015/11/16
 * Time: 20:06
 */

namespace Home\Model;


use Org\Util\String;
use Think\Model;

class MemberModel extends Model
{
    /**
     * @var array
     * 自动完成,生成盐和时间
     */
    protected $_auto = array(
        array('salt', '\Org\Util\String::randString', '', 'function'),
        array('add_time', NOW_TIME),
        array('status',-1),
        array('mail_key','generateKey','','callback'),
    );

    /**
     * 生成随机key
     */
    public function generateKey(){
        return md5(String::randString(10));
    }

    /**
     * @param string $where
     * @return bool
     * 验证js传递过来表单值,是否已经使用
     */
    public function check($where)
    {
        $row = $this->where($where)->find();
        return empty($row);
    }

    /**
     * 添加注册信息进入会员表
     */
    public function add()
    {
        //用MD5的方法和盐对密码进行加密
        $this->data['password'] = md5($this->data['password'] . $this->data['salt']);
        //准备激活邮件的数据
        $acceptmail=$this->data['email'];
        $title="e商城账号激活邮件";
        $mail_key=$this->data['mail_key'];
        //插入注册数据
         $id=parent::add();
        if($id){
            //准备邮件中的内容
            $content="<a href='www.shop.com".U('activeUser',array('id'=>$id,'mail_key'=>$mail_key))."'>点击激活账号</a>";
            //寄送激活邮件
            $result=sendMail($acceptmail,$title,$content);
            if($result===false){
                $this->error='寄送邮件失败';
                return false;
            }
            return $id;
        }
        return false;
    }

    /**
     * @param $tel
     * 根据电话号码
     * 发送手机短信验证码
     */
    public function sendSMS($tel)
    {
        //随机生成一个6位数字的验证码
        $phoneverify = String::randString(6, 1);
        //将验证码存到session中
        session('PHONE_VERIFY', $phoneverify);

        //发送验证码给此手机用户
        vendor('SMS.TopSdk');
        date_default_timezone_set('Asia/Shanghai');

        $c = new \TopClient;
        $c->appkey = '23269098';
        $c->secretKey = '8f1dd873ef3e792eab786e8d2845f60d';
        $req = new \AlibabaAliqinFcSmsNumSendRequest;
       // $req->setExtend("123456");
        $req->setSmsType("normal");
        $req->setSmsFreeSignName("注册验证");
        $req->setSmsParam("{'code':'$phoneverify','product':'e商城'}");
        $req->setRecNum("$tel");
        $req->setSmsTemplateCode("SMS_2370004");
        $resp = $c->execute($req);
        return ((string)$resp->result->success)==='true';
    }

    /**
     * @param $id
     * @param $mail_key
     * @return bool
     * 激活账号
     */
    public function activeUser($id,$mail_key){
       $key=$this->getFieldById($id,'mail_key');
        if($key===$mail_key){
            return $this->where(array('id'=>$id))->setField('status',1);
        }else {
            return false;
        }
    }

    /**
     * 登录验证
     */
    public function login($post){
        $username=$post['username'];//得到用户名
        $password=$post['password'];//得到明文密码
        $row=$this->where(array('username'=>$username))->find();
        if($row){
            //>>检查当前用户是否为激活状态
            if($row['status']!=1){
                $this->error='该用户为禁用或者为激活状态';
            }
        }else{
            $this->error="该用户名不存在";
            return false;
        }
        $password=md5($password.$row['salt']);//对明文密码进行加盐加密
        if($password!=$row['password']){
            $this->error='密码错误';
            return false;
        }
        return $row;
    }
}