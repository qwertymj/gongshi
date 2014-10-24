<?php
include(VIEWPATH."dashboard/dashboard_header.php");
?>
<div class='row-fluid'>
    <div class="row-fluid">
    <div class="span12">

    <?php
    //var_dump($error);
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


    <form action="/dashboard/deleteuser" method='post'>

<div class="form-horizontal">
<div class="control-group">

    <label class="col-xs-10" >
        <table class='table table-hover table-bordered' style="width:200px">
                <thead>
                    <tr><td>员工姓名</td></tr>
                </thead>
                <tbody id='all_user_table'>
                <tr>
                    <td>
                        <!-- <input type='text' class='col-xs-2' name='project_user[]'/>  -->
                        <select name="username" ><!-- onChange="changeData(this.value)"> -->
                        <!-- <option selected="selected" >请选择员工</option> -->
                        <?php 
                            
                            foreach($all_usr as $usr){
                                echo "<option value='".$usr['name']."'>".$usr['name']."</option>";
                                
                            }

                        ?>
                        </select>
                    </td>
                </tr>

                </tbody>
            </table>
        </label>
</div>

    </div>
        <button type="submit" class='btn blue'>确定删除</button>
    </form>

    </div>
    </div>
</div>
<?php
include(VIEWPATH."dashboard/include_js.php");
include(VIEWPATH."dashboard/root_footer.php");
?>

