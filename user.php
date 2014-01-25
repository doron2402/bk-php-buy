<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! user page ! ..                                                             *
*********************************************************************************  */

	include "sql.php";
	include "check_user.php";

	if ($Member_login == 0)
		echo '<script type="text/javascript">window.location = "login.php"</script>';

	$meta_title			= 'ממשק משתמש';
	$meta_description	= 'ממשק משתמש';
	$meta_keywords		= 'ממשק משתמש';

	/* -------------------------
	------ update Profile ------
	------------------------- */
	if ($_POST['update'] == "1")
	{
		$client_firstname	= strtolower($_POST['client_firstname']);
		$client_lastname	= strtolower($_POST['client_lastname']);
		$client_password	= strtolower($_POST['client_password']);
		$client_email		= strtolower($_POST['client_email']);
		$client_city		= strtolower($_POST['client_city']);
		$client_address		= strtolower($_POST['client_address']);
		$client_dira		= strtolower($_POST['client_dira']);
		$client_bait		= strtolower($_POST['client_bait']);
		$client_phone		= strtolower($_POST['client_phone']);
		$client_cellphone	= strtolower($_POST['client_cellphone']);

		opensql();

			mysql_query("UPDATE `Coupons_Clients` SET 
			`client_firstname` = '".$client_firstname."',
			`client_lastname` = '".$client_lastname."',
			`client_password` = '".$client_password."',
			`client_email` = '".$client_email."',
			`client_city` = '".$client_city."',
			`client_address` = '".$client_address."',
			`client_dira` = '".$client_dira."',
			`client_bait` = '".$client_bait."',
			`client_phone` = '".$client_phone."',
			`client_cellphone` = '".$client_cellphone."' WHERE `Coupons_Clients`.`client_id` =".$client_id.";");

				mysql_query("OPTIMIZE TABLE `Coupons_Clients`");
					mysql_query("REPAIR TABLE `Coupons_Clients`");
						mysql_query("ANALYZE TABLE `Coupons_Clients`");
		
			setcookie("mail", $client_email, 0);
			setcookie("pass", $client_password, 0);
			echo '<script type="text/javascript">window.location = "user.php?id=2"</script>';

		closesql();
	}

	$id = $HTTP_GET_VARS['id'];

	include "header.php";

?>

<div style="padding:0px 60px 20px 20px;">
<h2>ברוך הבא <?=$nick;?></h2>
 <table width="100%">
  <tr>
   <td align="right">
    <a href="user.php"	style="color:#000;<? if ($id == NULL) echo ' font-weight:bold;'; ?>">צפייה בהזמנות</a> |
    <a href="?id=2"		style="color:#000;<? if ($id != NULL) echo ' font-weight:bold;'; ?>">עדכון פרטים</a>
   </td>
   <td align="left"><a href="login.php?act=logout" style="color:red;">התנתק</a></td>
  </tr>
 </table><br>


<script type="text/javascript">
<!--
function popup(url) {
window.open( url, "myWindow", 
"status = 1, height = 300, width = 300, resizable = 0" )
}
//-->
</script>

<?

	/* -------------------------
	------ View orders ---------
	-------------------------- */
	if ($id == NULL)
	{
		opensql();

			$result = mysql_query("SELECT * FROM `Coupons_Orders` WHERE `order_client_id`='".$client_id."' ORDER BY `order_id` DESC");
			$clients_orders = mysql_num_rows($result);
				
			if ($clients_orders == 0)
			{
				echo 'עוד לא רכשת דילים באתר..';
			}
			else
			{
				echo '<table width="100%" stle="direction:rtl; text-align:right;">
				 <tr style="background-color:red; color:#fff; font-size:13px;">
				  <td>מספר הזמנה</td>
				  <td>תאריך</td>
				  <td>פעיל?</td>
				  <td>סכום</td>
				  <td>מספר דיל</td>
				  <td>מתנה?</td>
				  <td>פירוט</td>
				 </tr>';

				for ($i=0;$i<$clients_orders;$i++)
				{
					$order_id			= mysql_result($result, $i, "order_id");
					$order_date			= mysql_result($result, $i, "order_date");
					$order_status		= mysql_result($result, $i, "order_status");

							if ($order_status == 0) $order_status_text = 'לא פעיל';
							if ($order_status == 1) $order_status_text = 'פעיל';

					$order_price		= mysql_result($result, $i, "order_price");
					$order_deal_id		= mysql_result($result, $i, "order_deal_id");
					$order_present		= mysql_result($result, $i, "order_present");

							if ($order_present == 0) $order_present_text = 'לא';
							if ($order_present == 1) $order_present_text = 'כן';

					echo '
					<tr style="font-size:13px;">
					 <td>'.$order_id.'</td>
					 <td>'.$order_date.'</td>
					 <td>'.$order_status_text.'</td>
					 <td>₪'.$order_price.'</td>
					 <td><a href="buy.php?id='.$order_deal_id.'">'.$order_deal_id.'</a></td>
					 <td>'.$order_present_text.'</td>';
				
					$ppp = "'";
					if (($order_present == 0) && ($order_status == 1))	echo '<td><a href="user_view_order.php?id='.$order_id.'" target="_blank">צפה</a></td>';
					else												echo '<td>-</td>';

					echo '</tr>';
				}
				echo '</table>';
			}
		closesql();
	}
	/* ------------------------------
	------ Update Profile FORM ------
	------------------------------- */
	else
	{ ?>
		<script src="valid.js"></script>
		<form method="post" action="" onsubmit="return checkform(this);" style="padding:0px; margin:0px;">
		<input type="hidden" name="update" value="1">
		<table width="100%"><tr><td valign="top">
		<table style="font-weight:bold; font-size:14px;" cellpadding="3">
		 <tr><td>שם פרטי:</td><td><input	 name="client_firstname"		value="<?=$client_firstname;?>" type="text" class="contact-input" style="width:180px; text-align:right;"></td></tr>
		 <tr><td>שם משפחה:</td><td><input	 name="client_lastname"			value="<?=$client_lastname;?>"	type="text" class="contact-input" style="width:180px; text-align:right;"></td></tr>
		 <tr><td>סיסמא:</td><td><input		 name="client_password"			value="<?=$client_password;?>"	type="text" class="contact-input" style="width:180px; text-align:right;"></td></tr>
		 <tr><td>אימות סיסמא:</td><td><input name="client_password2"		value="<?=$client_password2;?>" type="text" class="contact-input" style="width:180px; text-align:right;"></td></tr>
		 <tr><td>אימייל:</td><td><input		 name="client_email"			value="<?=$client_email;?>"		type="text" class="contact-input" style="width:180px; direction:ltr; text-align:left;"></td></tr>
		 <tr><td>טלפון:</td><td><input		 name="client_phone"			value="<?=$client_phone;?>"		type="text" class="contact-input" style="width:180px; text-align:right;"></td></tr>
		 <tr><td>פלאפון:</td><td><input		 name="client_cellphone"		value="<?=$client_cellphone;?>" type="text" class="contact-input" style="width:180px; text-align:right;"></td></tr>
		</table>
		</td><td valign="top">
		<table style="font-weight:bold; font-size:14px;" cellpadding="3">
		 <tr><td>עיר:</td><td><input		 name="client_city"				value="<?=$client_city;?>"		type="text" class="contact-input" style="width:180px; text-align:right;"></td></tr>
		 <tr><td>רחוב:</td><td><input		 name="client_address"			value="<?=$client_address;?>"	type="text" class="contact-input" style="width:180px; text-align:right;"></td></tr>
		 <tr><td>מספר בית:</td><td><input	 name="client_bait"				value="<?=$client_bait;?>"		type="text" class="contact-input" style="width:180px; text-align:right;"></td></tr>
		 <tr><td>מספר דירה:</td><td><input	 name="client_dira"				value="<?=$client_dira;?>"		type="text" class="contact-input" style="width:180px; text-align:right;"></td></tr>
		 <tr><td></td><td align="left"><input type="submit" class="button"	value="עדכן!" /></td></tr>
		</table>
		</td></tr></table>
		</form>
	<? }
?>

</div>

<? include "footer.php"; ?>