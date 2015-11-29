<?php
return array(
    //'配置项'=>'配置值'
    define('PICTURE_URL', 'http://admin.shop.com/'),//图片域名常量
    define('TMPL_URL', 'http://www.shop.com/'),//定义域名常量

    'TMPL_PARSE_STRING' => array(
        '__CSS__' => TMPL_URL . '/Public/Home/css', // 更改默认的/Public 替换规则
        '__JS__' => TMPL_URL . '/Public/Home/js', // 增加新的JS类库路径替换规则
        '__IMAGES__' => TMPL_URL . '/Public/Home/images', // 增加新的上传路径替换规则
        '__JQUERY__' => TMPL_URL . '/Public/Home/jquery', //增加jquery
    ),
);