<?php
/**
 * Created by PhpStorm.
 * User: liu
 * Date: 2018/6/4
 * Time: 14:48
 */
$type = 2;
include_once "../func.php";
include'db.php';
$sql = "select data_count,data_time from werxin_activity_calculate WHERE data_count<>'0' ORDER BY data_time DESC";
$res=DB($sql);

$array = array_reverse(array_column($res,'data_time'));
$count = array_reverse(array_column($res,'data_count'));

require_once "../html/yaojiang.html";