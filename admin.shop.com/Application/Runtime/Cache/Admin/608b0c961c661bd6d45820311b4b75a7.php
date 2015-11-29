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
    <link rel="stylesheet" type="text/css" href="http://admin.shop.com//Public/Admin/uploadify/uploadify.css">
    <style type="text/css">
        .upload-pre-item{
            position: relative;
        }
        .upload-pre-item a{
            position: absolute;
            top: 0px;
            right: 0px;
            display: block;
            color: black;
        }
    </style>

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

    <div id="tabbar-div">
        <p>
            <span class="tab-front">通用信息</span>
            <span class="tab-back">商品描述</span>
            <span class="tab-back">会员价格</span>
            <span class="tab-back">商品属性</span>
            <span class="tab-back">商品相册</span>
            <span class="tab-back">关联文章</span>
        </p>
    </div>
    <div class="main-div">
        <form method="post" action="<?php echo U();?>" enctype="multipart/form-data">
            <table cellspacing="1" cellpadding="3" width="100%">

                <tr>
                    <td class='label'>名称</td>
                    <td>
                        <input type='text' name='name' maxlength='60' value='<?php echo ($name); ?>'/>
                        <span class='require-field'>*</span>
                    </td>
                </tr>

                <tr>
                    <td class='label'>商品分类</td>
                    <td>
                        <input type='text' class='goods_category_text' maxlength='60' disabled/>
                        <input type='hidden' class="goods_category_id" name='goods_category_id' maxlength='60'
                               value='<?php echo ($goods_category_id); ?>'/>
                        <span class='require-field'>*</span>

                        <div style="border: 1px solid gainsboro;width: 245px;">
                            <ul id="tree" class="ztree" style="width:260px; overflow:auto;"></ul>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td class='label'>品牌</td>
                    <td>
                        <?php echo arr2select('brand_id',$brandlist,$brand_id);?>
                    </td>
                </tr>

                <tr>
                    <td class='label'>供应商</td>
                    <td>
                        <?php echo arr2select('supplier_id',$Supplierlist,$supplier_id);?>
                    </td>
                </tr>

                <tr>
                    <td class='label'>本店价格</td>
                    <td>
                        <input type='text' name='shop_price' maxlength='60' value='<?php echo ($shop_price); ?>'/>
                        <span class='require-field'>*</span>
                    </td>
                </tr>

                <tr>
                    <td class='label'>市场价格</td>
                    <td>
                        <input type='text' name='market_price' maxlength='60' value='<?php echo ($market_price); ?>'/>
                        <span class='require-field'>*</span>
                    </td>
                </tr>

                <tr>
                    <td class='label'>库存</td>
                    <td>
                        <input type='text' name='stock' maxlength='60' value='<?php echo ($stock); ?>'/>
                        <span class='require-field'>*</span>
                    </td>
                </tr>


                <tr>
                    <td class='label'>是否上架</td>
                    <td>
                        <input type="radio" class="is_on_sale" value="1" name="is_on_sale"/>是
                        <input type="radio" class="is_on_sale" value="0" name="is_on_sale"/>否
                        <span class="require-field">*</span>
                    </td>
                </tr>

                <tr>
                    <td class='label'>商品状态</td>
                    <td>
                        <input type="checkbox" class="goods_status" name="goods_status[]" value="1">疯狂抢购
                        <input type="checkbox" class="goods_status" name="goods_status[]" value="2">热卖商品
                        <input type="checkbox" class="goods_status" name="goods_status[]" value="4">推荐商品
                        <input type="checkbox" class="goods_status" name="goods_status[]" value="8">新品上架
                        <input type="checkbox" class="goods_status" name="goods_status[]" value="16">猜您喜欢
                        <span class="require-field">*</span>
                    </td>
                </tr>


                <tr>
                    <td class='label'>关键字</td>
                    <td>
                        <input type='text' name='keyword' maxlength='60' value='<?php echo ($keyword); ?>'/>
                        <span class='require-field'>*</span>
                    </td>
                </tr>


                <tr>
                    <td class='label'>LOGO</td>
                    <td>
                        <input type="file" name="upload-logo" id="upload-logo" maxlength="60">
                        <input type="hidden" id="logo" name="logo" value="<?php echo ($logo); ?>">

                        <div class="upload-img-box upload-img-logo" style="display: <?php echo ($logo?'block':'none'); ?>">
                            <div class="upload-pre-item">
                                <img src="/Uploads/<?php echo ($logo); ?>">
                            </div>
                        </div>
                    </td>
                </tr>


                <tr>
                    <td class='label'>状态</td>
                    <td><input type='radio' name='status' class='box' value='1'/> 是<input type='radio' name='status'
                                                                                          class='box' value='0'/> 否
                    </td>
                </tr>
                <tr>
                    <td class='label'>排序</td>
                    <td>
                        <input type='text' name='sort' maxlength='60' value='<?php echo ($sort); ?>'/>
                        <span class='require-field'>*</span>
                    </td>
                </tr>
            </table>
            <table cellspacing="1" cellpadding="3" width="100%" style="display: none">
                <tr>
                    <td>
                        <!--商品描述-->
                    <textarea id="intro" name="intro">
                        <?php echo ($intro); ?>
                    </textarea>
                    </td>
                </tr>
            </table>
            <table cellspacing="1" cellpadding="3" width="100%" style="display: none">
                    <?php if(is_array($MemberLevellist)): $i = 0; $__LIST__ = $MemberLevellist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$row): $mod = ($i % 2 );++$i;?><tr>
                            <td class="label"><?php echo ($row['name']); ?>:</td>
                            <td>
                                <input type="text" name="price[<?php echo ($row['id']); ?>]" maxlength="60" value="<?php echo ($pricearr[$row['id']]); ?>"> <span
                                    class="require-field">*</span>
                            </td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </table>
            <table cellspacing="1" cellpadding="3" width="100%" style="display: none">
                <tr>
                    <td class="label">商品属性</td>
                    <td>
                        <input type="text" name="sort" maxlength="60" value="<?php echo ((isset($sort) && ($sort !== ""))?($sort):20); ?>"> <span
                            class="require-field">*</span>
                    </td>
                </tr>
            </table>
            <table cellspacing="1" cellpadding="3" width="100%" style="display: none">
                <tr>
                    <td class="label">商品相册</td>
                    <td>
                        <!--上传图片显示的div-->
                        <div id="goods_gallery">
                        </div>
                        <input type="file" name="upload-logo" id="upload-gallery" maxlength="60">
                    </td>
                </tr>
            </table>
            <table cellspacing="1" cellpadding="3" width="100%" style="display: none">
                <tr>
                    <td ><input type="text" maxlength="60" class="keyword" value="">
                         <input id="btn" type="button" value="搜索文章">
                    </td>
                </tr>
                <tr>
                    <td>
                   <select class="select1" multiple="multiple" style="width: 300px;height: 500px">
                   </select>
                    </td>
                    <td>
                        <select class="select2" multiple="multiple" style="width: 300px;height: 500px">
                            <?php if(is_array($goods_articlelist)): $i = 0; $__LIST__ = $goods_articlelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$row): $mod = ($i % 2 );++$i;?><option value='<?php echo ($row["id"]); ?>'><?php echo ($row["name"]); ?></option>;<?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                        <div class="articlehidden"></div>
                    </td>
                </tr>
            </table>
            <div>
                <span style="margin-left: 400px">
                    <input type="hidden" name="id" value="<?php echo ($id); ?>"/>
                    <input type="submit" class="button" value=" 确定 "/>
                    <input type="reset" class="button" value=" 重置 "/>
                    </span>
            </div>
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

    <script src="http://admin.shop.com//Public/Admin/uploadify/jquery-1.11.2.js" type="text/javascript"></script>
    <script src="http://admin.shop.com//Public/Admin/uploadify/jquery.uploadify.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="http://admin.shop.com//Public/Admin/zTree_v3/js/jquery.ztree.core-3.5.js"></script>
    <script type="text/javascript" charset="utf-8" src="http://admin.shop.com//Public/Admin/UEditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="http://admin.shop.com//Public/Admin/UEditor/ueditor.all.min.js"></script>
    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
    <script type="text/javascript" charset="utf-8" src="http://admin.shop.com//Public/Admin/UEditor/lang/zh-cn/zh-cn.js"></script>

    <script type="text/javascript">
        $(function () {
            //////////////////////////////////////导航条特效 开始///////////////////////////////////
            $("#tabbar-div span").click(function () {
                $("#tabbar-div span").removeClass('tab-front').addClass('tab-back');
                $(this).removeClass('tab-back').addClass('tab-front');

                $('form>table').hide();
                var index = $(this).index();//代表点击的第几个span
                $('form>table').eq(index).show();

            })

            //////////////////////////////////////导航条特效 结束///////////////////////////////////

            //////////////////////////////////////商品分类特效 开始///////////////////////////////////
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
                    beforeClick: function (treeId, treeNode, clickFlag) {
                        if (treeNode.isParent) {
                            layer.msg('必须选择最小分类', {
                                offset: 0,
                                icon: 0,
                            });
                        }

                        return !treeNode.isParent;  //如果该分类有子节点, 就返回false, false表示不选中
                    },
                    onClick: zTreeOnClick
                }
            };

            var zNodes = <?php echo ($rows); ?>;


            var t = $("#tree");
            t = $.fn.zTree.init(t, setting, zNodes);
            t.expandAll(true);

            function zTreeOnClick(event, treeId, treeNode) {
                $(".goods_category_text").val(treeNode.name);
                $(".goods_category_id").val(treeNode.id);
            };
            <?php if(!empty($id)): ?>var goods_category_id = <?php echo ($goods_category_id); ?>;
            var node = t.getNodeByParam('id', goods_category_id);
            t.selectNode(node);
            $(".goods_category_text").val(node.name);
            $(".goods_category_id").val(node.id);<?php endif; ?>


                // //////////////////////////////////商品分类特效 结束///////////////////////////////////

                //////////////////////////////////////上传图片特效 开始///////////////////////////////////

            window.setTimeout(function () {
                $('#upload-logo').uploadify({
                    height: 25, //指定上传框的高
                    width: 145,
                    'swf': 'http://admin.shop.com//Public/Admin/uploadify/uploadify.swf',   //指定上传插件flash的地址
                    'uploader': '<?php echo U("Uploadify/index");?>',   //在服务器上处理上传的方法
                    'buttonText': '选择图片',  //上传按钮配置文字的
                    //       'fileObjName' : 'the_file' //默认值为Filedata
                    'formData': {'dir': 'good'},   //通过post方式传递额外的参数
                    'multi': true, //是否支持多文件上传
                    'onUploadSuccess': function (file, data, response) {
                        $("#logo").val(data);
                        $(".upload-img-logo").show();
                        $('.upload-img-logo img').attr('src', "/Uploads/" + data);
                    },
                    'onUploadError': function (file, errorCode, errorMsg, errorString) {
                        alert('The file ' + file.name + ' could not be uploaded: ' + errorString);
                    }
                });
            }, 20);


            //////////////////////////////////////上传图片特效 结束///////////////////////////////////

            //商品上架的状态显示
            $('.is_on_sale').val([<?php echo ((isset($is_on_sale ) && ($is_on_sale !== ""))?($is_on_sale ): 1); ?>
        ])
        ;

        /////////////////////////////编辑时回显商品状态  开始////////////////////////////////////////////
        <?php if(!empty($id)): ?>var goods_status = <?php echo ($goods_status); ?>;  //该值是一个整数
        var goods_status_values = new Array();
        if ((goods_status & 1) > 0) {
            goods_status_values.push(1);
        }
        if ((goods_status & 2) > 0) {
            goods_status_values.push(2);
        }
        if ((goods_status & 4) > 0) {
            goods_status_values.push(4);
        }
        if ((goods_status & 8) > 0) {
            goods_status_values.push(8);
        }
        if ((goods_status & 16) > 0) {
            goods_status_values.push(16);
        }
        $('.goods_status').val(goods_status_values);<?php endif; ?>
            /////////////////////////////编辑时回显商品状态   结束////////////////////////////////////////////


            //////////////////////////////////商品描述在线编辑器 开始//////////////////////////////////////

        UE.getEditor('intro');
        //////////////////////////////////商品描述在线编辑器 结束//////////////////////////////////////

        //////////////////////////////////商品相册上传特效   开始/////////////////////////////////////
        window.setTimeout(function () {
            $('#upload-gallery').uploadify({
                height: 25, //指定上传框的高
                width: 145,
                'swf': 'http://admin.shop.com//Public/Admin/uploadify/uploadify.swf',   //指定上传插件flash的地址
                'uploader': '<?php echo U("Uploadify/index");?>',   //在服务器上处理上传的方法
                'buttonText': '选择上传图片',  //上传按钮配置文字的
                //       'fileObjName' : 'the_file' //默认值为Filedata
                'formData': {'dir': 'good'},   //通过post方式传递额外的参数
                'multi': true, //是否支持多文件上传
                'onUploadSuccess': function (file, data, response) {
                    var onephone = '<div class="upload-pre-item" style="width: 200px">\
                            <input type="hidden" id="goods_gallery_path" name="gallery_path[]" value="' + data + '">\
                            <img src="/Uploads/' + data + '">\
                            <a href="javascript:;">X</a>\
                            <hr\>\
                            </div>';
                    $("#goods_gallery").append($(onephone))
                },
                'onUploadError': function (file, errorCode, errorMsg, errorString) {
                    alert('The file ' + file.name + ' could not be uploaded: ' + errorString);
                }
            });
        }, 20);

        //--------------------------------------------相册的编辑回显
        <?php if(!empty($id)): if(is_array($goods_gallery_rows)): $i = 0; $__LIST__ = $goods_gallery_rows;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goods_gallery_row): $mod = ($i % 2 );++$i;?>var onephone = '<div class="upload-pre-item" style="width: 200px">\
                            <input type="hidden" id="goods_gallery_id" name="gallery_id[]" value="<?php echo ($goods_gallery_row['id']); ?>">\
                            <input type="hidden" id="goods_gallery_path" name="gallery_path[]" value="<?php echo ($goods_gallery_row['path']); ?>">\
                            <img src="/Uploads/<?php echo ($goods_gallery_row['path']); ?>">\
                            <a href="javascript:;">X</a>\
                            <hr\>\
                            </div>';
                           $("#goods_gallery").append($(onephone));<?php endforeach; endif; else: echo "" ;endif; endif; ?>
              //删除商品数据
                $('#goods_gallery').on('click','.upload-pre-item a',function(){
                    $(this).closest('div').remove();
                })
        //////////////////////////////////商品相册上传特效   结束/////////////////////////////////////


        //////////////////////////////////商品关联文章 开始/////////////////////////////////
           $("#btn").click(function(){
              search();
           });
           $(".keyword").keypress(function(event){
               if(event.keyCode==13){
                   search();
                   return false;
               }
           })
        //搜索相关文章并显示在框内的方法
        function search(){
            $(".select1").empty();
            $.getJSON("<?php echo U('Article/search');?>",{keyword:$(".keyword").val()},function(data){
                $(data).each(function(){
                    var html="<option value='"+$(this).attr('id')+"'>"+$(this).attr('name')+"</option>";
                    $(html).appendTo($(".select1"));
                })
            })
        }




        $(".select1").on('dblclick','option',function(){
            $(this).appendTo($('.select2'));
            select2hidden();
        })
        $(".select2").on('dblclick','option',function(){
            $(this).appendTo($('.select1'));
            select2hidden();
        })

        function select2hidden(){
            $(".articlehidden").empty();
            var html='';
            $(".select2 option").each(function(){
                html+="<input type='hidden' name='article_id[]' value='"+this.value+"' />";
            })
            $(html).appendTo($(".articlehidden"));
        }

        select2hidden();
        //////////////////////////////////商品关联文章  结束/////////////////////////////////



        })

    </script>

<script type="text/javascript">
    $(function () {
        //为单选框赋默认值
        $('.box').val([<?php echo ((isset($status) && ($status !== ""))?($status):1); ?>]);
    })
</script>
</body>
</html>