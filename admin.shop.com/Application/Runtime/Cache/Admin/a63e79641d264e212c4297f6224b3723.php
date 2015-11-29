<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>ECSHOP 管理中心 - <?php echo ($title); ?> </title>
    <meta name="robots" content="noindex, nofollow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="http://admin.shop.com//Public/Admin/css/general.css" rel="stylesheet" type="text/css"/>
    <link href="http://admin.shop.com//Public/Admin/css/main.css" rel="stylesheet" type="text/css"/>
    <link href="http://admin.shop.com//Public/Admin/css/page.css" rel="stylesheet" type="text/css"/>
    <!--block name=CSS 位置-->
    
    
</head>
<body>
<!--top-->
<h1>
    <span class="action-span"><a href="<?php echo U('add');?>">添加<?php echo ($title); ?></a></span>
    <span class="action-span1"><a href="#">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - <?php echo ($title); ?> </span>

    <div style="clear:both"></div>
</h1>
<!--top结束-->

<!--editcontent-->
<!--block name=content 位置-->

    <div class="form-div">
        <form action="<?php echo U();?>" name="searchForm" method="get">
            <img src="http://admin.shop.com//Public/Admin/images/icon_search.gif" width="26" height="22" border="0" alt="search"/>
            <input type="text" name="keyword" size="15"/>
            <input type="submit" value=" 搜索 " class="button"/>
        </form>
    </div>
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <input type="button" class="button ajax_post" url="<?php echo U('changeStatus');?>" value="删除选中行"
                       style="margin-left: 70px"/>
            </tr>
            <tr>
                <th><input value="ok" type="checkbox" class="allid">序号</th>
                <th>送货方式名称</th>
<th>运费</th>
<th>送货方式描述</th>
<th>状态</th>
<th>排序</th>
<th>是否默认地址</th>
                <th>操作</th>
            </tr>
            <!-- 循环输出-->
            <?php if(is_array($rows)): $i = 0; $__LIST__ = $rows;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$row): $mod = ($i % 2 );++$i;?><tr>
                    <td align="center">
                        <span><input type="checkbox" class="id" value="<?php echo ($row['id']); ?>" name="id[]"></span>
                    </td>

                                        
                    <td class="first-cell" align="center">
                        <span><?php echo ($row['name']); ?></span>
                    </td>
                                        
                    <td class="first-cell" align="center">
                        <span><?php echo ($row['price']); ?></span>
                    </td>
                                        
                    <td class="first-cell" align="center">
                        <span><?php echo ($row['intro']); ?></span>
                    </td>
                                                            <td align="center"><a class="ajax_get"
                                          href="<?php echo U('changeStatus',array('id'=>$row['id'],'status'=>1-$row['status']));?>"><img
                                    src="http://admin.shop.com//Public/Admin/images/<?php echo ($row['status']); ?>.gif"/></a></td>
                                                     
                    <td class="first-cell" align="center">
                        <span><?php echo ($row['sort']); ?></span>
                    </td>
                                        
                    <td class="first-cell" align="center">
                        <span><?php echo ($row['is_default']); ?></span>
                    </td>
                    
                    <td align="center">
                        <a href="<?php echo U('edit',array(id=>$row['id']));?>" title="编辑">编辑</a>
                        <a href="<?php echo U('changeStatus',array(id=>$row['id']));?>" class="ajax_get" title="移除">移除</a>
                    </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </table>
        <!--分页工具条-->
        <div class="page" style="margin-left: 70%">
            <?php echo ($tool); ?>
        </div>
    </div>

<!--editcontent结束-->

<!--footer-->
<div id="footer">
    共执行 3 个查询，用时 0.021251 秒，Gzip 已禁用，内存占用 2.194 MB<br/>
    版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。
</div>
<!--footer结束-->

<script type="text/javascript" src="http://admin.shop.com//Public/Admin/jquery/jquery-1.11.2.js"></script>
<script type="text/javascript" src="http://admin.shop.com//Public/Admin/layer/layer.js"></script>
<script type="text/javascript" src="http://admin.shop.com//Public/Admin/js/common.js"></script>
<!--block name=JS 位置-->


<script type="text/javascript">
    $(function () {
        $(".allid").change(function () {
            $(".id").prop("checked", $(this).prop('checked'));
        })

        $(".id").change(function () {
            $(".allid").prop('checked', $('.id:not(:checked)').length == 0);
        })
    })
</script>

</body>
</html>