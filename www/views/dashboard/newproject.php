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


	<form action="/dashboard/newproject" method='post'>
		<div class="control-group">
			<label class="control-label">项目代码</label>
			<div class="controls">
				<input type="text" class="span6 m-wrap" name="project_code">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label">项目名称</label>
			<div class="controls">
				<input type="text" class="span6 m-wrap" name="project_name">
			</div>
		</div>
        <div class="control-group">
            <label class="control-label">项目序号</label>
            <div class="controls">
                <input type="text" class="span6 m-wrap" name="project_seq">
            </div>
        </div>


<div class="form-group">
    
    <label class="col-xs-2 control-label" style="text-align:left;width:100px">项目起止日期
    </label>
    <label class="col-xs-10" >
        <table class='table table-hover table-bordered' style="width:250px">
                <thead>
                    <tr><td>项目开始日期</td><td>项目截止日期</td></tr>
                </thead>
                <tbody id='startenddate'>
                <tr>
                    <td>
                        <input type='text' class='Wdate form-control' name='startdate' onclick="WdatePicker({isShowClear:true,readOnly:true})"/>
                    </td>
                    <td><input type='text' class='Wdate form-control' name='enddate' onclick="WdatePicker({isShowClear:true,readOnly:true})"/>
                    </td></tr>

                </tbody>
            </table>
        </label>
</div>

<div class="form-horizontal">
<div class="control-group">
    
    <label class="col-xs-2 control-label" style="text-align:left;width:100px">添加项目员工
        <br><br>
        <p>
            <button type='button' id='project_add_user' class='btn green' onclick>添加员工</button>
        </p>
    </label>
    <label class="col-xs-10" >
        <table class='table table-hover table-bordered' style="width:250px">
                <thead>
                    <tr><td>员工姓名</td><td></td></tr>
                </thead>
                <tbody id='project_add_user_table'>
                <tr>
                    <td>
                        <select name="project_user[]" ><!-- onChange="changeData(this.value)"> -->
                        <!-- <option selected="selected" >请选择员工</option> -->
                        <?php 
                            foreach($all_usr as $usr){
                                echo "<option value='".$usr['name']."'>".$usr['name']."</option>";
                            }

                        ?>
                        </select>
                    </td>
                    <td><button type='button' class='close' aria-hidden='true' onclick='removeCloseMe(this)'>
                    &times;</button>
                    </td></tr>

                </tbody>
            </table>
        </label>
</div>
            <script type="text/javascript">
                $('#project_add_user').click(function() {
                    $('#project_add_user_table').append("<tr><td><select name='project_user[]'><?php foreach($all_usr as $usr){echo "<option value='".$usr['name']."'>".$usr['name']."</option>";}?></select></td><td><button type='button' class='close' aria-hidden='true' onclick='removeCloseMe(this)'>&times;</button></td></tr>")
                })
                function removeCloseMe(obj) {
                    $(obj).parent().parent().remove();
                }
            </script>
    </div>


	       <div class="control-group">
            <label class="control-label">项目备注（不超过200个字，超出部分自动截取）</label>
                <textarea class="form-control span6" name="pcontent" rows="10"></textarea>
        </div>
		<button type="submit" class='btn blue'>新建项目</button>
	</form>

	</div>
	</div>
</div>
<?php
include(VIEWPATH."dashboard/include_js.php");
include(VIEWPATH."dashboard/root_footer.php");
?>

