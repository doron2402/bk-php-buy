<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! add\edit deals ! ..                                                        *
*********************************************************************************  */

	// ------------- // 
	// -- defines -- //
	// ------------- // 
	$color = 6;
	$id = $HTTP_GET_VARS['id'];

	// -------------- // 
	// -- includes -- //
	// -------------- // 
	include "iframe_html.php";
	include "sql.php";
	include "config.php";

	opensql();

		$selected_id = $HTTP_GET_VARS['id'];
		$result = mysql_query("SELECT * FROM `Coupons_Orders` WHERE `order_id`='".$id."' LIMIT 1;");
		$total = mysql_num_rows($result);
		if ($total == 0)
			echo 'אין הזמנה כזאת';
		
		else
		{

			$add_to_title = '';
			$order_coupons			= mysql_result($result, 0, "order_coupons");
					$order_coupons_x = explode("~", $order_coupons);
						$count_order_coupons = count($order_coupons_x);
			$order_deal_id			= mysql_result($result, 0, "order_deal_id");
			$order_status			= mysql_result($result, 0, "order_status");

				$result5 = mysql_query("SELECT * FROM `Coupons_Deals` WHERE `deal_id`='".$order_deal_id."' LIMIT 1;");
					$deal_fake_buyers = mysql_result($result5, 0, "deal_fake_buyers");
					$deal_real_buyers = mysql_result($result5, 0, "deal_real_buyers");

			/* ----------------------------------
			--------- Deactive coupon -----------
			---------------------------------- */
			if ($HTTP_GET_VARS['deactive'] != NULL)
			{
				$order_coupons = str_replace("".$HTTP_GET_VARS['deactive']."-0", "".$HTTP_GET_VARS['deactive']."-1", $order_coupons);

					mysql_query("UPDATE `Coupons_Orders` SET `order_coupons` = '".$order_coupons."' WHERE `Coupons_Orders`.`order_id` =".$id.";");
						mysql_query("OPTIMIZE TABLE `Coupons_Orders`");
							mysql_query("REPAIR TABLE `Coupons_Orders`");
								mysql_query("ANALYZE TABLE `Coupons_Orders`");

							$deal_fake_buyers++;
							$deal_real_buyers--;

					mysql_query("UPDATE `Coupons_Deals` SET `deal_real_buyers` = ".$deal_real_buyers." WHERE `Coupons_Deals`.`deal_id` =".$order_deal_id.";");
					mysql_query("UPDATE `Coupons_Deals` SET `deal_fake_buyers` = ".$deal_fake_buyers." WHERE `Coupons_Deals`.`deal_id` =".$order_deal_id.";");
						mysql_query("OPTIMIZE TABLE `Coupons_Deals`");
							mysql_query("REPAIR TABLE `Coupons_Deals`");
								mysql_query("ANALYZE TABLE `Coupons_Deals`");

				
				$add_to_title = '<font color="red"> - קוד הקופון בוטל בהצלחה.</font>';
			}
			/* ---------------------------------
			--------- Active coupon ------------
			---------------------------------- */
			if ($HTTP_GET_VARS['active'] != NULL)
			{
				$order_coupons = str_replace("".$HTTP_GET_VARS['active']."-1", "".$HTTP_GET_VARS['active']."-0", $order_coupons);

					mysql_query("UPDATE `Coupons_Orders` SET `order_coupons` = '".$order_coupons."' WHERE `Coupons_Orders`.`order_id` =".$id.";");
						mysql_query("OPTIMIZE TABLE `Coupons_Orders`");
							mysql_query("REPAIR TABLE `Coupons_Orders`");
								mysql_query("ANALYZE TABLE `Coupons_Orders`");

							$deal_fake_buyers--;
							$deal_real_buyers++;

					mysql_query("UPDATE `Coupons_Deals` SET `deal_real_buyers` = ".$deal_real_buyers." WHERE `Coupons_Deals`.`deal_id` =".$order_deal_id.";");
					mysql_query("UPDATE `Coupons_Deals` SET `deal_fake_buyers` = ".$deal_fake_buyers." WHERE `Coupons_Deals`.`deal_id` =".$order_deal_id.";");
						mysql_query("OPTIMIZE TABLE `Coupons_Deals`");
							mysql_query("REPAIR TABLE `Coupons_Deals`");
								mysql_query("ANALYZE TABLE `Coupons_Deals`");

				$add_to_title = '<font color="red"> - קוד הקופון הופעל בהצלחה.</font>';
			}

			/* ----------------------------------------
			--------- Disable\Enable Order ------------
			---------------------------------------- */
			if ($HTTP_GET_VARS['status'] != NULL)
			{
				// Disable
				if ($HTTP_GET_VARS['status'] == 0)
				{
					mysql_query("UPDATE `Coupons_Orders` SET `order_status` = '0' WHERE `Coupons_Orders`.`order_id` =".$id.";");
						mysql_query("OPTIMIZE TABLE `Coupons_Orders`");
							mysql_query("REPAIR TABLE `Coupons_Orders`");
								mysql_query("ANALYZE TABLE `Coupons_Orders`");


							$deal_fake_buyers = $deal_fake_buyers+$count_order_coupons;
							$deal_real_buyers = $deal_real_buyers-$count_order_coupons;

					mysql_query("UPDATE `Coupons_Deals` SET `deal_real_buyers` = ".$deal_real_buyers." WHERE `Coupons_Deals`.`deal_id` =".$order_deal_id.";");
					mysql_query("UPDATE `Coupons_Deals` SET `deal_fake_buyers` = ".$deal_fake_buyers." WHERE `Coupons_Deals`.`deal_id` =".$order_deal_id.";");
						mysql_query("OPTIMIZE TABLE `Coupons_Deals`");
							mysql_query("REPAIR TABLE `Coupons_Deals`");
								mysql_query("ANALYZE TABLE `Coupons_Deals`");

					$add_to_title = '<font color="red"> - ההזמנה בוטלה בהצלחה.</font>';
					$order_status = 0;
				}
				// Enable
				else
				{
					mysql_query("UPDATE `Coupons_Orders` SET `order_status` = '1' WHERE `Coupons_Orders`.`order_id` =".$id.";");
						mysql_query("OPTIMIZE TABLE `Coupons_Orders`");
							mysql_query("REPAIR TABLE `Coupons_Orders`");
								mysql_query("ANALYZE TABLE `Coupons_Orders`");

							$deal_fake_buyers = $deal_fake_buyers-$count_order_coupons;
							$deal_real_buyers = $deal_real_buyers+$count_order_coupons;

					mysql_query("UPDATE `Coupons_Deals` SET `deal_real_buyers` = ".$deal_real_buyers." WHERE `Coupons_Deals`.`deal_id` =".$order_deal_id.";");
					mysql_query("UPDATE `Coupons_Deals` SET `deal_fake_buyers` = ".$deal_fake_buyers." WHERE `Coupons_Deals`.`deal_id` =".$order_deal_id.";");
						mysql_query("OPTIMIZE TABLE `Coupons_Deals`");
							mysql_query("REPAIR TABLE `Coupons_Deals`");
								mysql_query("ANALYZE TABLE `Coupons_Deals`");

					$add_to_title = '<font color="green"> - ההזמנה אושרה בחזרה.</font>';
					$order_status = 1;
				}
			}

			/* -------------------------------
			--------- Get SQL DATA -----------
			------------------------------- */
			$order_id			= mysql_result($result, 0, "order_id");
			$order_date			= mysql_result($result, 0, "order_date");
																					$date_between		= generate_times(date("d-m-Y"), $order_date);
																						$order_date	= ''.$order_date.' ('.$date_between.')';
			$order_hour			= mysql_result($result, 0, "order_hour");
			$order_client_id	= mysql_result($result, 0, "order_client_id");
			$order_price		= mysql_result($result, 0, "order_price");
			$order_shipping		= mysql_result($result, 0, "order_shipping");
			$order_snif			= mysql_result($result, 0, "order_snif");			if ($order_snif == NULL) $order_snif = '-';

			$order_present			= mysql_result($result, 0, "order_present");			
																					if ($order_present == 0) $order_present_text = 'לא';
																					if ($order_present == 1) $order_present_text = 'כן';

			$order_present_name		= mysql_result($result, 0, "order_present_name");
			$order_present_email	= mysql_result($result, 0, "order_present_email");
			$order_present_msg		= mysql_result($result, 0, "order_present_msg");

			$order_email			= mysql_result($result, 0, "order_email");
			$order_phone			= mysql_result($result, 0, "order_phone");
			$order_cellphone		= mysql_result($result, 0, "order_cellphone");
			$order_first_name		= mysql_result($result, 0, "order_first_name");
			$order_last_name		= mysql_result($result, 0, "order_last_name");
			$order_city				= mysql_result($result, 0, "order_city");
			$order_address			= mysql_result($result, 0, "order_address");
			$order_dira				= mysql_result($result, 0, "order_dira");
			$order_bait				= mysql_result($result, 0, "order_bait");
			$order_notes			= mysql_result($result, 0, "order_notes");

			$order_autorize			= mysql_result($result, 0, "order_autorize");
			$order_token			= mysql_result($result, 0, "order_token");

																					if ($order_status == "1")
																						$order_status_text = '<font color="green">פעיל</font>';
																					else
																						$order_status_text = '<font color="red">לא פעיל</font>';

?>

  <!-- Update form -->
  <div style="padding:10px;">
  <center>

    <h1>צפייה בהזמנה מספר <?=$id;?><?=$add_to_title;?></h1>

<table width="90%">
 <tr>
  <td valign="top">

	  <h3>מידע על הדיל</h3>
     <table cellpadding="4" cellspacing="2">
	  <tr><td>מס הזמנה:</td><td width="5"></td><td>				<?=$order_id;?>							</td></tr>
	  <tr><td>תאריך:</td><td width="5"></td><td>				<?=$order_date;?> <?=$order_hour;?>		</td></tr>
	  <tr><td>מס לקוח:</td><td width="5"></td><td>				<?=$order_client_id;?>					</td></tr>
	  <tr><td>דיל מספר:</td><td width="5"></td><td>				<?=$order_deal_id;?>					</td></tr>
	  <tr><td>מחיר:</td><td width="5"></td><td>					₪<?=$order_price;?>						</td></tr>
	  <tr><td>משלוח:</td><td width="5"></td><td>				<?=$order_shipping?>					</td></tr>
	  <tr><td>סניף:</td><td width="5"></td><td>					<?=$order_snif;?>						</td></tr>
	 </table>

	  <h3>מתנה?</h3>
     <table cellpadding="4" cellspacing="2">
	  <tr><td>מתנה:</td><td width="5"></td><td>					<?=$order_present_text;?>					</td></tr>
	  <tr><td>שם מקבל המתנה:</td><td width="5"></td><td>		<?=$order_present_name?>				</td></tr>
	  <tr><td>אימייל מקבל המתנה:</td><td width="5"></td><td>	<?=$order_present_email;?>				</td></tr>
     </table>

	  <h3>רשימת קוד קופונים:</h3>
	  <table cellpadding="4" border="1">
	  <?
		$order_coupons_exp = explode("~", $order_coupons);
	    foreach ($order_coupons_exp as $order_cp)
		{
			$order_s = explode("-", $order_cp);
			$c_num = $order_s[0];
			$c_sta = $order_s[1];
					if ($c_sta == 0) $c_sta_name = 'פעיל';
					else			 $c_sta_name = '<font color="red">לא פעיל</font>';

			echo '
			<tr>
			 <td>'.$c_num.'</td>
			 <td>'.$c_sta_name.'</td>
			';
			if ($c_sta == 0) echo '<td><a href="?id='.$id.'&deactive='.$c_num.'">בטל</a></td>';
			else			 echo '<td><a href="?id='.$id.'&active='.$c_num.'">אשר</a></td>';
			echo '</tr>';
		}
	  ?>
	  </table>

</td>
<td valign="top">

	  <h3>פרטי הלקוח המזמין</h3>
     <table cellpadding="4" cellspacing="2">
	  <tr><td>אימייל הלקוח:</td><td width="5"></td><td>			<?=$order_email?>						</td></tr>
	  <tr><td>טלפון הלקוח:</td><td width="5"></td><td>			<?=$order_phone?>						</td></tr>
	  <tr><td>סלולרי הלקוח:</td><td width="5"></td><td>			<?=$order_cellphone?>					</td></tr>
	  <tr><td>שם פרטי:</td><td width="5"></td><td>				<?=$order_first_name?>					</td></tr>
	  <tr><td>שם משפחה:</td><td width="5"></td><td>				<?=$order_last_name?>					</td></tr>
	 </table>

	  <h3>לאן לשלוח? במידה וצריך..</h3>
     <table cellpadding="4" cellspacing="2">
	  <tr><td>עיר:</td><td width="5"></td><td>					<?=$order_city?>						</td></tr>
	  <tr><td>כתובת:</td><td width="5"></td><td>				<?=$order_address?>						</td></tr>
	  <tr><td>מספר דירה:</td><td width="5"></td><td>			<?=$order_dira?>						</td></tr>
	  <tr><td>מספר בית:</td><td width="5"></td><td>				<?=$order_bait?>						</td></tr>
	  <tr><td>הערות הלקוח:</td><td width="5"></td><td>			<?=$order_notes?>					</td></tr>
	 </table>

	  <h3>מידע מpelecard</h3>
     <table cellpadding="4" cellspacing="2">
	  <tr><td>autorize #</td><td width="5"></td><td>			<?=$order_autorize?>					</td></tr>
	  <tr><td>token #</td><td width="5"></td><td>				<?=$order_token?>						</td></tr>
	 </table>

</td></tr></table>

<div style="padding-top:10px;"></div>
<h3>מצב הזמנה - <?=$order_status_text;?></h3>
<?
	if ($order_status == "1") { echo '<a href="?id='.$id.'&status=0">לחץ כאן לביטול ההזמנה</a>'; }
	else					  { echo '<a href="?id='.$id.'&status=1">לחץ כאן לאישור ההזמנה</a>'; }
?>


     </table>
    </div>
   <!-- end of Update form -->

<? } closesql();?>