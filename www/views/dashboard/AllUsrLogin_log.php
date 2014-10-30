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
    
    <label class="col-xs-2 control-label" >登录日志
    </label>
    <label class="col-xs-10" >
        <table class='table table-hover table-bordered' >
                <thead>
                    <tr><td>登录账号</td><td>登录人名字</td><td>登录时间</td><td>登录ip地址</td></tr>
                </thead>
                <tbody >
    <?php
    //var_dump($Search_result);
    if(@$Search_result && $Search_result)
    {
        //project_code,project_name,startdate,enddate,sts,pcontent
        foreach($Search_result as $row){
            echo "<tr><td>";
            echo $row['uname'];
            echo "</td><td>";
            echo $row['username'];
            echo "</td><td>";
            echo $row['login_datetime'];
            echo "</td><td>"; 
            echo $row['login_ip'];            
            echo "</td></tr>";
        }
    }
?>
                </tbody>
            </table>
        </label>
</div>

<form action="/dashboard/AllUsrLogin_log" method='post'>
<div align=center id="page_links">
<?echo $page_links;?>
&nbsp&nbsp&nbsp
<?  $totalpages=ceil($config['total_rows']/$config['per_page']);
    echo "共".$totalpages."页";
    //if($totalpages>1)
?>
&nbsp&nbsp&nbsp
跳转到第
<select style="position:relative; top:5px;height:20px;width:50px" name="cur_page">
    <?php 
        for($i=0;$i<$totalpages;$i++){
            $j=$i*$config['per_page'];
            if($j==$config['cur_page'])
                echo "<option value='".$j."' selected='true'>".($i+1)."</option>";
            else
                echo "<option value='".$j."'>".($i+1)."</option>";
        }
    ?>
</select>&nbsp
页
<font size=10>
<button type="submit" style="position:relative; top:10px;height:25px;width:50px">跳转</button>
</font>
</div>
</form>
<br><br>
<br><br>
	</div>
	</div>
</div>
<?php
include(VIEWPATH."dashboard/include_js.php");
include(VIEWPATH."dashboard/root_footer.php");
?>

