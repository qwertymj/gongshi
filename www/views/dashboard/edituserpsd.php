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

	<form action="/dashboard/edituserpsd" method='post'>
        <div class="control-group">
            <label class="control-label" >员工账号:<?php echo $name;?></label>
        </div>
        <div class="control-group">
            <input type="hidden" name="name" value=<?php echo $name; ?> >
        </div>
        <br>


       <div class="control-group">
            <label class="control-label">新密码</label>
            <div class="controls">
                <input type="password" class="span6 m-wrap" name="passwd" >
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">再次输入新密码</label>
            <div class="controls">
                <input type="password" class="span6 m-wrap" name="passwdagain" >
            </div>
        </div> 



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

