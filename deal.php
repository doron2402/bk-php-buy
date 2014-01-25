<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! specific deal ! ..                                                         *
*********************************************************************************  */

	include "sql.php";

	/* ---------------------------
	-------- get deal id ---------
	---------------------------  */
	$deal_now = $HTTP_GET_VARS['id'];

	opensql();
		$result				= mysql_query("SELECT * FROM `Coupons_Deals` WHERE `deal_id`='".$deal_now."'");
		$deal_ex			= mysql_num_rows($result);
		
			/* -------------------------------
			-------- deal not exsist ---------
			------------------------------  */
			if ($deal_ex == 0) echo '<script type="text/javascript">window.location = "/"</script>';

		$meta_title			= mysql_result($result,0,"deal_name");
		$meta_keywords		= mysql_result($result,0,"deal_name");
		$meta_description	= mysql_result($result,0,"deal_name");
	closesql();


	/* -------------------------
	-------- show deal ---------
	-------------------------  */
	include "header.php";
	opensql();
		show_deal($HTTP_GET_VARS['id']);
	closesql();
	include "footer.php";
	
?>