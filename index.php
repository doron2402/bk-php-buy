<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! index ! ..                                                                *
*********************************************************************************  */

	include_once 'sql.php';
	$deal_now = 'main';
	opensql();
	/* ---------------------------
	-------- get deal id ---------
	---------------------------  */
		$result = mysql_query("SELECT * FROM `Coupons_Titles` WHERE `text_id`='1'");
		$meta_title			= mysql_result($result, 0, "text_meta_title");
		$meta_description	= mysql_result($result, 0, "text_meta_description");
		$meta_keywords		= mysql_result($result, 0, "text_meta_keywords");
	closesql();

	/* -------------------------
	-------- show deal ---------
	-------------------------  */

	define('this_is_index', 1);
	include "header.php";
	opensql();
		show_deal("main");
	closesql();
	include "footer.php";
	
?>