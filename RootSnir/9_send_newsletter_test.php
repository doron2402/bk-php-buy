<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! send test newsleter ! ..                                                   *
*********************************************************************************  */

	header('Content-Type: text/html; charset=utf-8');
	define('bg_color', '#7ab435');
	define('color2', '#fff');
	define('test_mail', 'rtb@impala.co.il');

	$newsletter_id = $HTTP_GET_VARS['id'];

	include "sql.php";
	opensql();

		$result = mysql_query("SELECT * FROM `Coupons_Send_Newsletter` WHERE `id`='".$newsletter_id."' AND `status`='1' LIMIT 1;");
		$if_deal_pending = mysql_num_rows($result); 
		if ($if_deal_pending == 1)
		{
			$subject  = mysql_result($result, 0, "subject");
			$deals_id = mysql_result($result, 0, "deals_id");

			$deals_id = substr($deals_id, 1);
			$deals_id = substr($deals_id, 0, -1);
			$deals_id_exp = explode(",", $deals_id);

				$headers = 'MIME-Version: 1.0'."\r\n";
				$headers .= 'Content-type: text/html; charset=UTF-8'."\r\n";
				$headers .= "From: ".$Company_name."<admin@".$Company_name.">\r\n";

				// --- Start of html --- //
				$body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml" dir="rtl">
				<head>
				 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				 <style>
				  body { font-family: "Arial", "Arial (Hebrew)", "David (Hebrew)", "Courier New (Hebrew)"; font-size:12px; font-weight:normal; padding:0px; margin:0px; color:#000; direction:rtl; }
				  div,table,tr,td { direction:rtl; }
				 </style>
				</head>
				 <body dir="rtl"><center>
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
					//$deal_max_buyers	= mysql_result($result,0,"deal_max_buyers");
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
					//$deal_client_id	= mysql_result($result,0,"deal_client_id");

					// --- You save --- //
						$you_save			= $deal_reg_price-$deal_our_price;
						$you_save_avr		= 100-(($deal_our_price/$deal_reg_price)*100);
						$you_save_avr_exp	= explode(".", $you_save_avr);
						$you_save_avr		= $you_save_avr_exp[0];

					$body = ''.$body.'
					  <table width="700" cellpadding="0" cellspacing="0" style="border:1px solid '.bg_color.'; border-radius:4px; -moz-border-radius:4px;">
					   <tr>
						<td align="right" valign="top">
						 <img src="http://'.$Company_name.'/products/'.$deal_image.'" width="200" height="178">
						 <div style="background-color:'.bg_color.'; font-weight:bold; padding:10px; text-align:center;"><a href="http://'.$Company_name.'/deal.php?id='.$deal_id.'" style="color:#fff; font-weight:bold; font-size:15px;">כניסה לדיל!</a></div>
						</td>
						<td align="right" valign="top">
						 <div style="background-color:#7ab435; font-weight:bold; padding:10px; font-size:14px;">'.$deal_name.'</div>
						 <table>
						  <tr>
						   <td><div style="background-color:'.bg_color.'; font-weight:bold; padding:10px; font-size:14px;">מחיר שלנו: '.$deal_our_price.' ₪</div></td>
						   <td><div style="background-color:'.color2.'; font-weight:bold; padding:10px; font-size:14px;">שווי: '.$deal_reg_price.' ₪</div></td>
						   <td><div style="background-color:'.color2.'; font-weight:bold; padding:10px; font-size:14px;">חסכון: '.$you_save_avr.' %</div></td>
						   <td><div style="background-color:'.color2.'; font-weight:bold; padding:10px; font-size:14px;">הנחה: '.$you_save.' ₪</div></td>
						  </tr>
						 </table>
						 <div style="padding:15px;">'.strip_tags($deal_text_1).'</td>
					   </tr>
					  </table>
					  <div style="padding-top:10px;">
					';

				}

				// --- Footer for the mail --- //
				$body = ''.$body.'
				 להסרה מרשימת התפוצה - <a href="http://'.$Company_name.'/remove_me.php?email='.test_mail.'">לחצו כאן</a>
				 </center></body>
				</html>';

				// --- Send mail function --- //
				mail(test_mail, '=?UTF-8?B?'.base64_encode($subject).'?=', $body, $headers);
				mail("rtb@impala.co.il", '=?UTF-8?B?'.base64_encode($subject).'?=', $body, $headers);
				echo "<script>alert('הבדיקה נשלחה בהצלחה!');</script>";
		}

		// --- Newsletter is not exsist\not pending --- //
		else
		{
			echo "<script>alert('ניתן לשלוח דוגמא רק לדילים ממתינים..');</script>";
		}

		echo '<script type="text/javascript">window.location = "9_send_newsletter.php"</script>';

	closesql();

?>