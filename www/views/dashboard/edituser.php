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

	<form action="/dashboard/edituser" method='post'>
        <div class="control-group">
            <label class="control-label" >员工账号:<?php echo $userinfo['name'];?></label>
        </div>
        <br>
        <div class="control-group">
            <label class="control-label">员工姓名</label>
            <div class="controls">
                <input type="text" class="span6 m-wrap" name="new_username" value=<?php echo $userinfo['username'];?> >
            </div>
            <div class="controls">
                <input type="hidden" class="span6 m-wrap" name="name" value=<?php echo $userinfo['name'];?> >
            </div>
        </div>



        <div class="control-group">
            <label class="control-label">员工岗位</label>
            <div class="controls">
                <input type="text" class="span6 m-wrap" name="job" value=<?php echo $userinfo['job'];?>>
            </div>
        </div>
		<div class="form-group">
        <label for="" class="col-xs-2 control-label">员工权限</label>
        <label for="" class="col-xs-8">
            <table class="table table-hover col-xs-8">
                <tbody>
                    <tr>
                        <td>
                            <label class="checkbox inline">
                            <input type="checkbox" name="type1" value="1"
                            <?if($userinfo['role']&1) echo "checked=true";?>
                            >普通员工
                            </label></td>
                        <td>
                            <label class="checkbox inline">
                            <input type="checkbox" name="type2" value="2" 
                            <?if($userinfo['role']&2) echo "checked=true";?>
                            >中间人
                            </label></td>
                        <td>
                            <label class="checkbox inline">
                            <input type="checkbox" name="type3" value="4" 
                            <?if($userinfo['role']&4) echo "checked=true";?>
                            >财务
                            </label></td>
                        <td>
                            <label class="checkbox inline">
                             <input type="checkbox" name="type4" value="8" 
                            <?if($userinfo['role']&8) echo "checked=true";?>
                             >老板
                            </label></td>
                    </tr>
    
                </tbody>
            </table>
        </label>
  </div>
		<button type="submit" class='btn blue'>确认修改</button>
	</form>

	</div>
	</div>
</div>
<?php
include(VIEWPATH."dashboard/include_js.php");
include(VIEWPATH."dashboard/root_footer.php");
?>

