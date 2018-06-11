<?php
    session_start();
	include 'php/db.php';
	$username =isset($_POST['username']) ? addslashes($_POST['username']) : '';
	$password =isset($_POST['password']) ? md5(addslashes($_POST['password'])) : '';
	$cer_password = $_POST['password'];

	$isset = DB('SELECT * FROM admin_user WHERE username = "'.$username.'" && password = "'.$password.'"');
	$sql = "SELECT a.cernumber,a.userphone,b.iccid
			FROM(dev_user a,dev_store b)
			WHERE a.devid=b.devicenumber
			AND userphone ='$username'
			AND SUBSTR(cernumber,-7,6) = '$cer_password'";
	$isset2=DB($sql);

	if($isset|$isset2){
		if ($isset) {
			DB('UPDATE admin_user SET pass_time = ' . time() . ' WHERE id = ' . $isset[0]['id']);
			$_SESSION['user'] = $isset[0];
			$_SESSION['isLogined'] = 1;
			echo '登录成功';
			echo '<script>setTimeout("location=\'index.php\'" , 300)</script>';
		} else {
			$_SESSION['user'] = $isset2[0]['userphone'];
			$_SESSION['isLogined'] = 1;
			$_SESSION['iccid'] = $isset2[0]['iccid'];
			echo '登录成功';
			echo '<script>setTimeout("location=\'php/danche2.php\'" , 300)</script>';
		}
	}else{
		echo  "<script> alert('用户名或者密码错误');window.location.href='login.html';</script>";
	}