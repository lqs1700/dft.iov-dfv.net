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
	for($i=0;$i<count($iccid);$i++)
	{
		$cid = isset($iccid[$i])?$iccid[$i]:'';
		$sql = "select latitude, longitude from bss_app_geographic_codes where iccid ='$cid' and substr(creat_time,1,10)>='$Dabegin' and substr(creat_time,1,10)<='$Daend' order by creat_time";
		$res = DB($sql);
		if($res)
		{
			foreach($res as $val)
			{		
				if($val['latitude']!="")
				{	
					$arr_latitude[$i][]= $val['latitude'];
					$arr_longitude[$i][]= $val['longitude'];
				}	
			}
		}else{
			echo "<script>alert('无数据,请确认选择条件');history.go(-1);</script>";
			exit;
		}
	}
}else{
		$arr_longitude[0] = [ 0=> 111.0303417435,1=> 111.2303417435,2=> 114.2003417435];
		$arr_latitude[0] = [0=> 24.6323915052,1=> 22.7223915052,2=> 22.6223915052];

		$arr_longitude[1] = [ 0=> 112.1403417435,1=> 112.5403417435,2=> 114.1903417435];
		$arr_latitude[1] = [0=> 24.6433915052,1=> 22.8333915052,2=> 22.5223915052];

		$arr_longitude[2] = [ 0=> 113.2333417435,1=> 113.2333417435,2=> 114.1803417435];
		$arr_latitude[2] = [0=> 24.6525915052,1=> 22.9425915052,2=> 22.4223915052];

		$arr_longitude[3] = [ 0=> 114.3308417435,1=> 114.2308417435,2=> 114.1703417435];
		$arr_latitude[3] = [0=> 24.6628915052,1=> 22.5528915052,2=> 22.3223915052];

		$arr_longitude[4] = [ 0=> 115.4333417435,1=> 115.2333417435,2=> 114.1603417435];
		$arr_latitude[4] = [0=> 25.6723015052,1=> 22.4623015052,2=> 22.2223915052];

		$arr_longitude[5] = [ 0=> 114.0303417435,1=> 114.2303417435,2=> 117.2003417435];
		$arr_latitude[5] = [0=> 24.6323915052,1=> 22.7223915052,2=> 27.6223915052];

		$arr_longitude[6] = [ 0=> 114.1403417435,1=> 114.5403417435,2=> 116.1903417435];
		$arr_latitude[6] = [0=> 24.6433915052,1=> 22.8333915052,2=> 26.5223915052];

		$arr_longitude[7] = [ 0=> 114.2333417435,1=> 114.2333417435,2=> 115.1803417435];
		$arr_latitude[7] = [0=> 24.6525915052,1=> 22.9425915052,2=> 25.4223915052];

		$arr_longitude[8] = [ 0=> 114.3308417435,1=> 114.2308417435,2=> 114.1703417435];
		$arr_latitude[8] = [0=> 24.6628915052,1=> 22.5528915052,2=> 24.3223915052];

		$arr_longitude[9] = [ 0=> 114.4333417435,1=> 114.2333417435,2=> 113.1603417435];
		$arr_latitude[9] = [0=> 25.6723015052,1=> 22.4623015052,2=> 23.2223915052];
	}

include "../html/duoche.html";