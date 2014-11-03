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
            //echo "qeqweq";
            ?> <div class="alert alert-success">确认成功！</div> <?php
        }
        if($addsuccess==2){
            //echo "qeqweq1ewqeqw";
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
    
    <label class="col-xs-2 control-label" >待审核工时报告
    </label>
    <label class="col-xs-10" >
        <table class='table table-hover table-bordered' >
                <thead>
                    <tr><td>项目代码</td><td>项目名称</td>
                        <td>报告状态</td><td>报告编号</td><td>申请时间</td>
                        <td>报告人</td><td>数量</td>
                        <td>单价</td><td>金额</td>
                        <td>数据项编号</td><td>数据项名称</td>
                        <td></td><td></td></tr>
                </thead>
                <tbody >
    <?php
    $sts=array("报告已被取消","项目待申报","报告待审核","报告待结账","报告已结账");
    //var_dump($Search_result);
    //$l=substr($_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/') + 1);

    if(@$SHSearch_res && $SHSearch_res)
    {
        //project_code,project_name,startdate,enddate,sts,pcontent
        foreach($SHSearch_res as $row){
            echo "<tr><td>";
            echo $row['project_code'];
            echo "</td><td>"; 
            echo $row['project_name'];            
            echo "</td><td>";
            echo $sts[$row['sts']];
            echo "</td><td>";
            $a=$row['work_log_id'];
            if(strlen($a)<6)
                echo substr_replace('000000', $a, 0 - strlen($a));
            else echo $a;
            echo "</td><td>";
            echo $row['logdate'];
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
                <input type="hidden" name="cur_page" >
                
                
                <div align="center">

                    <button type="submit" class="btn blue" onclick="return show_yesconfirm(this)" value=<?php echo $row["work_log_id"]; ?> >通过</button>
                </div>
            </form>
            </td><td>
            <form action="/dashboard/SHProject" method='post'>
                <input type="hidden" name="sts" value=<?php echo $row["sts"]; ?> >
                <input type="hidden" name="work_log_id" value=<?php echo $row["work_log_id"]; ?>>
                <input type="hidden" name="SH_result" value=<?php echo 2; ?> >
                <input type="hidden" name="cur_page" >
                
                
                <div align="center">

                    <button type="submit" class="btn blue" onclick="return show_noconfirm(this)" value=<?php echo $row["work_log_id"]; ?>>不通过</button>
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

    <script type="text/javascript">
        <? $per_page = json_encode($config['per_page']);
        echo "var per_page =".$per_page.";";?>
        function show_yesconfirm(t)
        {
            var msg='确认审核通过工时报告'+$(t).val()+'吗';
            if(confirm(msg)){
                //alert($("#page_links strong:first").text());
                $("[name='cur_page']").val( ($("#page_links strong:first").text()-1)*per_page);
                return true;
            }
            else
                return false;
        }
        
        function show_noconfirm(t)
        {
            var msg='确认拒绝工时报告'+$(t).val()+'吗';
            if(confirm(msg)){
                //alert($("#page_links strong:first").text());
                $("[name='cur_page']").val( ($("#page_links strong:first").text()-1)*per_page);
                return true;
            }
            else
                return false;
        }

    </script> 

<form action="/dashboard/SHProject" method='post'>
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

