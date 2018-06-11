<?php
/**
 * Created by PhpStorm.
 * User: wx
 * Date: 2018/6/6
 * Time: 16:18
 */
$type = 3;
require_once "db.php";
$sql = "select * from bss_app_version order by date_time";
$res = DB($sql);
require_once "../html/version.html";

function getnum($version,$value){
    $aa = isset(json_decode($value['data_json'],true)[$version])?json_decode($value['data_json'],true)[$version]:false;
    if(!$aa){
        return 0;
    }else{
        return $aa;
    }
}