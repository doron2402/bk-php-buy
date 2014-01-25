<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! Bad - tell him to go back ! ..                                             *
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


	$meta_title			= 'חיוב האשראי לא עבר בהצלחה. אנא נסה שנית.';
	$meta_description	= 'חיוב האשראי לא עבר בהצלחה. אנא נסה שנית.';
	$meta_keywords		= 'חיוב האשראי לא עבר בהצלחה. אנא נסה שנית.';

	include "sql.php";
	include "header.php";


	/* -------------------------------
	--------- Special Texts ----------
	------------------------------- */

	opensql();

		// Data
		$result = mysql_query("SELECT * FROM `Coupons_Special_Texts` WHERE `id`='1' LIMIT 1;");
			$special_con	= mysql_result($result, 0, "content");

				// Replaces
				$special_con	= str_replace("%URL%", "buy.php?id=".$deal_id."", $special_con);
		
		echo $special_con;

	closesql();

include "footer.php"; ?>