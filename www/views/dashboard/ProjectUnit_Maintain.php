<?php
include(VIEWPATH."dashboard/dashboard_header.php");
?>
<div class='row-fluid'>
	<div class="row-fluid">
	<div class="span12">

    <?php
    if(@$success && $success)
    {
        ?> <div class="alert alert-success">操作成功！</div> <?php
    }
    else if (@$error && count($error) > 0) { ?>
        <div class="alert alert-warning">
            <?php foreach ($error as $one_error) { ?>
                <p><?php echo $one_error?></p>
            <?php } ?>
        </div>
    <?php } ?>



<div class="form-group">
    
    <label class="col-xs-2 control-label" >所有工时数据
            <form action="/dashboard/newunit" class="pull-right" method='get'>
                <button type="submit" class="btn blue" >新建工时数据</button>
            </form>
    </label>
    <label class="col-xs-10" >
        <table class='table table-hover table-bordered' >
                <thead>
                    <tr><td>工时数据编号</td><td>工时数据名称</td><td>工时数据单位</td><td>工时数据单价</td><td></td><td></td></tr>
                </thead>
                <tbody >
    <?php
    //var_dump($Search_result);
    if(@$all_unit && $all_unit)
    {
        //project_code,project_name,startdate,enddate,sts,pcontent
        foreach($all_unit as $row){
            echo "<tr> <td>";
            echo $row['bh'];
            echo "</td><td>"; 
            echo $row['workunit'];            

            echo "</td><td>";
            echo $row['unitname'];
            echo "</td><td>";
            echo $row['price'];
            echo "</td><td>";
?>
            <form action="/dashboard/editunit" method='get'>
                <input type="hidden" name="unit_bh" value=<?php echo $row["bh"]; ?> >
                <input type="hidden" name="unit_id" value=<?php echo $row["id"]; ?> >
                
                <div align="center">
                    <button type="submit" class="btn blue" >工时数据修改</button>
                </div>
            </form>
            

            </td><td>

            <form action="/dashboard/ProjectUnit_Maintain" method='post'>
                <input type="hidden" name="unit_bh" value=<?php echo $row["bh"]; ?> >
                 <input type="hidden" name="deleteunit" value=<?php echo 1; ?> >
                <input type="hidden" name="cur_page" >
 
                <div align="center">

                    <button type="submit" class="btn blue" onclick="return show_confirm(this)"  value=<?php echo $row["bh"]; ?>>删除该工时数据</button>
                </div>   
            </form> 

           </td></tr>
        <?}
    }
?>
                </tbody>
            </table>
        </label>
</div>


    <script type="text/javascript">
        <? $per_page = json_encode($config['per_page']);
        echo "var per_page =".$per_page.";";?>
        function show_confirm(t)
        {
            var msg='确认删除工时数据'+$(t).val()+'吗';
            if(confirm(msg)){
                //alert($("#page_links strong:first").text());
                $("[name='cur_page']").val( ($("#page_links strong:first").text()-1)*per_page);
                return true;
            }
            else
                return false;
        }

    </script> 

<form action="/dashboard/ProjectUnit_Maintain" method='post'>
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

