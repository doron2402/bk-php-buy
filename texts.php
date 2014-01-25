<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! texts ! ..                                                                 *
*********************************************************************************  */

	include "sql.php";

	$text_id = $HTTP_GET_VARS['id'];

	opensql();
		
		$result = mysql_query("SELECT * FROM `Coupons_Texts` WHERE `text_id`='".$text_id."'");
		$text_exsist  = mysql_num_rows($result);
		
		/* -----------------------------
		-------- text not exsist -------
		----------------------------  */
		if ($text_exsist == 0)
			echo '<script type="text/javascript">window.location = "/"</script>';

		/* -----------------------------------
		-------- show text information -------
		----------------------------------  */
		else
		{
			$meta_title			= mysql_result($result, 0, "text_meta_title");
			$meta_description	= mysql_result($result, 0, "text_meta_description");
			$meta_keywords		= mysql_result($result, 0, "text_meta_keywords");
			$text_content		= mysql_result($result, 0, "text_content");
		}

	closesql();

	include "header.php";
	echo '<div style="padding:20px 30px 10px 40px;">'.$text_content.'</div>';
	include "footer.php"; 
	
?>