<?php
/**
 * Created by PhpStorm.
 * User: liu
 * Date: 2018/6/6
 * Time: 16:18
 */
$type = 3;
require_once "db.php";
$sql = "select date_time,open_times from bss_app_version order by date_time";
$res = DB($sql);
$count = array_column($res,'open_times');
$array = array_column($res,'date_time');
require_once "../html/opentimes.html";
