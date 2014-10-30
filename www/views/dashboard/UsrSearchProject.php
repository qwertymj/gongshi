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

                    <button type="submit" class="btn blue" >新建工时报告</button>
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

<form action="/dashboard/UsrSearchProject" method='post'>
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



	</div>
	</div>
</div>
<?php
include(VIEWPATH."dashboard/include_js.php");
include(VIEWPATH."dashboard/root_footer.php");
?>

