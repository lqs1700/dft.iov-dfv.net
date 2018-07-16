<?php
session_start();
if(!(isset($_SESSION['isLogined']) && $_SESSION['isLogined'] == '1')){header('Location: login.html');}
?>
<html>
<head>
    <meta charset="utf-8">
    <title>东方启辰</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="css/adminStyle.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/jquery1.js"></script>
    <script type="text/javascript">
        $(document).ready(
                function() {
                    $(".div2").click(
                            function() {
                                $(this).next("ul").slideToggle("slow").siblings(
                                        ".div3:visible").slideUp("slow");
                                $(this).next("ul").find("li").removeClass("current_li");
                            });
                    $(".a").click(
                            function(){
                                $(this).parent().addClass("current_li").siblings().removeClass("current_li");
                            });
                });

        function openurl(url) {
            var rframe = parent.document.getElementById("rightFrame");
            rframe.src = url;
        }
    </script>
</head>
<body>
<div class="top2">
    <div class="logo">
       <a href="index.php"><img src="img/gw_logo.png" /></a>
    </div>
    <div class="fr top-link">
        <a href="login.html" target="mainCont" title="DeathGhost">退出登陆</a>
    </div>
</div>
<div class="left">
    <div class="div1">
        <div class="div2">
            <img src="img/xiao1.png">
            激活总计
        </div>
        <ul class="div3">
            <li><a class="a" href="php/jihuoliebiao.php" target="rightFrame"
                   onClick="openurl('videoQuery.html');">激活列表</a>
            </li>
            <li><a class="a" href="php/jihuotongji.php" target="rightFrame"
                   onClick="openurl('videoQuery.html');">激活统计</a>
            </li>
            <li><a class="a" href="php/jihuoyue.php" target="rightFrame"
                   onClick="openurl('videoQuery.html');">激活月计</a>
            </li>
            <li><a class="a" href="php/import.php?type=import" target="rightFrame"
                   onClick="openurl('videoQuery.html');">激活下载</a>
            </li>
        </ul>

        <div class="div2">
            <img src="img/xiao1.png">
            车机激活
        </div>
        <ul class="div3">
            <li><a class="a" href="php/chejijihuo.php" target="rightFrame"
                   onClick="openurl('videoQuery.html');">激活列表</a>
            </li>
            <li><a class="a" href="php/chejijihuotongji.php" target="rightFrame"
                   onClick="openurl('videoQuery.html');">激活统计</a>
            </li>
            <li><a class="a" href="php/chejijihuoyue.php" target="rightFrame"
                   onClick="openurl('videoQuery.html');">激活月计</a>
            </li>
        </ul>

        <div class="div2">
            <img src="img/xiao1.png">
            云镜激活
        </div>
        <ul class="div3">
            <li><a class="a" href="php/yunjingjihuo.php" target="rightFrame"
                   onClick="openurl('videoQuery.html');">激活列表</a>
            </li>
            <li><a class="a" href="php/yunjingjihuotongji.php" target="rightFrame"
                   onClick="openurl('videoQuery.html');">激活统计</a>
            </li>
            <li><a class="a" href="php/yunjingjihuoyue.php" target="rightFrame"
                   onClick="openurl('videoQuery.html');">激活月计</a>
            </li>
        </ul>

        <div class="div2">
            <img src="img/xiao2.png">
            充值总计
        </div>
        <ul class="div3">
            <li><a class="a" href="php/congzhiliebiao.php" target="rightFrame"
                   onClick="openurl('videoQuery.html');">充值列表</a>
            </li>
            <li><a class="a" href="php/congzhitongji.php" target="rightFrame"
                   onClick="openurl('videoQuery.html');">充值统计</a>
            </li>
            <li><a class="a" href="php/congzhiyue.php" target="rightFrame"
                   onClick="openurl('videoQuery.html');">充值月计</a>
            </li>
            <li><a class="a" href="php/import.php?type=reportall" target="rightFrame"
                   onClick="openurl('videoQuery.html');">充值下载</a>
            </li>
        </ul>

        <div class="div2">
            <img src="img/xiao2.png">
            车机充值
        </div>
        <ul class="div3">
            <li><a class="a" href="php/chejichongzhi.php" target="rightFrame"
                   onClick="openurl('videoQuery.html');">充值列表</a>
            </li>
            <li><a class="a" href="php/chejichongzhitongji.php" target="rightFrame"
                   onClick="openurl('videoQuery.html');">充值统计</a>
            </li>
            <li><a class="a" href="php/chejichongzhiyue.php" target="rightFrame"
                   onClick="openurl('videoQuery.html');">充值月计</a>
            </li>
        </ul>

        <div class="div2">
            <img src="img/xiao2.png">
            云镜充值
        </div>
        <ul class="div3">
            <li><a class="a" href="php/yunjingchongzhi.php" target="rightFrame"
                   onClick="openurl('videoQuery.html');">充值列表</a>
            </li>
            <li><a class="a" href="php/yunjingchongzhitongji.php" target="rightFrame"
                   onClick="openurl('videoQuery.html');">充值统计</a>
            </li>
            <li><a class="a" href="php/yunjingchongzhiyue.php" target="rightFrame"
                   onClick="openurl('videoQuery.html');">充值月计</a>
            </li>
        </ul>
        <div class="div2">
            <img src="img/xiao6.png">
            解绑展示
        </div>
        <ul class="div3">
            <li><a class="a" href="php/jiebangliebiao.php" target="rightFrame"
                   onClick="openurl('videoQuery.html');">解绑列表</a>
            </li>
            <li><a class="a" href="php/jiebangtongji.php" target="rightFrame"
                   onClick="openurl('videoQuery.html');">解绑统计</a>
            </li>
            <li><a class="a" href="php/jiebangyue.php" target="rightFrame"
                   onClick="openurl('videoQuery.html');">解绑月计</a>
            </li>
            <li><a class="a" href="php/import.php?type=unbunding" target="rightFrame"
                   onClick="openurl('videoQuery.html');">解绑下载</a>
            </li>
        </ul>
        <div class="div2">
            <img src="img/xiao5.png">
            流量提醒
        </div>
        <ul class="div3">
            <li><a class="a" href="php/tuisongliebiao.php" target="rightFrame"
                   onClick="openurl('videoQuery.html');">推送列表</a>
            </li>
            <li><a class="a" href="php/tuisongtongji.php" target="rightFrame"
                   onClick="openurl('videoQuery.html');">推送统计</a>
            </li>
        </ul>
        <div class="div2">
            <img src="img/xiao5.png">
            版本统计
        </div>
        <ul class="div3">
            <li><a class="a" href="php/version.php" target="rightFrame"
                   onClick="openurl('videoQuery.html');">版本统计</a>
            </li>
            <li><a class="a" href="php/opentimes.php" target="rightFrame"
                   onClick="openurl('videoQuery.html');">开机统计</a>
            </li>
        </ul>
        <div class="div2">
            <img src="img/xiao5.png">
            抽奖展示
        </div>
        <ul class="div3">
            <li><a class="a" href="php/yaojiang.php" target="rightFrame"
                   onClick="openurl('videoQuery.html');">抽奖统计</a>
            </li>
        </ul>
        <div class="div2">
            <img src="img/xiao4.png">
            手机短信
        </div>
        <ul class="div3">
            <li><a class="a" href="php/shoujiliebiao.php" target="rightFrame"
                   onClick="openurl('videoQuery.html');">信息列表</a>
            </li>
            <li><a class="a" href="php/shoujitongji.php" target="rightFrame"
                   onClick="openurl('videoQuery.html');">信息统计</a>
            </li>
        </ul>
        <div class="div2">
            <img src="img/xiao5.png">
            轨迹查询
        </div>
        <ul class="div3">
            <li><a class="a" href="php/danche.php" target="rightFrame"
                   onClick="openurl('videoQuery.html');">单车轨迹</a>
            </li>
            <li><a class="a" href="php/dancheshuju.php" target="rightFrame"
                   onClick="openurl('videoQuery.html');">单车数据</a>
            </li>
            <li><a class="a" href="php/duoche.php" target="rightFrame"
                   onClick="openurl('videoQuery.html');">多车轨迹</a>
            </li>
        </ul>
        <div class="div2">
            <img src="img/xiao3.png">
            网点地图
        </div>
        <ul class="div3">
            <li><a class="a" href="php/relitu.php" target="rightFrame"
                   onClick="openurl('videoQuery.html');">热力地图</a>
            </li>
            <li><a class="a" href="php/qianyi.php" target="rightFrame"
                   onClick="openurl('videoQuery.html');">网点分布</a>
            </li>
        </ul>
        <div class="div2">
            <img src="img/xiao7.png">
            其他信息
        </div>
        <ul class="div3">
            <li><a class="a" href="php/blackperson.php" target="rightFrame"
                   onClick="openurl('videoQuery.html');">黑色用户</a>
            </li>
        </ul>
    </div>
</div>
<div class="right" style="width: 88%;">
    <iframe id="rightFrame" src="right_content.html" name="rightFrame" width="100%" height="100%"
            scrolling="auto" marginheight="0" marginwidth="0" align="center"
            style="background-color: white;border: 5px solid #d2d0d0; margin: 0 auto; padding: 0;">
    </iframe>
</div>
</body>
</html>