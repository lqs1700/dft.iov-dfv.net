<?php
	header('Content-type:text/html;charset=utf-8');
	session_start();
	if(!(isset($_SESSION['isLogined']) && $_SESSION['isLogined'] == '1'))
	{
		header('Location: ../login.html');
		exit;
	}