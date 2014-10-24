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

	<form action="/dashboard/newunit" method='post'>
		<div class="control-group">
			<label class="control-label">工时数据单位名</label>
			<div class="controls">
				<input type="text" class="span6 m-wrap" name="unit_name">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label">工时数据单价</label>
			<div class="controls">
				<input type="text" class="span6 m-wrap" name="price">
			</div>
		</div>

		<div class="control-group">
			<label class="control-label">工时数据名称</label>
			<div class="controls">
				<input type="text" class="span6 m-wrap" name="workunit">
			</div>
		</div>
		

        <div class="control-group">
            <label class="control-label">编号</label>
            <div class="controls">
                <input type="text" class="span6 m-wrap" name="bh">
            </div>
        </div>
        <button type="submit" class='btn blue'>新建单位</button>
	</form>

	</div>
	</div>
</div>
<?php
include(VIEWPATH."dashboard/include_js.php");
include(VIEWPATH."dashboard/root_footer.php");
?>

