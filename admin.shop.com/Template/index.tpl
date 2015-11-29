<extend name="Common:index"/>
<block name="content">
    <div class="form-div">
        <form action="{:U()}" name="searchForm" method="get">
            <img src="__IMAGES__/icon_search.gif" width="26" height="22" border="0" alt="search"/>
            <input type="text" name="keyword" size="15"/>
            <input type="submit" value=" 搜索 " class="button"/>
        </form>
    </div>
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <input type="button" class="button ajax_post" url="{:U('changeStatus')}" value="删除选中行"
                       style="margin-left: 70px"/>
            </tr>
            <tr>
                <th><input value="ok" type="checkbox" class="allid">序号</th>
                <?php
    foreach($fields as $field){
    if($field['key']=='PRI'){
          continue;
    }
    echo "<th>{$field['comment']}</th>\r\n";
    }
    ?>
                <th>操作</th>
            </tr>
            <!-- 循环输出-->
            <volist name="rows" id="row">
                <tr>
                    <td align="center">
                        <span><input type="checkbox" class="id" value="{$row['id']}" name="id[]"></span>
                    </td>

                    <?php foreach($fields as $field):
                    if($field['key']=='PRI'){
                    continue;
                    }
                    ?>
                    <?php if($field['field']=='status'){ ?>
                    <td align="center"><a class="ajax_get"
                                          href="{:U('changeStatus',array('id'=>$row['id'],'status'=>1-$row['status']))}"><img
                                    src="__IMAGES__/{$row['status']}.gif"/></a></td>
                                 <?php  continue; ?>
                   <?php } ?>

                    <td class="first-cell" align="center">
                        <span>{$row['<?php echo $field['field'];  ?>']}</span>
                    </td>
                    <?php endforeach; ?>

                    <td align="center">
                        <a href="{:U('edit',array(id=>$row['id']))}" title="编辑">编辑</a>
                        <a href="{:U('changeStatus',array(id=>$row['id']))}" class="ajax_get" title="移除">移除</a>
                    </td>
                </tr>
            </volist>
        </table>
        <!--分页工具条-->
        <div class="page" style="margin-left: 70%">
            {$tool}
        </div>
    </div>
</block>