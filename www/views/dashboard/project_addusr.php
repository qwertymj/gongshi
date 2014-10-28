<?php
include(VIEWPATH."dashboard/dashboard_header.php");
?>
<div class='row-fluid'>
	<div class="row-fluid">
	<div class="span12">

    <?php
    //var_dump($error);
    if(@$success && $success)
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


	<form action="/dashboard/project_addusr" method='post'>
        <div class="control-group">
            <label class="control-label">项目代码:<?php echo $project_code;?></label>
        </div>
		<div class="control-group">
			
			<div class="controls">
				<input type="hidden" name="project_code" value=<?php echo $project_code; ?>>
			</div>
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
        <table class='table table-hover table-bordered' style="width:200px">
                <thead>
                    <tr><td>员工姓名</td><td></td></tr>
                </thead>
                <tbody id='project_add_user_table'>
                <tr>
                    <td>
                        <!-- <input type='text' class='col-xs-2' name='project_user[]'/>  -->
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
            // $().dropdown('toggle');
                $('#project_add_user').click(function() {
                    $('#project_add_user_table').append("<tr><td><select name='project_user[]'><?php foreach($all_usr as $usr){echo "<option value='".$usr['name']."'>".$usr['name']."</option>";}?></select></td><td><button type='button' class='close' aria-hidden='true' onclick='removeCloseMe(this)'>&times;</button></td></tr>")
                })
                function removeCloseMe(obj) {
                    $(obj).parent().parent().remove();
                }
            </script>
    </div>
		<button type="submit" class='btn blue'>确定添加</button>
	</form>

	</div>
	</div>
</div>
<?php
include(VIEWPATH."dashboard/include_js.php");
include(VIEWPATH."dashboard/root_footer.php");
?>

