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



<div class="control-group">
    
    <label class="col-xs-2 control-label" >我的项目
    </label>
    <label class="col-xs-10" >
        <table class='table table-hover table-bordered' >
                <thead>
                    <tr><td>项目代码</td><td>项目名称</td><td>项目状态</td><td>项目开始日期</td><td>项目截止日期</td><td>项目备注</td><td></td></tr>
                </thead>
                <tbody >
    <?php
    //var_dump($Search_result);
    if(@$Search_result && $Search_result)
    {
        //project_code,project_name,startdate,enddate,sts,pcontent
        foreach($Search_result as $row){
            echo "<tr> <td>";
            echo $row['project_code'];
            echo "</td><td>"; 
            echo $row['project_name'];            
            echo "</td><td>";
            if($row['sts']==1)
                echo "项目可申报";
            else if($row['sts']==0)
                echo "项目已被取消";
            echo "</td><td>";
            echo $row['startdate'];
            echo "</td><td>";
            echo $row['enddate'];
            echo "</td><td>";
            echo $row['pcontent'];
            echo "</td><td>";
            if($row['sts']==1) { ?>

           
            <form action="/dashboard/project_report" method='post'>
                <input type="hidden" name="project_code" value=<?php echo $row["project_code"]; ?> >
                <input type="hidden" name="project_id" value=<?php echo $row["id"]; ?> >
                <input type="hidden" name="report_view" value=<?php echo 1; ?> >

                
                <div align="center">

                    <button type="submit" class="btn" >申报该项目</button>
                </div>
            </form>
            <?php 
            }
           // else echo "</td><td>";
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

