<?php
include_once "../func.php";
include'db.php';
$page_size=100;

$collect="select count(*) from black_person";
$result = DB($collect);
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
$sql="select * from black_person limit $offet,$page_size ";
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
require_once "../html/blackperson.html";