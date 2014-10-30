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



<div class="control-group">
    
    <label class="col-xs-2 control-label" > <font size="4">员工列表</font>
            <form action="/dashboard/newuser" class="pull-right" method='get'>
                <button type="submit" class="btn blue" >新建员工</button>
            </form>
    </label>


    <label class="col-xs-10" >
        <table class='table table-hover table-bordered' >
                <thead>
                    <tr><td>员工账号</td><td>员工姓名</td><td>岗位</td><td></td><td></td><td></td></tr>
                </thead>
                <tbody >
    <?php
    //var_dump($Search_result);
    if(@$all_usr && $all_usr)
    {
        //project_code,project_name,startdate,enddate,sts,pcontent
        foreach($all_usr as $row){
            echo "<tr> <td>";
            echo $row['name'];
            echo "</td><td>"; 
            echo $row['username'];            
            echo "</td><td>";
            echo $row['job'];
            echo "</td><td>";?>

           
           <form action="/dashboard/edituser" method='get'>
                <input type="hidden" name="name" value=<?php echo $row['name']; ?> >

                <div align="center">

                    <button type="submit" class="btn blue" >修改员工信息</button>
                </div>
            </form>
            </td><td>
           <form action="/dashboard/edituserpsd" method='get'>
                <input type="hidden" name="name" value=<?php echo $row['name']; ?> >

                <div align="center">

                    <button type="submit" class="btn blue" >修改员工密码</button>
                </div>
            </form>
            </td><td>
            <form action="/dashboard/User_Maintain" method='post'>
                <input type="hidden" name="name" value=<?php echo $row["name"]; ?> >
                <input type="hidden" name="deleteuser" value=<?php echo 1; ?> >
                <input type="hidden" name="cur_page" value>
                <div align="center">

                    <button type="submit" class="btn blue" onclick="return show_confirm(this)" 
                    value=<?echo $row["name"];?>>
                    删除
                    </button>
                </div>

            </form>
            </td></tr>
     <?   }
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
            var msg='确认删除员工'+$(t).val()+'吗';
            if(confirm(msg)){
                //alert($("#page_links strong:first").text());
                $("[name='cur_page']").val( ($("#page_links strong:first").text()-1)*per_page);
                return true;
            }
            else
                return false;
        }

    </script> 

<form action="/dashboard/User_Maintain" method='post'>
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

