<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! Send newsletter to all !! ..                                               *
*********************************************************************************  */
	
	set_time_limit(0);

	// ------ Defines for the script ------ //
	
		header('Content-Type: text/html; charset=utf-8');
		define('bg_color', '#7ab435');
		define('color2', '#fff');
		define('test_mail', 'rtb@impala.co.il');

	// ------ Includes ------ //
	
		include "sql.php";

	// ------ Times ------ //

		$today		= date("d-m-Y");
		$yesterday  = date("d-m-Y", mktime(0, 0, 0, date("m"),date("d")-1, date("Y")));
		$hour		= date("H:i");

	opensql();

		// ----- Check if pending newsletter from yesterday -------- //
		$result = mysql_query("SELECT * FROM `Coupons_Send_Newsletter` WHERE `start_date`='".$yesterday."' AND status='1'");
		$in_list  = mysql_num_rows($result);
		$from_yesterday = 1;

			// ----- Check if pending newsletter from today -------- //
			if ($in_list == 0)
			{
				$result = mysql_query("SELECT * FROM `Coupons_Send_Newsletter` WHERE (`start_date`='".$today."' OR `start_date`='".$yesterday."') AND status='1'");
				$in_list  = mysql_num_rows($result);
				$from_yesterday = 0;
			}

		if ($in_list != 0)	
		{
			$flag = 0;
			for ($i=0;$i<$in_list;$i++)
			{
				if ($flag == 0)
				{

					// ------ Check if the hour is less than now ------ //

					$start_hour		= mysql_result($result, $i, "start_hour");
					$time_for_deal	= strtotime($start_hour);
					$time_now		= strtotime($hour);

					if (($time_for_deal < $time_now) || ($from_yesterday == 1))		// ----- Come on! the newsletter is ready. Send it :)
					{

						$flag = 1;	// send only 1 at 1 script - Important!

							// ------ Update deal to status 2 -> Sending.. ----------- //

							$the_deal_id  = mysql_result($result, $i, "id");
							mysql_query("UPDATE `Coupons_Send_Newsletter` SET `status` = '2' WHERE `Coupons_Send_Newsletter`.`id` =".$the_deal_id.";");
								mysql_query("OPTIMIZE TABLE `Coupons_Send_Newsletter`");
									mysql_query("REPAIR TABLE `Coupons_Send_Newsletter`");
										mysql_query("ANALYZE TABLE `Coupons_Send_Newsletter`");

							// ------ Generate text to send ----------- //

							$subject  = mysql_result($result, $i, "subject");
							$deals_id = mysql_result($result, $i, "deals_id");

							$deals_id = substr($deals_id, 1);	$deals_id = substr($deals_id, 0, -1);
							$deals_id_exp = explode(",", $deals_id);

							$headers = 'MIME-Version: 1.0'."\r\n";
							$headers .= 'Content-type: text/html; charset=UTF-8'."\r\n";
							$headers .= "From: ".$Company_name."<admin@".$Company_name.">\r\n";

							// --- Start of html --- //

							$body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
							<html xmlns="http://www.w3.org/1999/xhtml" dir="rtl"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><style> body { font-family: "Arial", "Arial (Hebrew)", "David (Hebrew)", "Courier New (Hebrew)"; font-size:12px; font-weight:normal; padding:0px; margin:0px; color:#000; direction:rtl; } div,table,tr,td { direction:rtl; } </style>
							</head><body dir="rtl"><center>
							';

							// --- Generate deals --- //

							foreach ($deals_id_exp as $d)
							{
								$result = mysql_query("SELECT * FROM `Coupons_Deals` WHERE `deal_id`='".$d."' LIMIT 1;");
								$deal_id			= mysql_result($result,0,"deal_id");
								$deal_reg_price		= mysql_result($result,0,"deal_reg_price");
								$deal_our_price		= mysql_result($result,0,"deal_our_price");
								$deal_bill_price	= mysql_result($result,0,"deal_bill_price");
								$deal_min_buyers	= mysql_result($result,0,"deal_min_buyers");
								$deal_max_buyers	= mysql_result($result,0,"deal_max_buyers");
								$deal_name			= mysql_result($result,0,"deal_name");
								$deal_name_left		= mysql_result($result,0,"deal_name_left");
								$deal_text_1		= mysql_result($result,0,"deal_text_1");
								$deal_text_2		= mysql_result($result,0,"deal_text_2");
								$deal_text_3		= mysql_result($result,0,"deal_text_3");
								$deal_image			= mysql_result($result,0,"deal_image");
								$deal_real_buyers 	= mysql_result($result,0,"deal_real_buyers");
								$deal_fake_buyers	= mysql_result($result,0,"deal_fake_buyers");
								$deal_status		= mysql_result($result,0,"deal_status");
								$total_buyers = $deal_real_buyers+$deal_fake_buyers;
								$deal_client_id	= mysql_result($result,0,"deal_client_id");

									// --- You save --- //

									$you_save			= $deal_reg_price-$deal_our_price;
									$you_save_avr		= 100-(($deal_our_price/$deal_reg_price)*100);
									$you_save_avr_exp	= explode(".", $you_save_avr);
									$you_save_avr		= $you_save_avr_exp[0];


							    // --- Body of the Text --- //
								$body = ''.$body.'
								  <table width="700" cellpadding="0" cellspacing="0" style="border:1px solid '.bg_color.'; border-radius:4px; -moz-border-radius:4px;">
								   <tr>
									<td align="right" valign="top">
									 <img src="http://'.$Company_name.'/products/'.$deal_image.'" width="200" height="178">
									 <div style="background-color:'.bg_color.'; font-weight:bold; padding:10px; text-align:center;"><a href="http://'.$Company_name.'/deal.php?id='.$deal_id.'&news_id=%News_id%" style="color:#fff; font-weight:bold; font-size:15px;">כניסה לדיל!</a></div>
									</td>
									<td align="right" valign="top">
									 <div style="background-color:#7ab435; font-weight:bold; padding:10px; font-size:14px;">'.$deal_name.'</div>
									 <table><tr>
									   <td><div style="background-color:'.bg_color.'; font-weight:bold; padding:10px; font-size:14px;">מחיר שלנו: '.$deal_our_price.' ₪</div></td>
									   <td><div style="background-color:'.color2.'; font-weight:bold; padding:10px; font-size:14px;">שווי: '.$deal_reg_price.' ₪</div></td>
									   <td><div style="background-color:'.color2.'; font-weight:bold; padding:10px; font-size:14px;">חסכון: '.$you_save_avr.' %</div></td>
									   <td><div style="background-color:'.color2.'; font-weight:bold; padding:10px; font-size:14px;">הנחה: '.$you_save.' ₪</div></td>
									 </tr></table>
									 <div style="padding:15px;">'.strip_tags($deal_text_1).'</td>
								   </tr>
								  </table>
								  <div style="padding-top:10px;">
								';

							}

							// --- Footer for the mail --- //

							$body = ''.$body.'
							 להסרה מרשימת התפוצה - <a href="http://'.$Company_name.'/remove_me.php?email=%Mail%">לחצו כאן</a>
							 </center></body>
							</html>';

							// --- Send mail function --- //

							$result2 = mysql_query("SELECT * FROM `Coupons_Newsletter` WHERE `newsletter_status`='1'");
							$news_list  = mysql_num_rows($result2);
							for ($z=0;$z<$news_list;$z++)
							{
								$newsletter_email  = mysql_result($result2, $z, "newsletter_email");
								$body2 = str_replace("%Mail%", $newsletter_email, $body);
								$body2 = str_replace("%News_id%", $the_deal_id, $body2);

								mail($newsletter_email, '=?UTF-8?B?'.base64_encode($subject).'?=', $body2, $headers);

								$total_sent_m = $z+1;
								mysql_query("UPDATE `Coupons_Send_Newsletter` SET `total_sent` = '".$total_sent_m."' WHERE `Coupons_Send_Newsletter`.`id` =".$the_deal_id.";");
									mysql_query("OPTIMIZE TABLE `Coupons_Send_Newsletter`");
										mysql_query("REPAIR TABLE `Coupons_Send_Newsletter`");
											mysql_query("ANALYZE TABLE `Coupons_Send_Newsletter`");

								sleep(1);
							}

							// ------ Update deal to status 3 -> Done.. ----------- //

							mysql_query("UPDATE `Coupons_Send_Newsletter` SET `status` = '3' WHERE `Coupons_Send_Newsletter`.`id` =".$the_deal_id.";");
								mysql_query("OPTIMIZE TABLE `Coupons_Send_Newsletter`");
									mysql_query("REPAIR TABLE `Coupons_Send_Newsletter`");
										mysql_query("ANALYZE TABLE `Coupons_Send_Newsletter`");

					}
				}
			}
		}

	closesql();

?>