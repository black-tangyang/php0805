<?php
/**
 * Created by PhpStorm.
 * User: ty
 * Date: 2015/11/20
 * Time: 21:51
 */

namespace Home\Behavior;


use Think\Behavior;

/**
 * Class SetMemberIdBehavior
 * @package Home\Behavior
 */
class SetMemberIdBehavior extends Behavior
{
    public function run(&$params)
    {
        if(isLogin()){
            $userinfo = login();
            defined('UID') or define('UID',$userinfo['user_id']);
        }
    }

}