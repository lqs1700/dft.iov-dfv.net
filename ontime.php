<?php
header('Content-type:text/html;charset=utf-8');
$con = mysqli_connect('180.101.255.3:3306','test','123456','dfqc');//测试
//$con = mysqli_connect('180.101.254.177:33066','lqs','lqs@123456','dfqc');//正试
if(mysqli_connect_errno($con))
    die('错误信息:'.mysqli_connect_error($con));
mysqli_query($con , 'set names utf8');
date_default_timezone_set('PRC');
$sql = "SELECT count(*) FROM bss_app_geographic_codes WHERE event_desc='开机' and SUBSTR(creat_time,1,10)= date_sub(curdate(),interval 1 day)";
$res= mysqli_query($con,$sql);
$open_times='';
while($row=mysqli_fetch_assoc($res)){
    $open_times=$row['count(*)'];
}
if($open_times){
    $sql1 = "insert into bss_app_geoliu (iccid,version,creat_time) select DISTINCT iccid,version,SUBSTR(creat_time,1,10) from bss_app_geographic_codes WHERE SUBSTR(creat_time,1,10)=date_sub(curdate(),interval 1 day)";
    $res1 = mysqli_query($con,$sql1);
}
if($res1){
    $sql = "select version,count(*),creat_time FROM `bss_app_geoliu` GROUP BY version ORDER BY version";
    $res = mysqli_query($con,$sql);
    $data = [];
    foreach($res as $val){
        $data[$val['version']]=$val['count(*)'];
        $time = $val['creat_time'];
    }
    $data = json_encode($data);
    $sql2 = "insert into bss_app_version (data_json,date_time,open_times) values('{$data}','{$time}','{$open_times}')";
    $res2 = mysqli_query($con,$sql2);
}
if($res2){
    $sql3="delete from bss_app_geoliu";
    $res3 = mysqli_query($con,$sql3);
}