<?php
include(VIEWPATH."dashboard/dashboard_header.php");
?>

<div class='row-fluid'>
	<div class="row-fluid">
	<div class="span12">

    <?php
    if(@$addsuccess && $addsuccess)
    {
        ?> <div class="alert alert-success">添加成功！</div> <?php
    }
    else if (@$error && count($error) > 0) { ?>
        <div class="alert alert-warning">
            <?php foreach ($error as $one_error) { ?>
                <p><?php echo $one_error?></p>
            <?php } ?>
        </div>
    <?php } ?>

	<form action="/dashboard/project_report" method='post'>
<? if(@$new_project && $new_project) {?>
<input type="hidden" name="new_project" value=<?php echo 1; ?> >
    <label class="col-xs-10" >
        <table class='table table-hover table-bordered' >
                <thead>
                    <tr><td>项目代码</td><td>项目名称</td><td>项目状态</td><td>项目开始日期</td><td>项目截止日期</td><td>项目备注</td></tr>
                </thead>
                <tbody id='allproject_table'>
                <tr>
                    <td>
                        <!-- <input type='text' class='col-xs-2' name='project_user[]'/>  -->
                        <select name="project_code" onChange="changeProjectData(this)"> 
                        <!-- <option selected="selected" >请选择员工</option> -->
                        <?php 
                            
                            foreach($Search_result as $r){
                                if($r['sts'])
                                    echo "<option value='".$r['project_code']."'>".$r['project_code']."     ".$r['project_name']."</option>";   
                                }?>
                        </select>
                    </td>

                    <td><?if(count($Search_result)>0) echo $Search_result[0]['project_name']?></td>
                    <td><?if(count($Search_result)>0) {
                        if($Search_result[0]['sts'])
                            echo "进行中";
                        else 
                            echo "已取消";
                    }
                        ?></td>
                    <td><?if(count($Search_result)>0) echo $Search_result[0]['startdate']?></td>
                    <td><?if(count($Search_result)>0) echo $Search_result[0]['enddate']?></td>
                    <td><?if(count($Search_result)>0) echo $Search_result[0]['pcontent']?></td>
                    
                </tr>
                </tbody>
            </table>
            <input type="hidden" id="newpid" name="project_id" value=<?if(count($Search_result)>0) echo $Search_result[0]['id']?> >
                
        </label>

<?} else {?>
		<div class="control-group">
			<label class="control-label">项目代码:<?php echo $project_code;?></label>
                <input type="hidden" name="project_id" value=<?php echo $project_id; ?> >
                <input type="hidden" name="project_code" value=<?php echo $project_code; ?> >
                
                <input type="hidden" name="report_view" value="" >
		</div>
        <?}?>
 		<div class="control-group">
			<label class="control-label">选择项目审核人</label>
			<div class="controls">
                <select name="shr" ><!-- onChange="changeData(this.value)"> -->
                <!-- <option selected="selected" >请选择员工</option> -->
                <?php 
                    $i=1;
                    foreach($all_shr as $shr){
                        echo "<option value='".$shr['name']."'>".$shr['name']."</option>";
                    }

                ?>
                </select>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label">工作时长（小时为单位，不足一小时按一小时算）</label>
			<div class="controls">
				<input type="text" class="span6 m-wrap" name="hourcount">
			</div>
		</div> 
           <div class="control-group">
            <label class="control-label">工作备注（不超过100个字，超出部分自动截取）</label>
                <textarea class="form-control span6" name="worklogproject" rows="3"></textarea>
        </div>

<div class="form-horizontal">
<div class="control-group">
    
    <label class="col-xs-2 control-label" style="text-align:left;width:100px">添加工时数据项
        <br><br>
        <p>
            <button type='button' id='project_add_unit' class='btn green' >添加</button>
        </p>
    </label>
    <label class="col-xs-10" >
        <table class='table table-hover table-bordered' >
                <thead>
                    <tr><td style='width: 150px;'>工时数据编号</td><td style='width: 150px;'>工时数据名称</td><td style='width: 150px;'>工时数据单位</td><td style='width: 150px;'>工时数据单价</td><td style='width: 150px;'>数量</td><td style='width: 150px;'>金额</td><td></td></tr>
                </thead>
                <tbody id='project_add_unit_table'>
                <tr> 
                    <td>
                        <select name='project_unit_bh[]' onChange="changeData(this)">
                        <?php foreach($all_unit as $unit){
                            echo "<option value='".$unit['bh']."'>".$unit['bh']."    ".$unit['workunit']."</option>";
                        }
                        ?>
                    </select>
                    </td>
                    
                    <td><?if(count($all_unit)>0) echo $all_unit[0]['workunit']?></td>
                    <td><?if(count($all_unit)>0) echo $all_unit[0]['unitname']?></td>
                    <td><?if(count($all_unit)>0) echo $all_unit[0]['price']?></td>
                    <td><input type='text' class='col-xs-2' style='width: 150px;' name='project_unit_amount[]' onkeyup="calcu(this)"/></td>
                    <td style='width: 150px;'></td>
                    <td><button type='button' class='close' aria-hidden='true' onclick='removeCloseMe(this)'>
                    &times;</button>
                    </td></tr>
 <!--  <td><input type='text' class='col-xs-2' style='width: 150px;' name='project_unit_bh[]'/></td>
                    <td><input type='text' class='col-xs-2' style='width: 150px;' name='project_unit_name[]'/></td>
                    <td><input type='text' class='col-xs-2' style='width: 150px;' name='project_unit_unit[]'/></td>
                    <td><input type='text' class='col-xs-2' style='width: 150px;' name='project_unit_price[]'/></td>
                    <input type="hidden" name='project_unit_name[]' value= <?//echo "'".$all_unit[0]['workunit']."'";?>
                    >
                    <input type="hidden" name='project_unit_unit[]' value= <?//echo "'".$all_unit[0]['unitname']."'";?>
                    >
                    <input type="hidden" name='project_unit_price[]' value= <?//echo "'".$all_unit[0]['price']."'";?>
                    >
                     --> 

                </tbody>
            </table>
        </label>
</div>      
            <script type="text/javascript">  
            <? $all_unitJson = json_encode($all_unit);

            echo "var data =".$all_unitJson.";";
            if(@$new_project && $new_project) {
                $all_user_project = json_encode($Search_result);
                echo "var usr_Search_result =".$all_user_project.";";?>
                    function changeProjectData(tt){
                    var value="";
                    if(usr_Search_result[tt.selectedIndex]['sts'])
                        value="进行中";
                    else 
                        value="已取消";
                    $(tt).parent().next().text(usr_Search_result[tt.selectedIndex]['project_name']);
                    $(tt).parent().next().next().text(value);
                    $(tt).parent().next().next().next().text(usr_Search_result[tt.selectedIndex]['startdate']);
                    $(tt).parent().next().next().next().next().text(usr_Search_result[tt.selectedIndex]['enddate']);
                    $(tt).parent().next().next().next().next().next().text(usr_Search_result[tt.selectedIndex]['pcontent']);
                    //alert(ii.html())
                    $("#newpid").val(usr_Search_result[tt.selectedIndex]['id']);
                }
            <?}?>
            // $(document).ready(function(){ 
            //     //$("table tr td input").css("width","50");
            //     $("table tr td").css("width","50");
            // }); 
            function calcu(t){
                //alert($(t).val());
                $(t).attr("value",$(t).val());
                $(t).parent().next().text($(t).val()*$(t).parent().prev().text());
            }

            function changeData(tt){
                var price=data[tt.selectedIndex]['price'];
                var amount=$(tt).parent().next().next().next().next().children("input").val();
                //alert(amount);
                $(tt).parent().next().text(data[tt.selectedIndex]['workunit']);
                $(tt).parent().next().next().text(data[tt.selectedIndex]['unitname']);
                $(tt).parent().next().next().next().text(price);
                //alert(ii.html());
                $(tt).parent().next().next().next().next().next().text(price*amount);
            }
                $('#project_add_unit').click(function() {
                    $('#project_add_unit_table').append("<tr><td>\
                        <select name='project_unit_bh[]' onChange='changeData(this)'>\
                        <?php foreach($all_unit as $unit){echo "<option value='".$unit['bh']."'>".$unit['bh']."</option>";}?>\
                    </td><td><?echo $all_unit[0]['workunit']?></td>\
                    <td><?echo $all_unit[0]['unitname']?></td>\
                    <td><?echo $all_unit[0]['price']?></td>\
                    <td><input type='text' class='col-xs-2' style='width: 150px;' name='project_unit_amount[]' onkeyup='calcu(this)'/></td>\
                    <td style='width: 150px;'></td>\
                    <td><button type='button' class='close' aria-hidden='true' onclick='removeCloseMe(this)'>\
                    &times;</button></td></tr>")
                })
                function removeCloseMe(obj) {
                    $(obj).parent().parent().remove();
                }
            </script>
    </div>
            <button type="submit" class='btn blue'>确定</button>
            <input type="button" class='btn blue' style="position:relative;left:20px; " onclick="javascript:history.go(-1);" value="取消" />
	</form>
<br><br>
	</div>
	</div>
</div>
<?php
include(VIEWPATH."dashboard/include_js.php");
include(VIEWPATH."dashboard/root_footer.php");
?>

