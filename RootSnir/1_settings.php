<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! seo pages ! ..                                                           *
*********************************************************************************  */

	// ------------- // 
	// -- defines -- //
	// ------------- // 
	$color = 1;
	
	// -------------- // 
	// -- includes -- //
	// -------------- // 
	include "header.php";
	include "right_menu.php";
	include "main_menu.php";

	opensql();

		// --------------------------------- //
		// -------- Select from SQL -------- //
		// --------------------------------- //
		$result = mysql_query("SELECT * FROM `Coupons_Titles` ORDER BY `text_id` ASC");
		$total_texts  = mysql_num_rows($result);
		for ($i=0;$i<$total_texts;$i++)
		{
			$text_id[$i]	= mysql_result($result, $i, "text_id");
			$text_name[$i]	= mysql_result($result, $i, "text_name");
		}

	closesql();

?>

	 <div class="content-box column-left1">		
	  
	  <!-- top menu -->
	  <div class="content-box-header">
	   <h3>טקסטים באתר</h3>
	   <ul class="content-box-tabs">
	    <li><a class="various" href="1_settings_add.php">הוסף טקסט חדש</a></li>
	   </ul>
	  </div><!-- end of top menu -->

	   <div class="content-box-content">
	    <div class="tab-content default-tab">
		 <table>
		  <tr>
		   <td>id</td>
		   <td>שם</td>
		   <td>עריכה</td>
		  </tr>
		  <!-- show pages -->
		  <?
		   for ($i=0;$i<$total_texts;$i++)
		   {
		 	echo '
			<tr>
			 <td>'.$text_id[$i].'</td>
			 <td>'.$text_name[$i].'</td>
			 <td><a class="various" href="1_settings_edit.php?id='.$text_id[$i].'"><img src="resources/images/icons/pencil.png" border="0"></a></td>
			</tr>
			';
		   }
		  ?>
		  </table><!-- end of show pages -->
	  </div>
	 </div>
	</div>

<? include "footer.php"; ?>