<?php
include_once "../func.php";
include'db.php';
$page_size=100;
$collect="SELECT count(*) FROM dfqc.dev_user a, dfqc.dev_store b WHERE a.devid = b.devicenumber AND a.username NOT IN ('张三', '联创测试')";
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
$sql="SELECT
		DISTINCT ccc.devid ,ccc.autonumber,ccc.autoframeno,ccc.username,ccc.dealerphone,ccc.regdate,ccc.iccid,ccc.dialnumber,ccc.NAME
FROM
	(
		SELECT
			aaa.*, bbb. NAME
		FROM
			(
				SELECT
					a.id AS id,
					a.devid AS devid,
					a.cernumber AS cernumber,
					a.autonumber AS autonumber,
					a.username AS username,
					a.autoframeno AS autoframeno,
					a.userphone AS userphone,
					a.dealerphone AS dealerphone,
					a.regdate AS regdate,
					b.cid AS cid,
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
	ccc.regdate desc limit $offet,$page_size";
$c=DB($sql);
$page_len = ($page_len%2)?$page_len:$pagelen+1;//页码个数 
$pageoffset = ($page_len-1)/2;//页码个数左右偏移量 

$key='<div class="page">'; 
$key.="<span>$page/$pages</span> "; //第几页,共几页 
if($page!=1){ 
$key.="<a href=\"".$_SERVER['PHP_SELF']."?page=1\">第一页</a> "; //第一页 
$key.="<a href=\"".$_SERVER['PHP_SELF']."?page=".($page-1)."\">上一页</a>"; //上一页 
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
$key.=" <a href=\"".$_SERVER['PHP_SELF']."?page=".$i."\">".$i."</a>"; 
} 
} 
if($page!=$pages){ 
$key.=" <a href=\"".$_SERVER['PHP_SELF']."?page=".($page+1)."\">下一页</a> ";//下一页 
$key.="<a href=\"".$_SERVER['PHP_SELF']."?page={$pages}\">最后一页</a>"; //最后一页 
}else { 
$key.="下一页 ";//下一页 
$key.="最后一页"; //最后一页 
} 
$key.='</div>'; 
require "../html/jihuoliebiao.html";