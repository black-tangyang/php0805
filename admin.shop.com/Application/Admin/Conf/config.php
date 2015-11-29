<?php
return array(
    //'配置项'=>'配置值'

    define('TMPL_URL', 'http://admin.shop.com/'),//定义域名常量

    'TMPL_PARSE_STRING' => array(
        '__CSS__' => TMPL_URL . '/Public/Admin/css', // 更改默认的/Public 替换规则
        '__JS__' => TMPL_URL . '/Public/Admin/js', // 增加新的JS类库路径替换规则
        '__IMAGES__' => TMPL_URL . '/Public/Admin/images', // 增加新的上传路径替换规则
        '__UEDITOR__' => TMPL_URL . '/Public/Admin/UEditor', //编辑器的外接js,css
        '__JQUERY__' => TMPL_URL . '/Public/Admin/jquery', //增加jquery
        '__LAYER__' => TMPL_URL . '/Public/Admin/layer/layer.js',//提示框组件
        '__UPLOADIFY__' => TMPL_URL . '/Public/Admin/uploadify',//上传框插件
        '__TREEGRID__' => TMPL_URL . '/Public/Admin/treegrid',//树缩进插件
        '__ZTREE_V3__' => TMPL_URL . '/Public/Admin/zTree_v3',//树缩进插件
    ),
    define('PAGE_SIZE',3),        //分页工具每页的条数
);