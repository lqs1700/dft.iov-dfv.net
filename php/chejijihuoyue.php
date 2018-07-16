<?php
include_once "../func.php";
include"db.php";
//ajax取当月分类数据 ok  省份+数量 NAME+COUNT(*)
if(isset($_POST['sb'])){
    $bbb = $_POST['sb'];
    $total_list="SELECT
	ccc.NAME,COUNT(*)
	FROM
	(
	SELECT
	aaa.*, bbb. NAME
	FROM
	(
	SELECT
	a.devid AS devid,
	a.dealerphone AS dealerphone
	FROM
	dfqc.dev_user a,
	dfqc.dev_store b
	WHERE
	a.devid = b.devicenumber
	AND a.username NOT IN ('张三', '联创测试')
	AND b.storestatus='1'
	AND b.devicenumber NOT LIKE '%yj%'
	AND substr(a.regdate,1,7)='$bbb'
	) aaa
	LEFT JOIN (
	SELECT
	a.dealerphone AS dealerphone1,
	b. NAME AS NAME
	FROM
	dfqc.bss_dealer a,
	dfqc.reg_provincial b
	WHERE
	a.partner_id = b.id
	) bbb ON aaa.dealerphone = bbb.dealerphone1
	) ccc
	GROUP BY ccc.NAME order by count(*) desc";
    $dproduct=DB($total_list);
    echo json_encode($dproduct);
    exit;
}

//总数 ok 所有总数 COUNT(*)
$total="SELECT COUNT(*)
	FROM
	(
	SELECT
	aaa.*, bbb. NAME
	FROM
	(
	SELECT
	a.devid AS devid,
	a.dealerphone AS dealerphone
	FROM
	dfqc.dev_user a,
	dfqc.dev_store b
	WHERE
	a.devid = b.devicenumber
	AND a.username NOT IN ('张三', '联创测试')
	AND b.storestatus='1'
	AND b.devicenumber NOT LIKE '%yj%'
	) aaa
	LEFT JOIN (
	SELECT
	a.dealerphone AS dealerphone1,
	b. NAME AS NAME
	FROM
	dfqc.bss_dealer a,
	dfqc.reg_provincial b
	WHERE
	a.partner_id = b.id
	) bbb ON aaa.dealerphone = bbb.dealerphone1
	) ccc";
$t=DB($total);
// var_dump($t);

//每月统计 OK 时间+数量 time+COUNT(*)
$sql = "SELECT time,COUNT(*)
	FROM
	(
	SELECT
	aaa.*, bbb. NAME
	FROM
	(
	SELECT
	a.devid AS devid,
	a.dealerphone AS dealerphone,
	substr(a.regdate,1,7) as time
	FROM
	dfqc.dev_user a,
	dfqc.dev_store b
	WHERE
	a.devid = b.devicenumber
	AND a.username NOT IN ('张三', '联创测试')
	AND b.storestatus='1'
	AND b.devicenumber NOT LIKE '%yj%'
	) aaa
	LEFT JOIN (
	SELECT
	a.dealerphone AS dealerphone1,
	b. NAME AS NAME
	FROM
	dfqc.bss_dealer a,
	dfqc.reg_provincial b
	WHERE
	a.partner_id = b.id
	) bbb ON aaa.dealerphone = bbb.dealerphone1
	) ccc
	GROUP BY ccc.time order by ccc.time desc";
$p=DB($sql);

//拆线图
$total_list=" SELECT time,COUNT(*)
	FROM
	(
	SELECT
	aaa.*, bbb. NAME
	FROM
	(
	SELECT
	a.devid AS devid,
	a.dealerphone AS dealerphone,
	substr(a.regdate,1,7) as time
	FROM
	dfqc.dev_user a,
	dfqc.dev_store b
	WHERE
	a.devid = b.devicenumber
	AND a.username NOT IN ('张三', '联创测试')
	AND b.storestatus='1'
	AND b.devicenumber NOT LIKE '%yj%'
	) aaa
	LEFT JOIN (
	SELECT
	a.dealerphone AS dealerphone1,
	b. NAME AS NAME
	FROM
	dfqc.bss_dealer a,
	dfqc.reg_provincial b
	WHERE
	a.partner_id = b.id
	) bbb ON aaa.dealerphone = bbb.dealerphone1
	) ccc
	GROUP BY ccc.time order by ccc.time";
$Tproduct=DB($total_list);
$tpro = array_column($Tproduct,'COUNT(*)');
$arr = array_column($Tproduct,'time');
require_once "../html/chejijihuoyue.html";