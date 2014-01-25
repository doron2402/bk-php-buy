<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! login page ! ..                                                            *
*********************************************************************************  */

	include "sql.php";
	include "check_user.php";

	$error_login = '';
	$error_register = '';


	$back_url = $HTTP_GET_VARS['back'];
	if ($back_url == NULL) $back_url = 'user.php';

	// If logout
	if ($HTTP_GET_VARS['act'] == "logout")
	{
		setcookie("mail", '', -1);
		setcookie("pass", '', -1);
		echo '<script type="text/javascript">window.location = "user.php"</script>';
	}

	// If login redirect to user
	if ($Member_login == 1)
	{
		echo '<script type="text/javascript">window.location = "user.php"</script>';
	}

	// if login
	if ($_POST['login'] == "1")
	{
		$email = strtolower($_POST['email']);
		$pass  = strtolower($_POST['pass']);
			$pass_md5 = md5($pass);

			opensql();

				$result = mysql_query("SELECT * FROM `Coupons_Clients` WHERE (`client_password`='".$pass."' OR `client_password`='".$pass_md5."') AND `client_email`='".$email."' LIMIT 1;");
				$if_member = mysql_num_rows($result);

			closesql();

				if ($if_member == 1)
				{
					setcookie("mail", $email, 0);
					setcookie("pass", $pass, 0);
					echo '<script type="text/javascript">window.location = "/'.$back_url.'"</script>';
				}
				else
				{
					$error_login = 'הפרטים שהזנת אינם נכונים.<br><br>';
				}
	}

	// if register
	if ($_POST['register'] == "1")
	{
		$client_firstname	= strtolower($_POST['client_firstname']);
		$client_lastname	= strtolower($_POST['client_lastname']);
		$client_password	= strtolower($_POST['client_password']);
		$client_email		= strtolower($_POST['client_email']);
		$client_city		= strtolower($_POST['client_city']);
		$client_address		= strtolower($_POST['client_address']);
		$client_phone		= strtolower($_POST['client_phone']);
		$client_cellphone	= strtolower($_POST['client_cellphone']);

			opensql();

				$result = mysql_query("SELECT * FROM `Coupons_Clients` WHERE `client_email`='".$client_email."' LIMIT 1;");
				$if_member = mysql_num_rows($result);
				
			closesql();

			if ($if_member == 1)
			{
				$error_register = 'האימייל שהזנת קיים במערכת.<br><br>';
			}
			else
			{
				// add user to db
				opensql();
					mysql_query("INSERT INTO `Coupons_Clients` VALUES (NULL, 
					'".$client_firstname."', 
					'".$client_lastname."', 
					'".$client_password."', 
					'".$client_email."', 
					'', 
					'',
					'',
					'', 
					'',
					'".$client_cellphone."',
					'".date("d-m-Y")."',
					'".date("G:i:s")."');");
						mysql_query("OPTIMIZE TABLE `Coupons_Clients`");
							mysql_query("REPAIR TABLE `Coupons_Clients`");
								mysql_query("ANALYZE TABLE `Coupons_Clients`");


					// add email to newsletter
					if ($_POST['is_news'] == "on")
					{
						$result = mysql_query("SELECT * FROM `Coupons_Newsletter` WHERE `newsletter_email`='".$client_email."' LIMIT 1;");
						$in_list = mysql_num_rows($result);
						if ($in_list == 0)
						{
							mysql_query("INSERT INTO `Coupons_Newsletter` VALUES ( NULL, '".$_SERVER['REMOTE_ADDR']."', '1', '".date("d-m-Y")."', '".date("G:i:s")."', '".$client_email."');");
								mysql_query("OPTIMIZE TABLE `Coupons_Newsletter`");
									mysql_query("REPAIR TABLE `Coupons_Newsletter`");
										mysql_query("ANALYZE TABLE `Coupons_Newsletter`");
						}
					}

				closesql();
				setcookie("mail", $client_email, 0);
				setcookie("pass", $client_password, 0);
				echo '<script type="text/javascript">window.location = "/'.$back_url.'"</script>';
			}
	}

	$meta_title			= 'הירשם למערכת הקופונים';
	$meta_description	= 'הירשם למערכת הקופונים';
	$meta_keywords		= 'הירשם למערכת הקופונים';

	include "header.php";

?>

<div style="padding:0px 60px 20px 20px;">
<table width="100%">
 <tr>
  <td valign="top" align="right">
<h2>הרשמה לאתר</h2>
<?=$error_register;?>

<script src="valid_small.js"></script>
<form method="post" action="" onsubmit="return checkform(this);" style="padding:0px; margin:0px;">
<input type="hidden" name="register" value="1">
<table style="font-weight:bold; font-size:14px;" cellpadding="3">
 <tr><td>שם פרטי:</td><td><input	 name="client_firstname"	value="<?=$client_firstname;?>" type="text" class="contact-input" style="width:180px; text-align:right;"></td></tr>
 <tr><td>שם משפחה:</td><td><input	 name="client_lastname"		value="<?=$client_lastname;?>" type="text" class="contact-input" style="width:180px; text-align:right;"></td></tr>
 <tr><td>סיסמא:</td><td><input		 name="client_password"		value="<?=$client_password;?>" type="text" class="contact-input" style="width:180px; text-align:right;"></td></tr>
 <tr><td>אימות סיסמא:</td><td><input name="client_password2"	value="<?=$client_password2;?>" type="text" class="contact-input" style="width:180px; text-align:right;"></td></tr>
 <tr><td>אימייל:</td><td><input		 name="client_email"		value="<?=$client_email;?>" type="text" class="contact-input" style="width:180px; direction:ltr; text-align:left;"></td></tr>
 <!--<tr><td>עיר:</td><td><input	 name="client_city"			value="<?=$client_city;?>" type="text" class="contact-input" style="width:180px; text-align:right;"></td></tr>
 <tr><td>רחוב:</td><td><input		 name="client_address"		value="<?=$client_address;?>" type="text" class="contact-input" style="width:180px; text-align:right;"></td></tr>
 <tr><td>מס דירה:</td><td><input	 name="client_dira_num"		value="<?=$client_address;?>" type="text" class="contact-input" style="width:180px; text-align:right;"></td></tr>
 <tr><td>מס בית:</td><td><input		 name="client_bait_num"		value="<?=$client_address;?>" type="text" class="contact-input" style="width:180px; text-align:right;"></td></tr>
 <tr><td>טלפון:</td><td><input		 name="client_phone"		value="<?=$client_phone;?>" type="text" class="contact-input" style="width:180px; text-align:right;"></td></tr>-->
 <tr><td>סלולרי:</td><td><input		 name="client_cellphone"	value="<?=$client_cellphone;?>" type="text" class="contact-input" style="width:180px; text-align:right;"></td></tr>
</table>

<div style="padding:5px; font-size:13px;"><input name="is_news" type="checkbox" checked>מעוניין לקבל מבצעים לדואר האלקטרוני</div>

<div style="float:left; padding-left:20px;"><input type="submit" class="button" value="הירשם" /></div>

</form>

  </td>
  <td width="1" style="background-color:#dedede; width:1px; border:0px;"></td>
  <td width="20"></td>
  <td valign="top" align="right">
<h2>כניסה לרשומים</h2>
<?=$error_login;?>
<script>
function checkform2 ( form )
{
	if (form.email.value == '') { alert( "חובה להזין אימייל" ); form.email.focus(); return false ; }
	if (form.pass.value == '') { alert( "חובה להזין סיסמא" ); form.pass.focus(); return false ; }
  return true ;
}
</script>

<form method="post" action="" onsubmit="return checkform2(this);" style="padding:0px; margin:0px;">
<input type="hidden" name="login" value="1">
<table style="font-weight:bold; font-size:14px;" cellpadding="3">
 <tr><td>אימייל:</td><td><input name="email" type="text" class="contact-input" style="width:190px; direction:ltr; text-align:left;"></td></tr>
 <tr><td>סיסמא:</td><td><input  name="pass" type="text" class="contact-input" style="width:190px; text-align:right;"></td></tr>
 <tr><td></td><td align="left"><input type="submit" class="button" value="התחבר" /></td></tr>
</table>
</form>

  </td>
 </tr>
</table>
</div>

<? include "footer.php"; ?>