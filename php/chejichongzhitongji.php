<?php
include_once "../func.php";
include"db.php";
// ajax取当天分类数据
if(isset($_POST['aaa'])){
    $aaa = $_POST['aaa'];
    $total_list="SELECT
	count(*),c.productname
	FROM(
			ctc_order a,
			ctc_user_product b
		)
	LEFT JOIN ctc_product c ON a.productid = c.id
	WHERE
		substr(a.createtime,1,10) = '$aaa'
	AND	a.userid = b.id
	AND a.orderstatus IN (1, 2, 3, 4)
	AND b.devid NOT LIKE '%yj%'
	AND b.iccid <> '8986031641201902324' group by c.productname order by count(*) desc";
    $Oproduct=DB($total_list);
    echo json_encode($Oproduct);
    exit;
}

//总数,总价
$total="SELECT
 sum(ROUND(c.price / 100, 0)),count(ROUND(c.price / 100, 0))
FROM(
		ctc_order a,
		ctc_user_product b
	)
LEFT JOIN ctc_product c ON a.productid = c.id
WHERE
		a.userid = b.id
AND a.orderstatus IN (1, 2, 3, 4)
AND b.devid NOT LIKE '%yj%'
AND b.iccid <> '8986031641201902324'";
$t=DB($total);

//每日充值统计
$price="SELECT
  count(*),substr(a.createtime,1,10),sum(ROUND(c.price / 100, 0))
FROM(
		ctc_order a,
		ctc_user_product b
	)
LEFT JOIN ctc_product c ON a.productid = c.id
WHERE
	a.userid = b.id
AND a.orderstatus IN (1, 2, 3, 4)
AND b.devid NOT LIKE '%yj%'
AND b.iccid <> '8986031641201902324'
GROUP  BY
	substr(a.createtime,1,10) order by substr(a.createtime,1,10) desc";
$p=DB($price);

//总数统计
$total_list=" SELECT
count(*),c.productname
FROM(
		ctc_order a,
		ctc_user_product b
	)
LEFT JOIN ctc_product c ON a.productid = c.id
WHERE
	a.userid = b.id
AND a.orderstatus IN (1, 2, 3, 4)
AND b.devid NOT LIKE '%yj%'
AND b.iccid <> '8986031641201902324'  group by c.productname order by count(*) desc";
$product=DB($total_list);
//var_dump($product);

//当日产品数
$total_list=" SELECT
count(*),c.productname
FROM(
		ctc_order a,
		ctc_user_product b
	)
LEFT JOIN ctc_product c ON a.productid = c.id
WHERE
	a.userid = b.id
AND substr(a.createtime,1,10) = substr(DATE(NOW()),1,10)
AND a.orderstatus IN (1, 2, 3, 4)
AND b.devid NOT LIKE '%yj%'
AND b.iccid <> '8986031641201902324' group by c.productname order by count(*) desc";
$tproduct=DB($total_list);

//趋势图
$total_list="SELECT
substr(a.createtime,1,10),count(*)
FROM(
        ctc_order a,
        ctc_user_product b
    )
LEFT JOIN ctc_product c ON a.productid = c.id
WHERE
    a.userid = b.id
AND a.orderstatus IN (1, 2, 3, 4)
AND b.devid NOT LIKE '%yj%'
AND b.iccid <> '8986031641201902324' GROUP BY substr(createtime,1,10)";

$Tproduct=DB($total_list);
$tpro = array_column($Tproduct,'count(*)');
$arr = array_column($Tproduct,'substr(a.createtime,1,10)');
require_once "../html/chejichongzhitongji.html";