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

	<form action="/dashboard/editunit" method='post'>


<div class="control-group">
    
        <div class="controls">
            <input type="hidden" class="span6 m-wrap" name="unit_id" value=<?php echo $unit_info['id'];?>>
            <input type="hidden" class="span6 m-wrap" name="unit_oldbh" value=<?php echo $unit_info['bh'];?>>
        </div>

        <div class="control-group">
            <label class="control-label">工时数据编号</label>
            <div class="controls">
                <input type="text" class="span6 m-wrap" name="unit_bh" value=<?php echo $unit_info['bh'];?>>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">工时数据名称</label>
            <div class="controls">
                <input type="text" class="span6 m-wrap" name="workunit" value=<?php echo $unit_info['workunit'];?>>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">工时数据序号</label>
            <div class="controls">
                <input type="text" class="span6 m-wrap" name="seq" value=<?php echo $unit_info['seq'];?>>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">工时数据单位</label>
            <div class="controls">
                <input type="text" class="span6 m-wrap" name="unit_name" value=<?php echo $unit_info['unitname'];?>>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">工时数据单价</label>
            <div class="controls">
                <input type="text" class="span6 m-wrap" name="price" value=<?php echo $unit_info['price'];?>>
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

