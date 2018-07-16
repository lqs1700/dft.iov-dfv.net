<?php
include_once "../func.php";
include "db.php";
//激活详情
$partner_id = isset($_REQUEST['partner_id'])?$_REQUEST['partner_id']:false;
if($partner_id){
    $sql="SELECT
ccc.dealername,
COUNT(*)
FROM
(
SELECT
a.devid AS devid,
c.dealername
FROM
dfqc.dev_user a
LEFT JOIN dfqc.dev_store b ON a.devid = b.devicenumber
RIGHT JOIN dfqc.bss_dealer c ON c.dealerphone = a.dealerphone
WHERE a.username NOT IN ('张三', '联创测试')
AND b.storestatus='1'
AND b.devicenumber NOT LIKE '%yj%'
AND c.partner_id = '$partner_id'
)ccc
GROUP BY ccc.dealername ORDER  by count(*) desc";

    $dproduct=DB($sql);
    echo json_encode($dproduct);
    exit;
}
//全部激活数据
$date = "SELECT
   DISTINCT ccc.devid ,
   ccc.partner_id,
   ccc.NAME,
   COUNT(*)
FROM
(
    SELECT
	aaa.*, bbb. NAME,bbb.partner_id
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
    AND b.devicenumber NOT LIKE '%yj%'
    AND b.storestatus='1'
	) aaa
	LEFT JOIN (
    SELECT
	a.dealerphone AS dealerphone1,
	a.partner_id,
	b. NAME AS NAME
	FROM
	dfqc.bss_dealer a,
	dfqc.reg_provincial b
	WHERE
	a.partner_id = b.id
	) bbb ON aaa.dealerphone = bbb.dealerphone1
	) ccc
	GROUP BY ccc.NAME ORDER  by count(*) desc";
$group=DB($date);
//  var_dump($group);

//当天激活数据
$t="SELECT
	DISTINCT ccc.devid ,
	ccc.partner_id,
	ccc.NAME,COUNT(*)
	FROM
	(
	SELECT
	aaa.*, bbb. NAME,
	bbb.partner_id
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
	AND  substr(a.regdate,1,10)=substr(DATE(NOW()),1,10)
	) aaa
	LEFT JOIN (
	SELECT
	a.dealerphone AS dealerphone1,
	a.partner_id,
	b. NAME AS NAME
	FROM
	dfqc.bss_dealer a,
	dfqc.reg_provincial b
	WHERE
	a.partner_id = b.id
	) bbb ON aaa.dealerphone = bbb.dealerphone1
	) ccc
	GROUP BY ccc.NAME order by count(*) desc";
$r=DB($t);
//var_dump($r);

//今日激活总和
$name="SELECT
   DISTINCT ccc.devid ,
	COUNT(ccc.NAME)
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
				AND  substr(a.regdate,1,10)=substr(DATE(NOW()),1,10)
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
	) ccc ";
$value=DB($name);
//var_dump($value);

//全部激活总和
$d="SELECT
  DISTINCT ccc.devid ,
	COUNT(ccc.devid)
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
				AND b.devicenumber NOT LIKE '%yj%'
				AND b.storestatus='1'
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
$g=DB($d);
require_once "../html/chejijihuotongji.html";