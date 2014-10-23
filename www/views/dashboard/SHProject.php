<?php
include(VIEWPATH."dashboard/dashboard_header.php");
?>
<div class='row-fluid'>
	<div class="row-fluid">
	<div class="span12">

    <?php
    if(@$addsuccess && $addsuccess)
    {
        if($addsuccess==1){
            ?> <div class="alert alert-success">确认成功！</div> <?php
        }
        else if($addsuccess==0){
            ?> <div class="alert alert-success">拒绝成功！</div> <?php
        }
    }
    else if (@$error && count($error) > 0) { ?>
        <div class="alert alert-warning">
            <?php foreach ($error as $one_error) { ?>
                <p><?php echo $one_error?></p>
            <?php } ?>
        </div>
    <?php } ?>



<div class="form-group">
    
    <label class="col-xs-2 control-label" >我的项目
    </label>
    <label class="col-xs-10" >
        <table class='table table-hover table-bordered' >
                <thead>
                    <tr><td>项目代码</td><td>项目名称</td><td>项目状态</td><td>项目提交人</td><td>材料总数</td><td>材料单价</td><td>项目总金额</td><td>材料编号</td><td>材料名称</td><td></td><td></td></tr>
                </thead>
                <tbody >
    <?php
    $sts=array("项目已被取消","项目待申报","项目待审核","项目待结账","项目已结账");
    //var_dump($Search_result);
    if(@$SHSearch_res && $SHSearch_res)
    {
        //project_code,project_name,startdate,enddate,sts,pcontent
        foreach($SHSearch_res as $row){
            echo "<tr> <td>";
            echo $row['project_code'];
            echo "</td><td>"; 
            echo $row['project_name'];            
            echo "</td><td>";
            echo $sts[$row['sts']];
            echo "</td><td>";
            echo $row['uname'];
            echo "</td><td>";
            echo $row['projectsum'];
            echo "</td><td>";
            echo $row['price'];
            echo "</td><td>";
            echo $row['je'];
            echo "</td><td>";
            echo $row['bh'];
            echo "</td><td>";
            echo $row['workunit'];
            echo "</td><td>";
            if($row['sts']==2) { ?>

           
            <form action="/dashboard/SHProject" method='post'>
                <input type="hidden" name="sts" value=<?php echo $row["sts"]; ?> >
                <input type="hidden" name="work_log_id" value=<?php echo $row["work_log_id"]; ?> >
                <input type="hidden" name="SH_result" value=<?php echo 1; ?> >

                
                <div align="center">

                    <button type="submit" class="btn" >确认该项目</button>
                </div>
            </form>
            </td><td>
            <form action="/dashboard/SHProject" method='post'>
                <input type="hidden" name="sts" value=<?php echo $row["sts"]; ?> >
                <input type="hidden" name="work_log_id" value=<?php echo $row["work_log_id"]; ?>>
                <input type="hidden" name="SH_result" value=<?php echo 0; ?> >

                
                <div align="center">

                    <button type="submit" class="btn" >拒绝该项目</button>
                </div>
            </form>
            <?php 
            }
            else echo "</td><td>";
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

