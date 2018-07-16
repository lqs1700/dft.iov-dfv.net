<?php
include_once "../func.php";
include"db.php";
//ajax取当月分类数据 ok
if(isset($_POST['sb'])){
    $bbb = $_POST['sb'];
    $total_list="SELECT
        c.productname,
		count(*),
		SUM(ROUND(c.price / 100, 0)) as price
        FROM(
                ctc_order a,
                ctc_user_product b
            )
        LEFT JOIN ctc_product c ON a.productid = c.id
        WHERE
            a.userid = b.id
        AND SUBSTR(a.createtime,1,7)='$bbb'
        AND a.orderstatus IN (1,2,3,4)
        AND b.devid LIKE '%yj%'
        AND b.iccid <> '8986031641201902324'
        GROUP BY c.productname";
    $dproduct=DB($total_list);
    echo json_encode($dproduct);
    exit;
}

//u总数 ok
$total="SELECT
 sum(ROUND(c.price / 100, 0)) as price,count(ROUND(c.price / 100, 0)) as count
FROM(
		ctc_order a,
		ctc_user_product b
	)
LEFT JOIN ctc_product c ON a.productid = c.id
WHERE
		a.userid = b.id
AND a.orderstatus IN (1, 2, 3, 4)
AND b.devid LIKE '%yj%'
AND b.iccid <> '8986031641201902324'";
$t=DB($total);
// var_dump($t);

//每月统计 ok
$sql = "SELECT
substr(a.createtime,1,7) as time,count(*) as count,SUM(ROUND(c.price / 100, 0)) as price
FROM(
        ctc_order a,
        ctc_user_product b
    )
LEFT JOIN ctc_product c ON a.productid = c.id
WHERE
    a.userid = b.id
AND a.orderstatus IN (1, 2, 3, 4)
AND b.devid LIKE '%yj%'
AND b.iccid <> '8986031641201902324' GROUP BY substr(createtime,1,7) order by substr(createtime,1,7) desc";
$p=DB($sql);

//拆线图 ok
$total_list=" SELECT
substr(a.createtime,1,7) as time,count(*)
FROM(
        ctc_order a,
        ctc_user_product b
    )
LEFT JOIN ctc_product c ON a.productid = c.id
WHERE
    a.userid = b.id
AND a.orderstatus IN (1, 2, 3, 4)
AND b.devid LIKE '%yj%'
AND b.iccid <> '8986031641201902324' GROUP BY substr(createtime,1,7)";
$Tproduct=DB($total_list);
$tpro = array_column($Tproduct,'count(*)');
$arr = array_column($Tproduct,'time');
require_once "../html/yunjingchongzhiyue.html";