<?php
include(VIEWPATH."dashboard/dashboard_header.php");
?>
<div class='row-fluid'>
	<div class="row-fluid">
	<div class="span12">

    <?php
    if(@$success && $success)
    {
        ?> <div class="alert alert-success">查询成功！</div> <?php
    }
    else if (@$error && count($error) > 0) { ?>
        <div class="alert alert-warning">
            <?php foreach ($error as $one_error) { ?>
                <p><?php echo $one_error?></p>
            <?php } ?>
        </div>
    <?php } ?>



<div class="control-group">
    
    <label class="col-xs-2 control-label" >我的登录日志
    </label>
    <label class="col-xs-10" >
        <table class='table table-hover table-bordered' >
                <thead>
                    <tr><td>登录ip地址</td><td>登录时间</td></tr>
                </thead>
                <tbody >
    <?php
    //var_dump($Search_result);
    if(@$Search_result && $Search_result)
    {
        //project_code,project_name,startdate,enddate,sts,pcontent
        foreach($Search_result as $row){
            echo "<tr> <td>";
            echo $row['login_ip'];
            echo "</td><td>"; 
            echo $row['login_datetime'];            
            echo "</td></tr>";
        }
    }
?>
                </tbody>
            </table>
        </label>
</div>





	</div>
	</div>
</div>
<?php
include(VIEWPATH."dashboard/include_js.php");
include(VIEWPATH."dashboard/root_footer.php");
?>

