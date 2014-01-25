<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
 <html xmlns="http://www.w3.org/1999/xhtml">
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <title>פירוט הזמנה</title>
   <style>
   body { color:#000000; background-color:#fff; }
   body { font-family: "Arial", "Arial (Hebrew)", "David (Hebrew)", "Courier New (Hebrew)"; font-size:12px; font-weight:normal; padding:0px; margin:0px; }
   h1,h2,h3 { font-family: "Arial", "Arial (Hebrew)", "David (Hebrew)", "Courier New (Hebrew)"; }
   #preview
   {
    position:absolute;
    border:1px solid #ccc;
    background:#333;
    padding:2px;
    display:none;
    color:#fff;
   }
	table,tr,td { text-align:right; direction:rtl; }
   </style>
   <script src="images/jquery.js" type="text/javascript"></script>
   <script src="images/main.js" type="text/javascript"></script>
 </head>
<body dir="rtl">

<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! View order details ! ..                                                    *
*********************************************************************************  */

	include "sql.php";
	include "check_user.php";
	
	$order_id = $HTTP_GET_VARS['id'];

		opensql();

			$result = mysql_query("SELECT * FROM `Coupons_Orders` WHERE `order_client_id`='".$client_id."' AND `order_id`='".$order_id."' AND `order_status`='1' AND `order_present`='0' LIMIT 1;");
			$order_ex = mysql_num_rows($result);

			if ($order_ex == 1)
			{
				$order_date				= mysql_result($result, 0, "order_date");
				$order_hour				= mysql_result($result, 0, "order_hour");
				$order_client_id		= mysql_result($result, 0, "order_client_id");
				$order_price			= mysql_result($result, 0, "order_price");
				$order_shipping			= mysql_result($result, 0, "order_shipping");	if ($order_shipping == 0) $order_shipping = '-';
				$order_snif				= mysql_result($result, 0, "order_snif");		if ($order_snif == 0) $order_snif = '-';
				$order_email			= mysql_result($result, 0, "order_email");
				$order_cellphone		= mysql_result($result, 0, "order_cellphone");
				$order_phone			= mysql_result($result, 0, "order_phone");
				$order_first_name		= mysql_result($result, 0, "order_first_name");
				$order_last_name		= mysql_result($result, 0, "order_last_name");
				$order_city				= mysql_result($result, 0, "order_city");
				$order_address			= mysql_result($result, 0, "order_address");
				$order_dira				= mysql_result($result, 0, "order_dira");
				$order_bait				= mysql_result($result, 0, "order_bait");
				$order_notes			= mysql_result($result, 0, "order_notes");
				$order_coupons			= mysql_result($result, 0, "order_coupons");
			
				$order_deal_id			= mysql_result($result, 0, "order_deal_id");

					$result				= mysql_query("SELECT * FROM `Coupons_Deals` WHERE `deal_id`='".$order_deal_id."' LIMIT 1;");
					$deal_name			= mysql_result($result, 0, "deal_name");
					$deal_text_1			= mysql_result($result, 0, "deal_text_1");
					$deal_text_2			= mysql_result($result, 0, "deal_text_2");

				closesql();

				?>
				

 <center>
  <div style="padding-top:10px;"></div>
   <img src="images/logo.png"><br>
   <h1>צפייה בהזמנה מספר <?=$order_id;?> <a href="#" onClick="window.print()" style="font-size:13px;">הדפס</a></h1> 

<div style="width:900px; font-weight:bold; font-size:15px;">
שם הדיל: <?=$deal_name;?>

<?=$deal_text_1;?><br>
<?=$deal_text_2;?>

</div>

<table width="600">
 <tr>
  <td valign="top" width="50%">

	 <h3>מידע על ההזמנה</h3>
     <table cellpadding="4" cellspacing="2">
	  <tr><td>תאריך:</td><td width="5"></td><td>				<?=$order_hour;?>		</td></tr>
	  <tr><td>מחיר:</td><td width="5"></td><td>					₪<?=$order_price;?>		</td></tr>
	  <tr><td>משלוח:</td><td width="5"></td><td>				<?=$order_shipping;?>	</td></tr>
	  <tr><td>סניף:</td><td width="5"></td><td>					<?=$order_snif;?>		</td></tr>
	 </table>

	  <h3>רשימת קוד קופונים:</h3>
	  <?
		  $order_coupons_exp = explode("~", $order_coupons);
		  foreach ($order_coupons_exp as $c)
		  {
			$c_exp = explode("-", $c);
			if ($c_exp[1] == "0")
				echo '<b>'.$c_exp[0].'</b><br>';
		  }
	  ?>

  </td>
  <td valign="top" width="50%">

	  <h3>פרטי הלקוח המזמין</h3>
     <table cellpadding="4" cellspacing="2">
	  <tr><td>טלפון הלקוח:</td><td width="5"></td><td>			<?=$order_phone;?>			</td></tr>
	  <tr><td>סלולרי הלקוח:</td><td width="5"></td><td>			<?=$order_cellphone;?>		</td></tr>
	  <tr><td>שם פרטי:</td><td width="5"></td><td>				<?=$order_first_name;?>		</td></tr>
	  <tr><td>שם משפחה:</td><td width="5"></td><td>				<?=$order_last_name;?>		</td></tr>
	 </table>

	  <h3>לאן לשלוח? במידה וצריך..</h3>
     <table cellpadding="4" cellspacing="2">
	  <tr><td>עיר:</td><td width="5"></td><td>					<?=$order_city;?>			</td></tr>
	  <tr><td>כתובת:</td><td width="5"></td><td>				<?=$order_address;?>		</td></tr>
	  <tr><td>מספר דירה:</td><td width="5"></td><td>			<?=$order_dira;?>			</td></tr>
	  <tr><td>מספר בית:</td><td width="5"></td><td>				<?=$order_bait;?>			</td></tr>
	  <tr><td>הערות הלקוח:</td><td width="5"></td><td>			<?=$order_notes;?>			</td></tr>
	 </table>

</td></tr></table>

				<?

			}
			else
			{
				echo '<script type="text/javascript">window.location = "user.php"</script>';
			}

?>