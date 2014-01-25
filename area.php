<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! area ! ..                                                                *
*********************************************************************************  */

	include "sql.php";

	$area_now	= $HTTP_GET_VARS['id'];

	opensql();

		/* -------------------------------
		--------- Get area name ----------
		------------------------------- */
		$result = mysql_query("SELECT * FROM `Coupons_Areas` WHERE `area_id`='".$area_now."'");
			$area_name			= mysql_result($result, 0, "area_name");

		/* -----------------------------------------------
		--------- Title, Description & Keywords ----------
		-------------------------------------------------- */
		$result = mysql_query("SELECT * FROM `Coupons_Titles` WHERE `text_id`='5'");
			$meta_title			= str_replace("%AREA%", $area_name, mysql_result($result, 0, "text_meta_title"));
			$meta_description	= str_replace("%AREA%", $area_name, mysql_result($result, 0, "text_meta_description"));
			$meta_keywords		= str_replace("%AREA%", $area_name, mysql_result($result, 0, "text_meta_keywords"));

		/* --------------------------------------
		--------- Generate deal number ----------
		--------------------------------------- */
		$result		= mysql_query("SELECT * FROM `Coupons_Deals` WHERE `deal_areas` LIKE '%,".$area_now.",%' AND `deal_status`='1' LIMIT 1;");
		$deal_ex	= mysql_num_rows($result);
		if ($deal_ex != 0)
			$deal_now	= mysql_result($result,0,"deal_id");

	closesql();

	include "header.php";

	/* ---------------------------------------
	--------- if no deal in the area ---------
	--------------------------------------- */
	if ($deal_ex == 0)
	{
		opensql();

			$result = mysql_query("SELECT * FROM `Coupons_Special_Texts` WHERE `id`='5' LIMIT 1;");
				$special_con	= mysql_result($result, 0, "content");
					echo $special_con;

		closesql();
	}
	
	/* ---------------------------
	--------- show deal  ---------
	---------------------------- */
	else
	{
		opensql();
			show_deal($deal_now);
		closesql();
	}
	include "footer.php";
	
?>