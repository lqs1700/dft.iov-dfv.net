<?php
include_once "../func.php";
//总数
include "db.php";
$sql= "select count(*) from dev_unbundling";
$nums = DB($sql);

//机型
$sql = "select DISTINCT substr(devid,1,2) from dev_unbundling";
$res = DB($sql);
//var_dump($res);

$devid = array();//车机类型
foreach($res as $val){
$devid[] = $val['substr(devid,1,2)'];
}
$arr = array();

for($i=0;$i<count($devid);$i++){
$sql = "select count(*) from dev_unbundling where substr(devid,1,2) = '$devid[$i]'";
$arr[$i] = DB($sql);
}

foreach($arr as $va)
{
foreach($va as $valu)
{
$num[]=$valu['count(*)'];//车机数量
}
}
$arr2 = array();
for($i=0;$i<count($devid);$i++){
$arr2[]=[$devid[$i]=>$num[$i]];
}
//当天
$today=date('Y-m-d',time());

$sql= "select count(*) from dev_unbundling where substr(unblingdate,1,10)='$today'";
$Tnum= DB($sql);//今日总数
//var_dump($Tnum);

//总数 当日
//机型 当日解绑机型
$sql = "select DISTINCT substr(devid,1,2) from dev_unbundling where substr(unblingdate,1,10)='$today'";
$Dres = DB($sql);
//var_dump($Dres);

$Ddevid = array();//今日车机类型
foreach($Dres as $val)
{
$Ddevid[] = $val['substr(devid,1,2)'];
}

$Darr = array();
for($i=0;$i<count($Ddevid);$i++)
{
$sql = "select count(*) from dev_unbundling where substr(devid,1,2) = '$Ddevid[$i]' and substr(unblingdate,1,10)='$today'";
$Darr[$i] = DB($sql);
}
foreach($Darr as $va)
{
foreach($va as $valu)
{
$Dnum[]=$valu['count(*)'];//车机数量
}
}

$Darr2 = array();
for($i=0;$i<count($Darr);$i++){
$Darr2[]=[$Ddevid[$i]=>$Dnum[$i]];
}
$arr = array();
$toda = strtotime(date('Y-m-d'));
$arr = array();
$tpro = array();


$total_list="select substr(unblingdate,1,10),count(*) from dev_unbundling GROUP BY substr(unblingdate,1,10)";
$Tproduct=DB($total_list);

$tpro = array_column($Tproduct,'count(*)');
$arr = array_column($Tproduct,'substr(unblingdate,1,10)');
require_once "../html/jiebangtongji.html";