<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! check user function ! ..                                                   *
*********************************************************************************  */

	// ----- Users - config here ----- //

	define('total_users', 2);
	
	$user_login[0] = 'snirshi';
	$password_login[0] = 'f2be730c0e03f3a8e470931966f89b1d';
	$user_level[0] = '1';

	$user_login[1] = 'shisnir';
	$password_login[1] = 'f2be730c0e03f3a8e470931966f89b1d';
	$user_level[1] = '1';

	$redirect_when_login = '/RootSnir/0_index.php';
	$redirect_when_no_success = '/RootSnir';

	// ----- Start code ----- //

		// ----- login code ----- //
		if ($login == 1)
		{
			$flag = 0;
			for ($i=0;$i<total_users;$i++)
			{
				if ($flag == 0)
				{
					if (($user_check == $user_login[$i]) && ($pass_check_md5 == $password_login[$i]))
					{
						$flag = 1;
						setcookie("user", $user_check, 0);
						setcookie("pass", $pass_check, 0);
						header ("Location: ".$redirect_when_login."");
					}
				}
			}
		}

		// ----- check user ----- //
		else
		{
			
			$user_check = $_COOKIE['user'];
			$pass_check = md5($_COOKIE['pass']);

			$flag = 0;
			for ($i=0;$i<total_users;$i++)
			{
				if ($flag == 0)
				{
					if (($user_check == $user_login[$i]) && ($pass_check == $password_login[$i]))
					{
						$flag = 1;
						$admin = $user_level[$i];
					}
				}
			}
			
			// ----- index page ----- //
			if ($index_page == 1)
			{
				if ($flag == 1)
					header ("Location: ".$redirect_when_login."");
			}
			// ----- all pages ----- //
			else
			{
				if ($flag == 0)
					header ("Location: ".$redirect_when_no_success."");
			}
		}
?>