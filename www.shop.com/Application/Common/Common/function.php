<?php
header("Content-type:text/html;charset=utf-8");


/**
 * @param $model
 * @return string
 * 将模型中的多个错误报告组合成一个字符串返回
 */
function showError($model){
    $error=$model->getError();
    if(is_array($error)) {
        $html = "<ul>";
        foreach ($error as $row) {
            $html .= "<li>" . $row . "</li>";
        }
        $html .= "</ul>";
        return $html;
    }else{
        return $error;
    }
}

if(!function_exists(array_column)){
    function array_column($array,$field){
        $arr=array();
       foreach($array as $value){
           $arr[]=$value[$field];
       }
        return $arr;
    }
}


function arr2select($selectname,$optionarr,$id=''){
    $html="<select name='{$selectname}'><option value=''>---请选择---</option>";
    foreach($optionarr as $value){
        $selected='';
        if($id==$value['id']){
            $selected="selected='selected'";
        }
        $html.="<option value='{$value['id']}' {$selected}>{$value['name']}</option>";
    }
    $html.="</select>";
    return $html;
}

//登录存入用户缓存信息
function login($result){
    if($result) {
        session('USERINFO', $result);
    }else{
       return session('USERINFO');
    }
}

//判断是否是超级用户
function isSuperUser(){
    $userinfo=login();
    $username=$userinfo['username'];
    if(C('SUPER_ADMIN')==$username){
        return true;
    }
    return false;
}

//用户退出,删除用户缓存信息
function logout(){
    cookie('AUTOLOGIN',null);
    session('USERINFO',null);
    session('URLS',null);
    cookie('__LOGIN_RETURN_URL__',null);
}

//判断用户是否登录
function isLogin(){
    return login()!==null;
}

//缓存用户的访问权限地址以及其id
function userUrl($result){
    if($result) {
        session('URLS', $result);
    }else{
        return session('URLS');
    }
}

//将用户登录信息存入缓存以及从缓存中提取
function saveAutoLogin($result){
    if($result) {
        cookie('AUTOLOGIN', $result,60*60*24*7);
    }else{
        return cookie('AUTOLOGIN');
    }
}

//向用户寄送激活邮件
function sendMail($acceptmail,$title,$content){
    vendor('PHPMailer.PHPMailerAutoload');
    $mail_config =  C('MAIL_CONFIG');
    $mail = new \PHPMailer;
    $mail->isSMTP();                                      // 设置发送邮件协议: SMTP
    $mail->Host = $mail_config['Host'];                         // 设置邮件的服务器
    $mail->SMTPAuth = true;                               // 开启授权
    $mail->Username = $mail_config['Username'];              // 登陆用户的用户名
    $mail->Password = $mail_config['Password'];                    // 登陆用户的密码

    /////////////////////准备邮件内容///////////////////////////////////////
    $mail->setFrom($mail_config['From'], 'NOReply');          //发件人

    $mail->addAddress($acceptmail);     // 收件人
    //$mail->addAddress('ellen@example.com');               // Name is optional
//            $mail->addReplyTo('itsource520@126.com', 'Information');

    $mail->isHTML(true);                                  // 设置邮件为Html的邮件
    $mail->CharSet = 'utf-8';                              //设置编码
    $mail->Subject = $title;   //邮件的标题
    $mail->Body    = $content;   //邮件的内容
    if($mail->send()===false){
        $this->error = $mail->ErrorInfo;
        return false;
    }
}


