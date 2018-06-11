<?php
$type = 3;
include_once "../func.php";
include_once 'db.php';
$iccid = $_SESSION['iccid'];
if($_POST){
    $Dabegin = $_POST['Dabegin'];
    $Daend = $_POST['Daend'];
    $sql = "select creat_time,event_desc,latitude,longitude from bss_app_geographic_codes where iccid ='$iccid' and substr(creat_time,1,10)>='$Dabegin' and substr(creat_time,1,10)<='$Daend' order by creat_time desc";
    $res = DB($sql);
}
require_once "../html/dancheshuju2.html";