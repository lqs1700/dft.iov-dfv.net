<?php
header('Content-type:text/html;charset=utf-8');

$type = isset($type)?$type:1;
switch ($type)
{
    case 2:
        $con = mysqli_connect('36.111.195.234:3306','root','dfqc1219','dfqc_db'); //摇奖
    break;

    case 1:
        $con = mysqli_connect('180.101.255.3:3306','test','123456','dfqc');       //测试库
        //$con = mysqli_connect('df-db-master','wx','wx234','dfqc');//正式库
    break;

    case 3:
        $con = mysqli_connect('180.101.255.3:3306','test','123456','dfqc');         //测试库
        //$con = mysqli_connect('180.101.254.177:33066','lqs','lqs@123456','dfqc'); //经纬度上海节点正式库
    break;
}

if(mysqli_connect_errno($con))
    die('错误信息:'.mysqli_connect_error($con));

mysqli_query($con , 'set names utf8');
date_default_timezone_set('PRC');

function DB($sql = '' , $type = MYSQLI_ASSOC){
    global $con;
    if($sql == '')
        return false;
    $res = mysqli_query($con , $sql);
    if($errno=mysqli_errno($con))
        die('错误码:'.$errno.',错误信息:'.mysqli_error($con));

    $sql = strtolower($sql);
    if(substr_count($sql , 'select'))
    {
        $rows = array();
        while($row = mysqli_fetch_array($res , $type))
        {
            $rows[] = $row;
        }
        return $rows;
    }elseif(substr_count($sql , 'insert')){
        return mysqli_insert_id($con);
    }else{
        $affected = mysqli_affected_rows($con);
        return $affected >= 0 ? $affected : '0';
    }
}

function xiazai($stmt,$head,$filename)
{
set_time_limit(0);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename='.$filename);
//header('Cache-Control: max-age=0');
$fp = fopen('php://output', 'a');
foreach ($head as $i => $v) {
    $head[$i] = $v;
}
fputcsv($fp, $head);
$cnt = 0;
$limit = 100000;
foreach ($stmt as $va){
    $cnt ++;
    if ($limit == $cnt) {
        ob_flush();
        flush();
        $cnt = 0;
    }
    foreach ($va as $i => $v) {
        $row[$i] = $v?$v:'-';
    }
    fputcsv($fp, $row);
}
}