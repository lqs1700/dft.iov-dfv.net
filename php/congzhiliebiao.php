<?php
include_once "../func.php";
include 'db.php';
$page_size=100;
$time = isset($_REQUEST['time'])?$_REQUEST['time']:false;
$start1="SELECT
	 count(*)
FROM(
		ctc_order a,
		ctc_user_product b
	)
WHERE
	a.userid = b.id
AND a.orderstatus IN(1,2,3,4)
AND b.iccid <> '8986031641201902324'";

$end1 = "AND substr(a.createtime,1,10)='$time'";
if($time){
 $collect=$start1.$end1;
}else{
 $collect=$start1;
}
 $result=DB($collect);
 $count = $result[0]['count(*)'];
 $page_count=ceil($count/$page_size);

 $init=1;
 $page_len = 7;
 $max_p=$page_count;
 $pages=$page_count;
 //判断当前页码
 if(empty($_GET['page'])||$_GET['page']<0){
 	$page=1;
 }else{
 	$page=$_GET['page'];
 }
$offet=$page_size*($page-1);

$start2="SELECT a.createtime,b.devid,b.iccid,b.dialnumber,
CASE
WHEN b.userstatus = 0 THEN
	'正常'
WHEN b.userstatus = 1 THEN
	'断网'
END as userstatus,
CASE
WHEN b.orderstatus = 1 THEN
	'支付成功，等待JOB通知运营商'
WHEN b.orderstatus = 2 THEN
	'支付失败'
WHEN b.orderstatus = 3 THEN
	'处理成功'
WHEN b.orderstatus = 4 THEN
	'处理失败'
END as orderstatus,
ROUND(c.price * 0.01, 0) as price,c.productname,d.username,d.userphone,d.dealerphone,e.cid
from ctc_order a
LEFT JOIN ctc_user_product b on a.userid = b.id
LEFT JOIN ctc_product c on a.productid = c.id
LEFT JOIN dev_user d ON b.devid = d.devid
LEFT JOIN dev_store e ON b.devid = e.devicenumber
WHERE a.orderstatus IN (1,2,3,4)
AND b.iccid <> '8986031641201902324'";

$end2="ORDER BY a.createtime desc limit $offet,$page_size";
if($time){
  $sql = $start2.$end1.$end2;
}else{
  $sql = $start2.$end2;
}
$t=DB($sql);
//var_dump($t);

$page_len = ($page_len%2)?$page_len:$pagelen+1;//页码个数 
$pageoffset = ($page_len-1)/2;//页码个数左右偏移量 

$key='<div class="page">'; 
$key.="<span>$page/$pages</span> "; //第几页,共几页 
if($page!=1){ 
$key.="<a href=\"".$_SERVER['PHP_SELF']."?time=$time&&page=1\">第一页</a> "; //第一页
$key.="<a href=\"".$_SERVER['PHP_SELF']."?time=$time&&page=".($page-1)."\">上一页</a>"; //上一页
}else { 
$key.="第一页 ";//第一页 
$key.="上一页"; //上一页 
}
if($pages>$page_len){ 
//如果当前页小于等于左偏移 
if($page<=$pageoffset){ 
$init=1; 
$max_p = $page_len; 
}else{//如果当前页大于左偏移 
//如果当前页码右偏移超出最大分页数 
if($page+$pageoffset>=$pages+1){ 
$init = $pages-$page_len+1; 
}else{ 
//左右偏移都存在时的计算 
$init = $page-$pageoffset; 
$max_p = $page+$pageoffset; 
} 
} 
} 
for($i=$init;$i<=$max_p;$i++){ 
if($i==$page){ 
$key.=' <span>'.$i.'</span>'; 
} else { 
$key.=" <a href=\"".$_SERVER['PHP_SELF']."?time=$time&&page=".$i."\">".$i."</a>";
} 
} 
if($page!=$pages){ 
$key.=" <a href=\"".$_SERVER['PHP_SELF']."?time=$time&&page=".($page+1)."\">下一页</a> ";//下一页
$key.="<a href=\"".$_SERVER['PHP_SELF']."?time=$time&&page={$pages}\">最后一页</a>"; //最后一页
}else { 
$key.="下一页 ";//下一页 
$key.="最后一页"; //最后一页 
} 
$key.='</div>';
require_once "../html/congzhiliebiao.html";