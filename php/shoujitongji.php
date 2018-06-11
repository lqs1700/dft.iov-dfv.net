<?php
include_once "../func.php";
include"db.php";
//ajax取当天分类数据
if(isset($_POST['aaa'])){
	$aaa = $_POST['aaa'];
	$total_list="SELECT a.username,a.userphone,a.devid,a.sendtime,b.content  FROM `bss_sms_history` a LEFT JOIN `bss_sms_model` b ON a.modelnumber = b.modelnumber WHERE substr(a.sendtime,1,10) = '$aaa' ORDER BY a.sendtime DESC";
	$Oproduct=DB($total_list);
	echo json_encode($Oproduct);
	exit;
}

//分类统计
if(isset($_POST['sb'])){
	$bbb = $_POST['sb'];
	$total_list="SELECT count(*),b.content FROM `bss_sms_history` a LEFT JOIN `bss_sms_model` b ON a.modelnumber = b.modelnumber WHERE substr(a.sendtime,1,10) = '$bbb' GROUP BY b.content ORDER BY a.sendtime DESC";
	$dproduct=DB($total_list);
	echo json_encode($dproduct);
	exit;
}
//u总数
$total="SELECT count(*) FROM bss_sms_history";
$t=DB($total);

//每日统计
$sql = "SELECT count(*),substr(sendtime,1,10) FROM `bss_sms_history` GROUP BY substr(sendtime,1,10) ORDER BY sendtime DESC";
$p=DB($sql);

//当日产品数
$sql = "select substr(DATE(NOW()),1,10),count(*) from bss_sms_history where substr(sendtime,1,10) = substr(DATE(NOW()),1,10)";
$tproduct=DB($sql);

//拆线图
$today = date('Y-m-d',time());
$total_list="select substr(sendtime,1,10),count(*) from bss_sms_history where substr(sendtime,1,10) BETWEEN '2017-01-01' and '$today' GROUP BY substr(sendtime,1,10)";
$Tproduct=DB($total_list);
$tpro = array_column($Tproduct,'count(*)');
$arr = array_column($Tproduct,'substr(sendtime,1,10)');
require_once "../html/shoujitongji.html";