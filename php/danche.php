<?php
$type = 3;
include_once "../func.php";
include_once 'db.php';
$GLOBALS['arrt']=array();
if($_POST)
{
	$iccid = $_POST['user'];
	$Dabegin = $_POST['Dabegin'];
	$Daend = $_POST['Daend'];

	$arr_latitude = array();
	$arr_longitude = array();

	$sql = "select latitude, longitude from bss_app_geographic_codes where iccid ='$iccid' and substr(creat_time,1,10)>='$Dabegin' and substr(creat_time,1,10)<='$Daend' order by creat_time"; 
	$res = DB($sql);
	if($res)
	{
		foreach($res as $val)
		{		
			if($val['latitude']!="")
			{	
				$arr_latitude[]= $val['latitude'];
				$arr_longitude[]= $val['longitude'];
			}	
		}
	}else{
	$arr_longitude = [ 0=> 114.0303417435];
	$arr_latitude = [0=> 22.6223915052];
	}
}else{
	$arr_longitude = [ 0=> 114.0303417435];
	$arr_latitude = [0=> 22.6223915052];
	}
require_once "../html/danche.html";