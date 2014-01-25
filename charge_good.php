<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! GOOD - Succesfully ! ..                                                    *
*********************************************************************************  */


	/* -----------------------------------
	-------- Result from Pelecard --------
	----------------------------------- */

	$result		= $_POST['result'];
	$autorize	= substr($_POST['result'], 70, 7);
	$parmx		= $_POST['parmx'];
		
		$parmx_exp = explode("AND", $parmx);
		$tran_id = $parmx_exp[0];		$tran_id = str_replace("tis", "", $tran_id);
		$deal_id = $parmx_exp[1];		$deal_id = str_replace("dis", "", $deal_id);

	$id			= $_POST['id'];
	$token		= $_POST['token'];

	$meta_title			= 'הרכישה בוצעה בהצלחה!';
	$meta_description	= 'הרכישה בוצעה בהצלחה!';
	$meta_keywords		= 'הרכישה בוצעה בהצלחה!';

	include "sql.php";
	include "header.php";
	include "check_user.php";

	opensql();
		
		/* -----------------------------------------
		------------ generate coupon id ------------
		-------------------------------------------- */

		function generate_coupon_id()
		{
			$characters = array("A","B","C","D","E","F","G","H","J","K","L","M", "N","P","Q","R","S","T","U","V","W","X","Y","Z", "1","2","3","4","5","6","7","8","9");
			$keys = array();
			while(count($keys) < 9)
			{
				$x = mt_rand(0, count($characters)-1);
				if(!in_array($x, $keys)) { $keys[] = $x; }
			}
			foreach($keys as $key) { $random_chars .= $characters[$key]; }
			return $random_chars;
		}

		/* -------------------------------------------
		------------ find if order exsist ------------
		-------------------------------------------- */

		$result = mysql_query("SELECT * FROM `Coupons_pending` WHERE `pending_id`='".$tran_id."' LIMIT 1;");
		$pending_exsist  = mysql_num_rows($result);
		if ($pending_exsist == 1)
		{

			/* -----------------------------------
			------------ organize data ------------
			----------------------------------- */

			$pending_total				= mysql_result($result,0,"pending_total");
			$pending_shipping			= mysql_result($result,0,"pending_shipping");
			$pending_count				= mysql_result($result,0,"pending_count");
			$pending_snif				= mysql_result($result,0,"pending_snif");
			$pending_city				= mysql_result($result,0,"pending_city");
			$pending_address			= mysql_result($result,0,"pending_address");
			$pending_dira				= mysql_result($result,0,"pending_dira");
			$pending_bait				= mysql_result($result,0,"pending_bait");
			$pending_notes				= mysql_result($result,0,"pending_notes");
			$pending_is_present			= mysql_result($result,0,"pending_is_present");
			$pending_present_name		= mysql_result($result,0,"pending_present_name");
			$pending_present_email		= mysql_result($result,0,"pending_present_email");
			$pending_present_msg		= mysql_result($result,0,"pending_present_msg");

			/* -----------------------------------
			------------ deal data ---------------
			----------------------------------- */

			$deal_info = mysql_query("SELECT * FROM `Coupons_Deals` WHERE `deal_id`='".$deal_id."' LIMIT 1;");
				
				$deal_name			= mysql_result($deal_info,0,"deal_name");
				$deal_text_1		= mysql_result($deal_info,0,"deal_text_1");
				$deal_text_2		= mysql_result($deal_info,0,"deal_text_2");
				$deal_text_3		= mysql_result($deal_info,0,"deal_text_3");

			/* ---------------------------------------
			------------ generate coupons ------------
			--------------------------------------- */

			$coupons_string = '';
			$coupons_for_mail = '';
			for ($i=0;$i<$pending_count;$i++)
			{
				$flag = 0;
				while($flag == 0)
				{
					$one_coupon = generate_coupon_id();
					$result = mysql_query("SELECT * FROM `Coupons_Orders` WHERE `order_coupons` LIKE '%".$one_coupon."%' LIMIT 1;");
					$if_exsist  = mysql_num_rows($result);
					if ($if_exsist == 0)
					{
						$flag = 1;
						$coupons_string = "".$coupons_string."~".$one_coupon."-0";
						$coupons_for_mail = "".$coupons_for_mail."".$one_coupon."<br>";
					}
				}
			}
			$coupons_string = substr($coupons_string, 1);

			/* -----------------------------------
			------------ insert to db ------------
			----------------------------------- */

			mysql_query("INSERT INTO `impala_b10`.`Coupons_Orders` (
			`order_id` ,
			`order_date` ,
			`order_hour` ,
			`order_client_id` ,
			`order_deal_id` ,
			`order_status` ,
			`order_price` ,
			`order_shipping` ,
			`order_snif` ,
			`order_coupons` ,
			`order_present` ,
			`order_present_name` ,
			`order_present_email` ,
			`order_present_msg` ,
			`order_email` ,
			`order_phone` ,
			`order_cellphone` ,
			`order_first_name` ,
			`order_last_name` ,
			`order_city` ,
			`order_address` ,
			`order_dira` ,
			`order_bait` ,
			`order_notes` ,
			`order_autorize` ,
			`order_token`
			)
			VALUES (NULL ,
			'".date("d-m-Y")."',
			'".date("H:i:s")."', 
			'".$client_id."',
			'".$deal_id."',
			'1',
			'".$pending_total."',
			'".$pending_shipping."',
			'".$pending_snif."',
			'".$coupons_string."',
			'".$pending_is_present."',
			'".$pending_present_name."',
			'".$pending_present_email."',
			'".$pending_present_msg."',
			'".$client_email."',
			'".$client_phone."',
			'".$client_cellphone."',
			'".$client_firstname."',
			'".$client_lastname."',
			'".$client_city."',
			'".$client_address."',
			'".$client_dira."',
			'".$client_bait."',
			'".$pending_notes."',
			'".$autorize."',
			'".$token."');");

				$order_id = mysql_insert_id();

					mysql_query("OPTIMIZE TABLE `Coupons_Orders`");
						mysql_query("REPAIR TABLE `Coupons_Orders`");
							mysql_query("ANALYZE TABLE `Coupons_Orders`");		


			/* --------------------------------
			------------ send mail ------------
			--------------------------------- */

				/* --------------------------------
				------------ send to user ---------
				--------------------------------- */
				if ($pending_is_present == 0)
				{
					$sender_mail	= $client_email;
					$sender_name	= $client_phone;
					$sender_msg		= '';
					$sender_subject = 'הזמנה מספר '.$order_id.' - '.$Company_name.'';
				
						// Reg order
						$result = mysql_query("SELECT * FROM `Coupons_Special_Texts` WHERE `id`='3' LIMIT 1;");
							$special_con	= mysql_result($result, 0, "content");

								// Replaces
								$special_con	= str_replace("%DEAL_NAME%",	$deal_name, $special_con);
								$special_con	= str_replace("%DEAL_ID%",		$deal_id, $special_con);
								$special_con	= str_replace("%COUNT%",		$pending_count, $special_con);
								$special_con	= str_replace("%COUPON_LIST%",	$coupons_for_mail, $special_con);

				}


				/* --------------------------------
				------------ send as present ------
				--------------------------------- */
				else
				{
					$sender_mail	= $pending_present_email;
					$sender_name	= $pending_present_name;
					$sender_msg		= "".$pending_present_msg."<br><br>";
					$sender_subject = 'קיבלת מתנה מחבר - '.$Company_name.' - הזמנה מספר '.$order_id.'';
				
						// Gift order
						$result = mysql_query("SELECT * FROM `Coupons_Special_Texts` WHERE `id`='4' LIMIT 1;");
							$special_con	= mysql_result($result, 0, "content");

								// Replaces
								$special_con	= str_replace("%DEAL_NAME%",	$deal_name, $special_con);
								$special_con	= str_replace("%DEAL_ID%",		$deal_id, $special_con);
								$special_con	= str_replace("%COUNT%",		$pending_count, $special_con);
								$special_con	= str_replace("%COUPON_LIST%",	$coupons_for_mail, $special_con);
								$special_con	= str_replace("%PRIVATE_MSG%",	$sender_msg, $special_con);
				}

				closesql();

				$headers = 'MIME-Version: 1.0'."\r\n";
				$headers .= 'Content-type: text/html; charset=UTF-8'."\r\n";
				$headers .= "From: ".$Company_site." <no-reply@".$Company_name.">\r\n";
				$headers .= "Reply-To: info@".$Company_name."\r\n";

				$body = '
				<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml" dir="rtl"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head><body>
				'.$special_con.'
				</body>
				</html>';

				mail($sender_mail, '=?UTF-8?B?'.base64_encode($sender_subject).'?=', $body, $headers);


			/* -------------------------------------
			------------ delete pending ------------
			-------------------------------------- */

			opensql();

				mysql_query("DELETE FROM `Coupons_pending` WHERE `Coupons_pending`.`pending_id` = ".$tran_id."");
					mysql_query("OPTIMIZE TABLE `Coupons_pending`");
						mysql_query("REPAIR TABLE `Coupons_pending`");
							mysql_query("ANALYZE TABLE `Coupons_pending`");	

			/* -------------------------------------
			------------ update counter ------------
			-------------------------------------- */

				$result = mysql_query("SELECT * FROM `Coupons_Deals` WHERE `deal_id`='".$deal_id."' LIMIT 1;");
					$real_count_now	= mysql_result($result, 0, "deal_real_buyers");
						$real_count_now = $real_count_now+$pending_count;

				mysql_query("UPDATE `Coupons_Deals` SET `deal_real_buyers` = '".$real_count_now."' WHERE `deal_id` =".$deal_id.";");
					mysql_query("OPTIMIZE TABLE `Coupons_Deals`");
						mysql_query("REPAIR TABLE `Coupons_Deals`");
							mysql_query("ANALYZE TABLE `Coupons_Deals`");	

			closesql();

		}


		/* -------------------------------------------
		------------ redirect if no order ------------
		------------------------------------------- */
		else
		{
			echo '<script type="text/javascript">window.location = "user.php"</script>';
		}


	/* -----------------------------------
	------------ Special text ------------
	------------------------------------ */
	opensql();

		// Data
		$result = mysql_query("SELECT * FROM `Coupons_Special_Texts` WHERE `id`='2' LIMIT 1;");
			$special_con	= mysql_result($result, 0, "content");

				// Replaces
				$special_con	= str_replace("%TOTAL%", $pending_total, $special_con);
				$special_con	= str_replace("%ORDER_ID%", $order_id, $special_con);

		echo $special_con;

	closesql();

include "footer.php"; ?>