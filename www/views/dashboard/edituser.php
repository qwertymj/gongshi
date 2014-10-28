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
                        <?$p=array("员工维护","项目维护","工时数据项维护","我的项目",
                        "我的工时报告","工时报告审核","工时报告结账","工时报告汇总","所有员工登录日志");
                        $j=1;
                        for($i=0;$i<9;$i++) {
                            if(!($i%3)) echo "</tr><tr>"; ?>
                        <td>
                            <label class="checkbox inline">
                            <input type="checkbox" name="type[]" value=<?echo $j;?>
                            <?if($userinfo['role']& $j) echo "checked=true";?>><?
                            echo $p[$i];  ?>
                            </label></td> <? $j<<=1;}?>
  
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

