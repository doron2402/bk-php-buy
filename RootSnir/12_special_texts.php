<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! special texts ! ..                                                         *
*********************************************************************************  */

	// ------------- // 
	// -- defines -- //
	// ------------- // 
	$color = 12;
	
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
		$result = mysql_query("SELECT * FROM `Coupons_Special_Texts` ORDER BY `id` ASC");
		$total_texts  = mysql_num_rows($result);
		for ($i=0;$i<$total_texts;$i++)
		{
			$text_id[$i]	= mysql_result($result, $i, "id");
			$text_name[$i]	= mysql_result($result, $i, "name");
		}

	closesql();

?>

	 <div class="content-box column-left1">		
	  
	  <!-- top menu -->
	  <div class="content-box-header">
	   <h3>תכנים מיוחדים</h3>
	   <ul class="content-box-tabs">
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
			 <td><a class="various" href="12_special_texts_edit.php?id='.$text_id[$i].'"><img src="resources/images/icons/pencil.png" border="0"></a></td>
			</tr>
			';
		   }
		  ?>
		  </table><!-- end of show pages -->
	  </div>
	 </div>
	</div>

<? include "footer.php"; ?>