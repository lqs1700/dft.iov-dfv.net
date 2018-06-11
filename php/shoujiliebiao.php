<?php
include_once "../func.php";
include"db.php";
$devid = isset($_REQUEST['devid'])?$_REQUEST['devid']:false;
$start_time = isset($_REQUEST['start_time'])?$_REQUEST['start_time']:false;
$end_time = isset($_REQUEST['end_time'])?$_REQUEST['end_time']:false;

$start = "SELECT a.devid FROM `bss_sms_history` a LEFT JOIN `bss_sms_model` b ON a.modelnumber = b.modelnumber";
$end = " ORDER BY a.sendtime DESC";
if($devid){
	$start.=" WHERE a.devid = '$devid'";
	if($start_time){
		$start.=" AND substr(a.sendtime,1,10)>= '$start_time'";
	}
	if($end_time){
		$start.=" AND substr(a.sendtime,1,10)<= '$end_time'";
	}
}
if(!$devid){
	if($start_time){
		$start.=" WHERE substr(a.sendtime,1,10)>= '$start_time'";
		if($end_time){
			$start.=" AND substr(a.sendtime,1,10)<= '$end_time'";
		}
	}elseif($end_time){
		$start.=" WHERE substr(a.sendtime,1,10)<= '$end_time'";
	}
}
$sql = $start.$end;
$res = mysqli_query($con,$sql);
$mes=array();
while($row=mysqli_fetch_assoc($res)){
	$mes[]=$row;
}
$page_size=100;
$count = mysqli_num_rows($res);
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

$start = "SELECT a.username,a.userphone,a.devid,a.sendtime,b.content  FROM `bss_sms_history` a LEFT JOIN `bss_sms_model` b ON a.modelnumber = b.modelnumber";
$end = " ORDER BY a.sendtime DESC limit $offet,$page_size";
if($devid){
		$start.=" WHERE a.devid = '$devid'";
	if($start_time){
		$start.=" AND substr(a.sendtime,1,10)>= '$start_time'";
	}
	if($end_time){
		$start.=" AND substr(a.sendtime,1,10)<= '$end_time'";
	}
}
if(!$devid){
	if($start_time){
		$start.=" WHERE substr(a.sendtime,1,10)>= '$start_time'";
		if($end_time){
			$start.=" AND substr(a.sendtime,1,10)<= '$end_time'";
		}
	}elseif($end_time){
		$start.=" WHERE substr(a.sendtime,1,10)<= '$end_time'";
	}
}
$sql = $start.$end;
$t=DB($sql);

$page_len = ($page_len%2)?$page_len:$pagelen+1;//页码个数 
$pageoffset = ($page_len-1)/2;//页码个数左右偏移量 

$key='<div class="page">'; 
$key.="<span>$page/$pages</span> "; //第几页,共几页 
if($page!=1){ 
$key.="<a href=\"".$_SERVER['PHP_SELF']."?devid=$devid&&start_time=$start_time&&end_time=$end_time&&page=1\">第一页</a> "; //第一页 
$key.="<a href=\"".$_SERVER['PHP_SELF']."?devid=$devid&&start_time=$start_time&&end_time=$end_time&&page=".($page-1)."\">上一页</a>"; //上一页 
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
$key.=" <a href=\"".$_SERVER['PHP_SELF']."?devid=$devid&&start_time=$start_time&&end_time=$end_time&&page=".$i."\">".$i."</a>"; 
} 
} 
if($page!=$pages){ 
$key.=" <a href=\"".$_SERVER['PHP_SELF']."?devid=$devid&&start_time=$start_time&&end_time=$end_time&&page=".($page+1)."\">下一页</a> ";//下一页 
$key.="<a href=\"".$_SERVER['PHP_SELF']."?devid=$devid&&start_time=$start_time&&end_time=$end_time&&page={$pages}\">最后一页</a>"; //最后一页 
}else { 
$key.="下一页 ";//下一页 
$key.="最后一页"; //最后一页 
} 
$key.='</div>'; 
require "../html/shoujiliebiao.html";