<?php
include(VIEWPATH."dashboard/dashboard_header.php");
?>
<div class='row-fluid'>
	<div class="row-fluid">
	<div class="span12">

    <?php
    if(@$success && $success)
    {
        ?> <div class="alert alert-success">修改成功！</div> <?php
    }
    else if (@$error && count($error) > 0) { ?>
        <div class="alert alert-warning">
            <?php foreach ($error as $one_error) { ?>
                <p><?php echo $one_error?></p>
            <?php } ?>
        </div>
    <?php } ?>


	<form action="/dashboard/editproject" method='post'>

<div class="control-group">
    

    <label class="col-xs-10" >
        <table class='table table-hover table-bordered' >
                <thead>
                        <tr><td>项目代码</td><td>项目名称</td><td>项目状态</td><td>项目开始日期</td><td>项目截止日期</td><td>项目备注</td></tr>
                </thead>
                <tbody id='project_edit_table'>
                <tr> 
                    <td>
                        <select name='project_code' onChange="changeData(this)">
                        <?php foreach($all_project as $project){
                            echo "<option value='".$project['project_code']."'>".$project['project_code']."</option>";
                        }
                        ?>
                    </select>
                    </td>
                    <td><?if(count($all_project)>0) echo $all_project[0]['project_name']?></td>
                    <td><?if(count($all_project)>0) {
                        if($all_project[0]['sts'])
                            echo "进行中";
                        else 
                            echo "已取消";
                    }
                        ?></td>
                    <td><?if(count($all_project)>0) echo $all_project[0]['startdate']?></td>
                    <td><?if(count($all_project)>0) echo $all_project[0]['enddate']?></td>
                    <td><?if(count($all_project)>0) echo $all_project[0]['pcontent']?></td>
                </tr>


                </tbody>
            </table>
        </label>
            <script type="text/javascript">  

            <? $all_project_Json = json_encode($all_project);
            echo "var data =".$all_project_Json;?>
            //alert(data);
            function changeData(tt){
                var value="";
                if(data[tt.selectedIndex]['sts'])
                    value="进行中";
                else 
                    value="已取消";
                $(tt).parent().next().text(data[tt.selectedIndex]['project_name']);
                $(tt).parent().next().next().text(value);
                $(tt).parent().next().next().next().text(data[tt.selectedIndex]['startdate']);
                $(tt).parent().next().next().next().next().text(data[tt.selectedIndex]['enddate']);
                $(tt).parent().next().next().next().next().next().text(data[tt.selectedIndex]['pcontent']);
                //alert(ii.html());

            }
            </script>
</div> 

        <div class="control-group">
            <label class="control-label">新项目名称</label>
            <div class="controls">
                <input type="text" class="span6 m-wrap" name="project_name">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">设置项目状态</label>
            <div class="controls">
                <select name='sts'>
                    <option value='1'>激活该项目</option>
                    <option value='0'>取消该项目</option>
                </select>
            </div>
        </div>
<div class="control-group">
    
    <label class="col-xs-2 control-label" style="text-align:left;width:100px">新项目起止日期
    </label>
    <label class="col-xs-10" >
        <table class='table table-hover table-bordered' style="width:250px">
                <thead>
                    <tr><td>项目开始日期</td><td>项目截止日期</td></tr>
                </thead>
                <tbody id='startenddate'>
                <tr>
                    <td><input type='text' class='form-control' name='startdate'/>
                    </td>
                    <td><input type='text' class='form-control' name='enddate'/>
                    </td></tr>

                </tbody>
            </table>
        </label>
</div>

	       <div class="control-group">
            <label class="control-label">新项目备注（不超过200个字，超出部分自动截取）</label>
                <textarea class="form-control span6" name="pcontent" rows="5"></textarea>
        </div>
		<button type="submit" class='btn blue'>修改项目</button>
	</form>

	</div>
	</div>
</div>
<?php
include(VIEWPATH."dashboard/include_js.php");
include(VIEWPATH."dashboard/root_footer.php");
?>

