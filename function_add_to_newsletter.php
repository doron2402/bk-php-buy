<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! add to newsletter  ! ..                                                    *
*********************************************************************************  */

	// Check for valid email function
	function checkEmail($email)
	{
	  if( !preg_match( "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email))
		return false;
	return true;
	}

	if ($_POST['subscribe'] == "1")
	{
		
		$email = $_POST['email'];
		$email = strtolower($email);

		// step 1 - check valid
		$check_valid = checkEmail($email);
		if ($check_valid == "1")
		{
			opensql(); 
			
				// step 2 - check if in list
				$result = mysql_query("SELECT * FROM `Coupons_Newsletter` WHERE `newsletter_email`='".$email."' LIMIT 1;");
				$in_list = mysql_num_rows($result);
				if ($in_list == 1)
				{
					// step 2 - error - already in list
					echo "<script>alert('כתובת המייל שהזנת נמצאת במאגר.');</script>";
				}
				else
				{
					$result = mysql_query("SELECT * FROM `Coupons_Newsletter` WHERE `newsletter_ip`='".$_SERVER['REMOTE_ADDR']."' AND `newsletter_date`='".date("d-m-Y")."' LIMIT 3;");
					$ips = mysql_num_rows($result);
					// step 3 - check count of ips
					if ($ips == 3)
					{
						// step 3 error - 3 ips already
						echo "<script>alert('לא ניתן להוסיף אותך לרשימת התפוצה שלנו. אנא נסה שנית במועד מאוחר יותר.');</script>";
					}
					else
					{
						// success! add the mail to db.

						mysql_query("INSERT INTO `Coupons_Newsletter` VALUES ( NULL, '".$_SERVER['REMOTE_ADDR']."', '1', '".date("d-m-Y")."', '".date("G:i:s")."', '".$email."');");

							mysql_query("OPTIMIZE TABLE `Coupons_Newsletter`");
							mysql_query("REPAIR TABLE `Coupons_Newsletter`");
							mysql_query("ANALYZE TABLE `Coupons_Newsletter`");

						echo "<script>alert('נוספת בהצלחה לרשימת התפוצה שלנו.');</script>";
					}
				}
			closesql();
		}
		else // step 1 - not valid
			echo "<script>alert('כתובת האימייל שהזנת אינה תקינה.');</script>";

	}

?>