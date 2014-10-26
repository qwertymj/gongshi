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
                <button type="submit" class="btn" >新建工时数据</button>
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
                <div align="center">
                    <button type="submit" class="btn" >工时数据修改</button>
                </div>
            </form>
            

            </td><td>

            <form action="/dashboard/deleteunit" method='post'>
                <input type="hidden" name="unit_bh" value=<?php echo $row["bh"]; ?> >
                <div align="center">

                    <button type="submit" class="btn" onclick="show_confirm(this)"  value=<?php echo $row["bh"]; ?>>删除该工时数据</button>
                </div>
                <script type="text/javascript">
                    function show_confirm(t)
                    {

                        var msg='确认删除工时数据'+$(t).val()+'吗';
                        var r=confirm(msg);
                        if (r==true){
                           $(t).append("<input type='hidden' name='delete' value='yes'; >");
                
                        }
                        else{
                            $(t).append("<input type='hidden' name='delete' value='no'; >");
                            //$(t).val("no");
                        }
                    }
                </script>    
            </form> 

           </td></tr>
        <?}
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

