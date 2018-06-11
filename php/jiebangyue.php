<?php
include_once "../func.php";
include"db.php";
//ajax取当月分类数据 ok devid count(*)
if(isset($_POST['sb'])){
    $bbb = $_POST['sb'];
    $total_list="select substr(devid,1,2) as devid,count(*) from dev_unbundling where substr(unblingdate,1,7)='$bbb' GROUP BY substr(devid,1,2)";
    $dproduct=DB($total_list);
    echo json_encode($dproduct);
    exit;
}

//总数 ok count(*)
$total="select count(*) from dev_unbundling";
$t=DB($total);
// var_dump($t);

//每月统计 ok time count(*)
$sql = "select substr(unblingdate,1,7) AS time,count(*) from dev_unbundling GROUP BY substr(unblingdate,1,7) ORDER BY unblingdate DESC";
$p=DB($sql);

//拆线图 ok time,count(*)
$total_list=" select substr(unblingdate,1,7) AS time,count(*) from dev_unbundling GROUP BY substr(unblingdate,1,7) ORDER BY unblingdate";
$Tproduct=DB($total_list);
$tpro = array_column($Tproduct,'count(*)');
$arr = array_column($Tproduct,'time');
require_once "../html/jiebangyue.html";