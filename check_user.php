<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! Check for user details ! ..                                                *
*********************************************************************************  */

	/* ---------------------------
	-------- Get Cookies ---------
	---------------------------  */

	$Member_mail = $_COOKIE['mail'];
	$Member_pass = $_COOKIE['pass'];
	$Member_login = 0;

	/* -----------------------------
	-------- if cookie set ---------
	-----------------------------  */
	if ($Member_pass != NULL)
	{

		/* -----------------------------
		-------- generate md5 ----------
		-----------------------------  */
		$Member_pass_md5 = md5($Member_pass);

			opensql();

				$result = mysql_query("SELECT * FROM `Coupons_Clients` WHERE (`client_password`='".$Member_pass."' OR `client_password`='".$Member_pass_md5."') AND `client_email`='".$Member_mail."' LIMIT 1;");
				$if_member = mysql_num_rows($result);
				
				/* ---------------------------------
				-------- if member exsist ----------
				------------------------------------  */
				if ($if_member == 1)
				{
					$Member_login = 1;

					$client_id			= mysql_result($result, 0, "client_id");
					$client_firstname	= mysql_result($result, 0, "client_firstname");
					$client_lastname	= mysql_result($result, 0, "client_lastname");
					$client_password	= mysql_result($result, 0, "client_password");
					$client_email		= mysql_result($result, 0, "client_email");
					$client_city		= mysql_result($result, 0, "client_city");
					$client_address		= mysql_result($result, 0, "client_address");
					$client_bait		= mysql_result($result, 0, "client_bait");
					$client_dira		= mysql_result($result, 0, "client_dira");
					$client_phone		= mysql_result($result, 0, "client_phone");
					$client_cellphone	= mysql_result($result, 0, "client_cellphone");
				}

			closesql();
	}

?>