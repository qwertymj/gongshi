<?php
include(VIEWPATH."dashboard/dashboard_header.php");
?>

<div class='row-fluid'>
	<div class="row-fluid">
	<div class="span12">

    <?php
    if(@$success && $success)
    {
        ?> <div class="alert alert-success">删除成功！</div> <?php
    }
    else if (@$error && count($error) > 0) { ?>
        <div class="alert alert-warning">
            <?php foreach ($error as $one_error) { ?>
                <p><?php echo $one_error?></p>
            <?php } ?>
        </div>
    <?php } ?>

	<form action="/dashboard/deleteunit" method='post'>

<div class="control-group">
    

    <label class="col-xs-10" >
        <table class='table table-hover table-bordered' >
                <thead>
                    <tr><td style='width: 150px;'>工时数据编号</td><td style='width: 150px;'>工时数据名称</td><td style='width: 150px;'>工时数据单位</td><td style='width: 150px;'>工时数据单价</td></tr>
                </thead>
                <tbody id='project_edit_unit_table'>
                <tr> 
                    <td>
                        <select name='unit_bh' onChange="changeData(this)">
                        <?php foreach($all_unit as $unit){
                            echo "<option value='".$unit['bh']."'>".$unit['bh']."</option>";
                        }
                        ?>
                    </select>
                    </td>
                    <td><?if(count($all_unit)>0) echo $all_unit[0]['workunit']?></td>
                    <td><?if(count($all_unit)>0) echo $all_unit[0]['unitname']?></td>
                    <td><?if(count($all_unit)>0) echo $all_unit[0]['price']?></td>
                </tr>


                </tbody>
            </table>
        </label>
            <script type="text/javascript">  

            <? $all_unitJson = json_encode($all_unit);
            echo "var data =".$all_unitJson;?>
            //alert(data);
            function changeData(tt){
                $(tt).parent().next().text(data[tt.selectedIndex]['workunit']);
                $(tt).parent().next().next().text(data[tt.selectedIndex]['unitname']);
                $(tt).parent().next().next().next().text(data[tt.selectedIndex]['price']);
                //alert(ii.html());

            }
            </script>
</div>      
            <button type="submit" class='btn blue'>删除单位</button>
    </form>

</div>
	</div>
</div>
<?php
include(VIEWPATH."dashboard/include_js.php");
include(VIEWPATH."dashboard/root_footer.php");
?>

