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
<?//var_dump($project_info);?>
        <div class="control-group">
            <label class="control-label" >项目代码:<?php echo $project_info['project_code'];?></label>
        </div>
            <div class="controls">
                <input type="hidden" class="span6 m-wrap" name="project_code" value=<?php echo $project_info['project_code'];?> >
            </div>
        <div class="control-group">
            <label class="control-label">项目名称</label>
            <div class="controls">
                <input type="text" class="span6 m-wrap" name="project_name" value=<?php echo $project_info['project_name'];?>>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">当前项目序号</label>
            <div class="controls">
                <input type="text" class="span6 m-wrap" name="project_seq" value=<?php echo $project_info['seq'];?>>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" >当前项目状态:<?php if($project_info['sts']) echo "进行中"; else echo "已取消"?></label>
        </div>

        <div class="control-group">
            <label class="control-label">设置项目状态</label>
            <div class="controls">
                <select name='sts'>
                    <option value='1' <?if($project_info['sts']==1) echo "selected=true";?>>激活该项目</option>
                    <option value='0' <?if($project_info['sts']==0) echo "selected=true";?>>取消该项目</option>
                </select>
            </div>
        </div>
<div class="control-group">
    
    <label class="col-xs-2 control-label" style="text-align:left;width:100px">项目起止日期
    </label>
    <label class="col-xs-10" >
        <table class='table table-hover table-bordered' style="width:250px">
                <thead>
                    <tr><td>项目开始日期</td><td>项目截止日期</td></tr>
                </thead>
                <tbody id='startenddate'>
                <tr>

                    <td><input type='text' class='Wdate form-control' name='startdate' value=<?php echo $project_info['startdate'];?> onclick="WdatePicker({isShowClear:true,readOnly:true})">
                    </td>
                    <td><input type='text' class='Wdate form-control' name='enddate' value=<?php echo $project_info['enddate'];?> onclick="WdatePicker({isShowClear:true,readOnly:true})">
                    </td></tr>

                </tbody>
            </table>
        </label>
</div>

	       <div class="control-group">
            <label class="control-label">新项目备注（不超过200个字，超出部分自动截取）</label>
                <textarea class="form-control span6" name="pcontent" rows="5"><?php echo $project_info['pcontent'];?></textarea>
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

