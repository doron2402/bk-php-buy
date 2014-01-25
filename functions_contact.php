<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! Functions for contact ! ..                                                 *
*********************************************************************************  */

	$contact_id = $HTTP_GET_VARS['id'];

	opensql();
		
		$result = mysql_query("SELECT * FROM `Coupons_Texts_Contact` WHERE `contact_id`='".$contact_id."'");
		$text_exsist  = mysql_num_rows($result);
		
		/* ----------------------------------
		-------- contact not exsist ---------
		---------------------------------  */
		if ($text_exsist == 0)
			echo '<script type="text/javascript">window.location = "/"</script>';
		
		/* ---------------------------------
		-------- get data from SQL ---------
		--------------------------------  */
		else
		{
			$meta_title			= mysql_result($result, 0, "contact_meta_title");
			$meta_description	= mysql_result($result, 0, "contact_meta_description");
			$meta_keywords		= mysql_result($result, 0, "contact_meta_keywords");

			$contact_top_content		= mysql_result($result, 0, "contact_top_content");
			$contact_footer_content		= mysql_result($result, 0, "contact_footer_content");

			$contact_email = mysql_result($result, 0, "contact_email");

			/* -------------------------
			-------- send mail ---------
			-------------------------  */
			if ($_POST['set'] == "1")
			{

				$subject = 'פנייה חדשה דרך האתר.';
				$headers = 'MIME-Version: 1.0'."\r\n";
				$headers .= 'Content-type: text/html; charset=UTF-8'."\r\n";
				$headers .= "From: ".$Company_name."<admin@".$Company_name.">\r\n";

				$body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml" dir="rtl"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head><body>
				<table>
				 <tr><td>שם</td>
				 <td>'.$_POST['name'].'</td></tr>
				 <tr><td>טלפון</td>
				 <td>'.$_POST['phone'].'</td></tr>
				 <tr><td>אימייל</td>
				 <td>'.$_POST['email'].'</td></tr>
				 <tr><td>הודעה</td>
				 <td>'.$_POST['msg'].'</td></tr>
				</table>
				</body></html>';

				mail($contact_email, '=?UTF-8?B?'.base64_encode($subject).'?=', $body, $headers);
				/*
				mail("rtb@impala.co.il", '=?UTF-8?B?'.base64_encode($subject).'?=', $body, $headers);
				*/
				echo "<script>alert('הטופס נשלח בהצלחה! נשוב אלייך בהקדם..');</script>";
			}
		}

	closesql();
	include "header.php";

?>