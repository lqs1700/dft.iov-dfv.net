<?php
include_once "../func.php";
include"db.php";
//ajax取当天分类数据
if(isset($_POST['aaa'])){
	$aaa = $_POST['aaa'];
	$total_list="SELECT id,devid,
	CASE WHEN receipt_status = 2 THEN '流量包快到期' WHEN receipt_status=1 THEN '流量剩余不足'  END AS 'receipt_status' ,
	CASE WHEN productid = 0 THEN '-' WHEN productid = 8 THEN '99元包月' WHEN productid=9 THEN '5元1G' WHEN productid=10 THEN '9.9元3G' WHEN productid=11 THEN '赠送10G'  END AS 'productid' ,
	CASE WHEN productidString = 1 THEN '一天到期' WHEN productidString=2 THEN '两天到期' WHEN productidString=3 THEN '三天到期' WHEN productidString = 4 THEN '流量不足20%' WHEN productidString = 5 THEN '流量不足10%'  END AS 'productidString' ,
	receipttime
	FROM app_dataman_receipt
	WHERE SUBSTR(receipttime,1,10)='$aaa'";
	$Oproduct=DB($total_list);
	echo json_encode($Oproduct);
	exit;
}

//分类统计
if(isset($_POST['sb'])){
	$bbb = $_POST['sb'];
	$total_list="SELECT count(*),
	CASE WHEN productidString = 1 THEN '套餐一天后到期' WHEN productidString=2 THEN '套餐两天后到期' WHEN productidString=3 THEN '套餐三天后到期' WHEN productidString = 4 THEN '剩余流量不足20%' WHEN productidString = 5 THEN '剩余流量不足10%'  END AS 'productidString'
	FROM app_dataman_receipt
	WHERE SUBSTR(receipttime,1,10)='$bbb' group by productidString ORDER BY NULL";
	$dproduct=DB($total_list);
	echo json_encode($dproduct);
	exit;
}

//u总数
$total="select count(*) from app_dataman_receipt";
$t=DB($total);

//每日统计
$sql = "select count(*),substr(receipttime,1,10) from app_dataman_receipt GROUP BY substr(receipttime,1,10) order by receipttime desc";
$p=DB($sql);

 //当日产品数 
$sql = "select substr(DATE(NOW()),1,10),count(*) from app_dataman_receipt where substr(receipttime,1,10) = substr(DATE(NOW()),1,10)";
$tproduct=DB($sql);

//拆线图
$today = date('Y-m-d',time());
$total_list="select substr(receipttime,1,10),count(*) from app_dataman_receipt where substr(receipttime,1,10) BETWEEN '2017-01-01' and '$today' GROUP BY substr(receipttime,1,10) ORDER BY NULL";
$Tproduct=DB($total_list);
$tpro = array_column($Tproduct,'count(*)');
$arr = array_column($Tproduct,'substr(receipttime,1,10)');
require_once "../html/tuisongtongji.html";