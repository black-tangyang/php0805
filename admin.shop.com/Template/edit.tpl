<extend name="Common:edit"/>
<block name="content">
    <div class="main-div">
        <form method="post" action="{:U()}" enctype="multipart/form-data">
            <table cellspacing="1" cellpadding="3" width="100%">
                <?php
                     foreach($fields as $field){
                      if($field['key']=='PRI'){
                       continue;
                 }
                     if(empty($field['input_type'])){
                     echo "<tr>
                <td class='label'>{$field['comment']}</td>
                <td>
                    <input type='text' name='{$field['field']}' maxlength='60' value='{\${$field['field']}}'/>
                    <span class='require-field'>*</span>
                </td>
                </tr>";

                     }else{

                     if($field['input_type']=='file'){
                echo "<tr><td class='label'>{$field['comment']}</td>
                <td>
                    <input type='file' name='{$field['field']}' maxlength='60' />
                </td>
                </tr>";
                continue;
                }
                     if($field['input_type']=='text'){
                echo "<tr>
                    <td class='label'>{$field['comment']}</td>
                    <td>
                        <textarea name='intro' cols='60' rows='4'>{\${$field['field']}}</textarea>
                    </td>
                </tr>";
                continue;
                }
                     if($field['input_type']=='radio'){
                        echo"<tr><td class='label'>{$field['comment']}</td><td>";
                        if(!empty($field['option_values'])){
                        foreach($field['option_values'] as $key=>$value){
                        echo "<input type='radio' name='status' class='box' value='{$key}'/> {$value}";
                        }
                        }
                        echo"  </td></tr>";
                continue;
                }

                }
                     }
                ?>

                <tr>
                    <td colspan="2" align="center"><br/>
                        <input type="hidden" name="id" value="{$id}"/>
                        <input type="submit" class="button ajax_post" value=" 确定 "/>
                        <input type="reset" class="button" value=" 重置 "/>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</block>
