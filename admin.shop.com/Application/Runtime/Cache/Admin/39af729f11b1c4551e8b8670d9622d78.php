<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>ECSHOP 管理中心 - <?php echo ($title); ?> </title>
    <meta name="robots" content="noindex, nofollow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="http://admin.shop.com//Public/Admin/css/general.css" rel="stylesheet" type="text/css"/>
    <link href="http://admin.shop.com//Public/Admin/css/main.css" rel="stylesheet" type="text/css"/>
    <!--block name=CSS 位置-->
    
    <link rel="stylesheet" href="http://admin.shop.com//Public/Admin/zTree_v3/css/zTreeStyle/zTreeStyle.css" type="text/css">

</head>
<body>
<!--top-->
<h1>
    <span class="action-span"><a href="<?php echo U('index');?>"><?php echo substr($title,6);?>列表</a></span>
    <span class="action-span1"><a href="#">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - <?php echo ($title); ?> </span>

    <div style="clear:both"></div>
</h1>
<!--top结束-->

<!--editcontent-->
<!--block name=content 位置-->

    <div class="main-div">
        <form method="post" action="<?php echo U();?>" enctype="multipart/form-data">
            <table cellspacing="1" cellpadding="3" width="100%">
                <tr>
                <td class='label'>权限名称</td>
                <td>
                    <input type='text' name='name' maxlength='60' value='<?php echo ($name); ?>'/>
                    <span class='require-field'>*</span>
                </td>
                </tr><tr>
                <td class='label'>权限的URL</td>
                <td>
                    <input type='text' name='url' maxlength='60' value='<?php echo ($url); ?>'/>
                    <span class='require-field'>*</span>
                </td>
                </tr><tr>
                <td class='label'>父权限</td>
                <td>
                    <input type='text' class="parent_text" disabled="disabled" maxlength='60' value='默认为顶级分类'/>
                    <input type='hidden' class="parent_id" name='parent_id' maxlength='60' value='<?php echo ((isset($parent_id) && ($parent_id !== ""))?($parent_id):0); ?>'/>
                    <span class='require-field'>*</span>

                    <div style="border: 1px solid gainsboro;width: 245px;">
                        <ul id="tree" class="ztree" style="width:260px; overflow:auto;"></ul>
                    </div>
                </td>
                </tr>
                <tr>
                    <td class='label'>简介</td>
                    <td>
                        <textarea name='intro' cols='60' rows='4'><?php echo ($intro); ?></textarea>
                    </td>
                </tr><tr><td class='label'>状态</td><td><input type='radio' name='status' class='box' value='1'/> 是<input type='radio' name='status' class='box' value='0'/> 否  </td></tr><tr>
                <td class='label'>排序</td>
                <td>
                    <input type='text' name='sort' maxlength='60' value='<?php echo ($sort); ?>'/>
                    <span class='require-field'>*</span>
                </td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><br/>
                        <input type="hidden" name="id" value="<?php echo ($id); ?>"/>
                        <input type="submit" class="button ajax_post" value=" 确定 "/>
                        <input type="reset" class="button" value=" 重置 "/>
                    </td>
                </tr>
            </table>
        </form>
    </div>

<!--editcontent结束-->

<!--footer-->
<div id="footer">
    共执行 1 个查询，用时 0.018952 秒，Gzip 已禁用，内存占用 2.197 MB<br/>
    版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。
</div>
<!--footer结束-->

<script type="text/javascript" src="http://admin.shop.com//Public/Admin/jquery/jquery-1.11.2.js"></script>
<script type="text/javascript" src="http://admin.shop.com//Public/Admin/layer/layer.js"></script>
<script type="text/javascript" src="http://admin.shop.com//Public/Admin/js/common.js"></script><!--加载的跳转提示框的功能,要用此功能,需在元素类中加上ajax_get或者ajax_post类-->
<!--block name=JS 位置-->

    <script type="text/javascript" src="http://admin.shop.com//Public/Admin/zTree_v3/js/jquery-1.4.4.min.js"></script>
    <script type="text/javascript" src="http://admin.shop.com//Public/Admin/zTree_v3/js/jquery.ztree.core-3.5.js"></script>
    <SCRIPT type="text/javascript">
        $(function () {
            var setting = {
                view: {
                    dblClickExpand: false,
                    showLine: true,
                    selectedMulti: false,
                },
                data: {
                    simpleData: {
                        enable: true,
                        idKey: "id",
                        pIdKey: "parent_id",
                        rootPId: ""
                    }
                },

                callback: {
                    onClick: zTreeOnClick
                }
            };

            var zNodes = <?php echo ($rows); ?>;


            var t = $("#tree");
            t = $.fn.zTree.init(t, setting, zNodes);
            t.expandAll(true);

            function zTreeOnClick(event, treeId, treeNode) {
                $(".parent_text").val(treeNode.name);
                $(".parent_id").val(treeNode.id);
            };

            <?php if(!empty($id)): ?>var parent_id=<?php echo ($parent_id); ?>;
            if (parent_id) {
                var node = t.getNodeByParam("id",parent_id);
                t.selectNode(node);
                $(".parent_text").val(node.name);
            }<?php endif; ?>

        })


    </SCRIPT>

<script type="text/javascript">
    $(function () {
        //为单选框赋默认值
        $('.box').val([<?php echo ((isset($status) && ($status !== ""))?($status):1); ?>]);
    })
</script>
</body>
</html>