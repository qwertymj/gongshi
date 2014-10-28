<?php
include(VIEWPATH."dashboard/dashboard_header.php");
?>
<div class='row-fluid'>
    <div class="row-fluid">
    <div class="span12">

    <?php
    if(@$deletesuccess && $deletesuccess)
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



<div class="control-group">
    
    <label class="col-xs-2 control-label" >工时报告汇总
    </label>
    <label class="col-xs-10" >
        <table class='table table-hover table-bordered' >
                <thead>
                    <tr><td>项目代码</td><td>项目名称</td>
                        <td>报告状态</td><td>报告编号</td>
                        <td>提交人</td><td>审核人</td>
                        <td>工时数据数量</td><td>单价</td>
                        <td>金额</td><td>数据项编号</td><td>数据项名称</td><td></td>
                </tr>
                </thead>
                <tbody >
    <?php
    //var_dump($Search_result);
    $sts=array("报告已被取消","项目待申报","报告待审核","报告待结账","报告已结账");
    $total=0;
    if(@$Search_result && $Search_result)
    {
        //project_code,project_name,startdate,enddate,sts,pcontent
        foreach($Search_result as $row){
            $total+=$row['je'];
            echo "<tr><td>";
            echo $row['project_code'];
            echo "</td><td>"; 
            echo $row['project_name'];            
            echo "</td><td>";
            echo $sts[$row['sts']];
            echo "</td><td>";
            echo $row['work_log_id'];
            echo "</td><td>";
            echo $row['username'];            
            echo "</td><td>";
            echo $row['shrname'];            
            echo "</td><td>";
            echo $row['projectsum'];
            echo "</td><td>";
            echo $row['price'];
            echo "</td><td>";
            echo $row['je'];
            echo "</td><td>";
            echo $row['bh'];
            echo "</td><td>";
            echo $row['workunit'];?>
            </td><td>
                <form action="/dashboard/delete_work" method='post'>
                    <input type="hidden" name="work_log_id" value=<?php echo $row["work_log_id"]; ?> >
                    <input type="hidden" name="boss" value=<?php echo 1; ?> >
                    
                    <div align="center">
                        <button type="submit" class="btn" onclick="return show_confirm(this)">删除工时报告</button>
                    </div>

                </form>
            <? echo "</td></tr>";

        }
    }
?>
                </tbody>
            </table>

        </label>
        <div class="control-group">
            <label class="control-label " >
                总金额：<?echo $total;?>
            </label>
        </div>
        <div class="control-group">
            <label class="control-label" >
                大写：<?echo num_to_rmb($total);?>
            </label>
        </div>
</div>

<? 
function num_to_rmb($num){
        $c1 = "零壹贰叁肆伍陆柒捌玖";
        $c2 = "分角元拾佰仟万拾佰仟亿";
        //精确到分后面就不要了，所以只留两个小数位
        $num = round($num, 2); 
        //将数字转化为整数
        $num = $num * 100;
        if (strlen($num) > 10) {
                return "金额太大，请检查";
        } 
        $i = 0;
        $c = "";
        while (1) {
                if ($i == 0) {
                        //获取最后一位数字
                        $n = substr($num, strlen($num)-1, 1);
                } else {
                        $n = $num % 10;
                }
                //每次将最后一位数字转化为中文
                $p1 = substr($c1, 3 * $n, 3);
                $p2 = substr($c2, 3 * $i, 3);
                if ($n != '0' || ($n == '0' && ($p2 == '亿' || $p2 == '万' || $p2 == '元'))) {
                        $c = $p1 . $p2 . $c;
                } else {
                        $c = $p1 . $c;
                }
                $i = $i + 1;
                //去掉数字最后一位了
                $num = $num / 10;
                $num = (int)$num;
                //结束循环
                if ($num == 0) {
                        break;
                } 
        }
        $j = 0;
        $slen = strlen($c);
        while ($j < $slen) {
                //utf8一个汉字相当3个字符
                $m = substr($c, $j, 6);
                //处理数字中很多0的情况,每次循环去掉一个汉字“零”
                if ($m == '零元' || $m == '零万' || $m == '零亿' || $m == '零零') {
                        $left = substr($c, 0, $j);
                        $right = substr($c, $j + 3);
                        $c = $left . $right;
                        $j = $j-3;
                        $slen = $slen-3;
                } 
                $j = $j + 3;
        } 
        //这个是为了去掉类似23.0中最后一个“零”字
        if (substr($c, strlen($c)-3, 3) == '零') {
                $c = substr($c, 0, strlen($c)-3);
        }
        //将处理的汉字加上“整”
        // if (empty($c)) {
        //         return "零元整";
        // }else{
        //     return $c . "整";
        // }
        return $c;
} 
// function cny($ns) { 
//     static $cnums=array("零","壹","贰","叁","肆","伍","陆","柒","捌","玖"), 
//         $cnyunits=array("圆","角","分"), 
//         $grees=array("拾","佰","仟","万","拾","佰","仟","亿"); 
//     list($ns1,$ns2)=explode(".",$ns,2); 
//     $ns2=array_filter(array($ns2[1],$ns2[0])); 
//     $ret=array_merge($ns2,array(implode("",_cny_map_unit(str_split($ns1),$grees)),"")); 
//     $ret=implode("",array_reverse(_cny_map_unit($ret,$cnyunits))); 
//     return str_replace(array_keys($cnums),$cnums,$ret); 
// }

// function _cny_map_unit($list,$units) { 
//     $ul=count($units); 
//     $xs=array(); 
//     foreach (array_reverse($list) as $x) { 
//         $l=count($xs); 
//         if ($x!="0" || !($l%4)) $n=($x=='0'?'':$x).($units[($l-1)%$ul]); 
//         else $n=is_numeric($xs[0][0])?$x:''; 
//         array_unshift($xs,$n); 
//     } 
//     return $xs; 
// }
?>


    <script type="text/javascript">
        function show_confirm(t)
        {

            var msg='确认删除'+$(t).val()+'吗';
            return confirm(msg);
        }
    </script>

    </div>
    </div>
</div>
<?php
include(VIEWPATH."dashboard/include_js.php");
include(VIEWPATH."dashboard/root_footer.php");
?>

