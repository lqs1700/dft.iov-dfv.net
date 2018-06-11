<?php
include_once "../func.php";
include 'db.php';
$operation = $_GET['type'];
$time = isset($_GET['time'])?$_GET['time']:date('Y-m-d',time());
$yue = isset($_GET['time'])?$_GET['time']:date('Y-m',time());
header('Content-type:text/html;charset=utf-8');
if($operation =='report'){
    $sq="SELECT a.userid,b.dialnumber,a.createtime,b.devid,d.username,e.cid,d.userphone,d.dealerphone,b.iccid,
    CASE WHEN b.userstatus = 0 THEN '正常' WHEN b.userstatus = 1 THEN '断网' END, ROUND(c.price / 100, 0), c.productname,
    CASE WHEN b.orderstatus = 1 THEN '支付成功，等待JOB通知运营商' WHEN b.orderstatus = 2 THEN '支付失败' WHEN b.orderstatus = 3 THEN '处理成功'
    WHEN b.orderstatus = 4 THEN '处理失败' END
    FROM(
            ctc_order a,
            ctc_user_product b
        )
    LEFT JOIN ctc_product c ON a.productid = c.id
    LEFT JOIN dev_user d ON b.devid = d.devid
    LEFT JOIN dev_store e ON b.devid = e.devicenumber
    WHERE
        a.userid = b.id
    AND substr(a.createtime,1,10)='$time'
    AND b.orderstatus IN (1, 2, 3, 4)
    AND b.iccid <> '8986031641201902324'";
    $stmt =mysqli_query($con,$sq);
    $head = ['ID','用户接入号','支付时间','车机编号','用户姓名','CID','用户手机','代理商号码','ICCID','充值状态','支付金额','充值产品','处理状态'];
    $filename ='congzhi'.$time.'.csv';
    xiazai($stmt,$head,$filename);
}

if($operation =='reportall'){
$sq="SELECT a.userid,b.dialnumber,a.createtime,b.devid,d.username,e.cid,d.userphone,d.dealerphone,b.iccid,
    CASE WHEN b.userstatus = 0 THEN '正常' WHEN b.userstatus = 1 THEN '断网' END, ROUND(c.price / 100, 0), c.productname,
    CASE WHEN b.orderstatus = 1 THEN '支付成功，等待JOB通知运营商' WHEN b.orderstatus = 2 THEN '支付失败' WHEN b.orderstatus = 3 THEN '处理成功'
    WHEN b.orderstatus = 4 THEN '处理失败' END
    FROM(
            ctc_order a,
            ctc_user_product b
        )
    LEFT JOIN ctc_product c ON a.productid = c.id
    LEFT JOIN dev_user d ON b.devid = d.devid
    LEFT JOIN dev_store e ON b.devid = e.devicenumber
    WHERE
        a.userid = b.id
    AND b.orderstatus IN (1, 2, 3, 4)
    AND b.iccid <> '8986031641201902324'";
$stmt =mysqli_query($con,$sq);
$head = ['ID','用户接入号','支付时间','车机编号','用户姓名','CID','用户手机','代理商号码','ICCID','充值状态','支付金额','充值产品','处理状态'];
$filename ='congzhi'.date('Ymd',time()).'.csv';
xiazai($stmt,$head,$filename);
}

if($operation == 'import'){
   $sq = "SELECT
    DISTINCT ccc.devid ,ccc.autonumber,ccc.autoframeno,ccc.username,ccc.dealerphone,ccc.regdate,ccc.iccid,ccc.dialnumber,ccc.NAME
FROM(
    SELECT
        aaa.*, bbb. NAME
    FROM(
            SELECT
                a.devid AS devid,
                a.autonumber AS autonumber,
                a.username AS username,
                a.autoframeno AS autoframeno,
                a.dealerphone AS dealerphone,
                a.regdate AS regdate,
                b.iccid AS iccid,
                b.dialnumber AS dialnumber
            FROM
                dfqc.dev_user a,
                dfqc.dev_store b
            WHERE
                a.devid = b.devicenumber
            AND a.username NOT IN ('张三', '联创测试')
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
ORDER BY
ccc.regdate desc";
   $stmt =mysqli_query($con,$sq);
   $head = ['车机编号', '车牌号','autoframeno', '用户名','代理商号码','激活时间', 'ICCID', '运营商卡号', '所属省份'];
   $filename = 'jihuo'.date('Ymd',time()).'.csv';
   xiazai($stmt, $head, $filename);
}

if($operation == 'import_yue'){
    $sq = "SELECT
    DISTINCT ccc.devid ,ccc.autonumber,ccc.autoframeno,ccc.username,ccc.dealerphone,ccc.regdate,ccc.iccid,ccc.dialnumber,ccc.NAME
FROM
(
    SELECT
        aaa.*, bbb. NAME
    FROM
        (
            SELECT
                a.devid AS devid,
                a.autonumber AS autonumber,
                a.username AS username,
                a.autoframeno AS autoframeno,
                a.dealerphone AS dealerphone,
                a.regdate AS regdate,
                b.iccid AS iccid,
                b.dialnumber AS dialnumber
            FROM
                dfqc.dev_user a,
                dfqc.dev_store b
            WHERE
                a.devid = b.devicenumber
            AND substr(a.regdate,1,7)='$yue'
            AND a.username NOT IN ('张三', '联创测试')
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
) ccc
ORDER BY
ccc.regdate desc";
    $stmt =mysqli_query($con,$sq);
    $head = ['车机编号', '车牌号','autoframeno', '用户名','代理商号码','激活时间', 'ICCID', '运营商卡号', '所属省份'];
    $filename = 'jihuo'.$yue.'.csv';
    xiazai($stmt, $head, $filename);
}

if($operation == 'unbunding'){
    $sq = "select devid, cernumber, autonumber, username, autotype, autoname, autoframeno, userphone, dealerphone, unblingdate from dev_unbundling order by unblingdate desc";
    $stmt =mysqli_query($con,$sq);
    $head = ['车机编号', 'cernumber', '车牌号', '用户姓名', '车型', '车型2', 'autoframeno', '用户手机', '代理手机', '解绑时间'];
    $filename = 'jiebang'.date('Ymd',time()).'.csv';
    xiazai($stmt, $head, $filename);
}

if($operation == 'unbunding_yue'){
    $sq = "select devid, cernumber, autonumber, username, autotype, autoname, autoframeno, userphone, dealerphone, unblingdate from dev_unbundling where substr(unblingdate,1,7)='$yue' order by unblingdate desc";
    $stmt =mysqli_query($con,$sq);
    $head = ['车机编号', 'cernumber', '车牌号', '用户姓名', '车型', '车型2', 'autoframeno', '用户手机', '代理手机', '解绑时间'];
    $filename = 'jiebang'.$yue.'.csv';
    xiazai($stmt, $head, $filename);
}

if($operation == 'receip'){
    $sq ="SELECT id,devid,
CASE WHEN receipt_status = 2 THEN '流量包快到期' WHEN receipt_status=1 THEN '流量剩余不足'  END AS 'receipt_status' ,
CASE WHEN productid = 0 THEN '-' WHEN productid = 8 THEN '99元包月' WHEN productid=9 THEN '5元1G' WHEN productid=10 THEN '9.9元3G' WHEN productid=11 THEN '赠送10G'  END AS 'productid' ,
CASE WHEN productidString = 1 THEN '一天到期' WHEN productidString=2 THEN '两天到期' WHEN productidString=3 THEN '三天到期' WHEN productidString = 4 THEN '流量不足20%' WHEN productidString = 5 THEN '流量不足10%'  END AS 'productidString' ,
receipttime
FROM app_dataman_receipt
WHERE SUBSTR(receipttime,1,10)='$time'";
    $stmt =mysqli_query($con,$sq);
    $head = ['ID', '车机编号', '弹框类型', '产品', '推送信息', '推送时间'];
    $filename = 'tuisong'.date('Ymd',time()).'.csv';
    xiazai($stmt, $head, $filename);
}

if($operation == 'receip_yue'){
$sq ="SELECT
     DISTINCT  b.dialnumber,
	 b.devid,
	 a.createtime,
	 b.iccid,
	 a.userid,
	 d.username,
	 e.cid,
	 d.userphone,
	 d.dealerphone,
	CASE
WHEN b.userstatus = 0 THEN
	'正常'
WHEN b.userstatus = 1 THEN
	'断网'
END as userstatus,
 ROUND(c.price / 100, 0) as price,
 c.productname,
 CASE
WHEN b.orderstatus = 1 THEN
	'支付成功，等待JOB通知运营商'
WHEN b.orderstatus = 2 THEN
	'支付失败'
WHEN b.orderstatus = 3 THEN
	'处理成功'
WHEN b.orderstatus = 4 THEN
	'处理失败'
END as orderstatus
FROM(
		ctc_order a,
		ctc_user_product b
	)
LEFT JOIN ctc_product c ON a.productid = c.id
LEFT JOIN dev_user d ON b.devid = d.devid
LEFT JOIN dev_store e ON b.devid = e.devicenumber
WHERE
	a.userid = b.id
AND SUBSTR(a.createtime,1,7)='$yue'
AND a.orderstatus IN (1,2,3,4)
AND b.iccid <> '8986031641201902324' ORDER BY
a.createtime desc";
    $stmt =mysqli_query($con,$sq);
    $head = ['dianumber', 'devid', 'createtime','iccid','userid','username','cid','userphone','dealerphone','userstatus','price','productname','orderstatus'];
    $filename = 'congzhi'.$yue.'.csv';
    xiazai($stmt, $head, $filename);
}

if($operation == 'message'){
    $sq ="SELECT bss_sms_history.username,bss_sms_history.userphone,bss_sms_history.devid,bss_sms_history.sendtime,bss_sms_model.content  FROM `bss_sms_history` LEFT JOIN `bss_sms_model` ON bss_sms_history.modelnumber = bss_sms_model.modelnumber WHERE substr(bss_sms_history.sendtime,1,10) = '$time' ORDER BY bss_sms_history.sendtime DESC";
    $stmt =mysqli_query($con,$sq);
    $head = ['姓名', '手机号', '车机号', '发送时间', '发送内容'];
    $filename = 'shouji'.date('Ymd',time()).'.csv';
    xiazai($stmt, $head, $filename);
}