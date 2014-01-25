<?
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! index page - login function ! ..                                           *
*********************************************************************************  */

	// login script
	if ($_POST['set'] == "1")
	{
		$error = 1;
		$login = 1;
		$user_check = $_POST['user'];
		$pass_check = $_POST['pass'];
		$pass_check_md5 = md5($pass_check);
		include "check_user.php";
	}

	// logout script
	if ($HTTP_GET_VARS['logout'] == "1")
	{
		$error = 2;
		setcookie("user", '', -1);
		setcookie("pass", '', -1);
	}

	$index_page = 1;
	include "check_user.php";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Login page</title>
		<!--                       CSS                       -->
		<link rel="stylesheet" href="resources/css/reset.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="resources/css/style.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="resources/css/invalid.css" type="text/css" media="screen" />	
		<link rel="stylesheet" href="resources/css/blue.css" type="text/css" media="screen" />

		<!-- Colour Schemes
		<link rel="stylesheet" href="resources/css/blue.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="resources/css/red.css" type="text/css" media="screen" /> 
		-->
		
		<!-- Internet Explorer Fixes Stylesheet -->
		<!--[if lte IE 7]><link rel="stylesheet" href="resources/css/ie.css" type="text/css" media="screen" /><![endif]-->
	
		<!--                       Javascripts                       -->
		<script type="text/javascript" src="resources/scripts/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src="resources/scripts/simpla.jquery.configuration.js"></script>
		<script type="text/javascript" src="resources/scripts/facebox.js"></script>
		<script type="text/javascript" src="resources/scripts/jquery.wysiwyg.js"></script>
		
		<!-- Internet Explorer .png-fix -->
		<!--[if IE 6]>
			<script type="text/javascript" src="resources/scripts/DD_belatedPNG_0.0.7a.js"></script>
			<script type="text/javascript">
				DD_belatedPNG.fix('.png_bg, img, li');
			</script>
		<![endif]-->
	</head>
  
	<body id="login">
		<div id="login-wrapper" class="png_bg">
			<div id="login-top"><img id="logo" src="resources/images/logo.png" alt="Simpla Admin logo" /></div> <!-- End #logn-top -->
			<div id="login-content">
				<form action="index.php" method="POST">
				 <input type="hidden" name="set" value="1">
					<div class="notification information png_bg"><div>הזן יוזר וסיסמא על מנת להיכנס למערכת.</div></div>
					<p><label>שם משתמש</label><input class="text-input" type="text" name="user"/></p>
					<div class="clear"></div>
					<p><label>סיסמא</label><input class="text-input" type="password" name="pass"/></p>
					<div class="clear"></div>
					<p><input class="button" type="submit" value="הכנס אותי למערכת!" /></p>
				</form>
				<? if ($error == 1) echo 'הפרטים שהזנת אינם נכונים.'; ?>
				<? if ($error == 2) echo 'התנתקת בהצלחה!'; ?>
			</div> <!-- End #login-content -->
		</div> <!-- End #login-wrapper -->
  </body>
</html>