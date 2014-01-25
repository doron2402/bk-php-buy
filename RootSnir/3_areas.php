<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! areas ! ..                                                                 *
*********************************************************************************  */

	// ------------- // 
	// -- defines -- //
	// ------------- // 
	$color = 3;
	
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
		$result = mysql_query("SELECT * FROM `Coupons_Areas` ORDER BY `area_id` ASC");
		$total_areas  = mysql_num_rows($result);
		for ($i=0;$i<$total_areas;$i++)
		{
			$area_id[$i]	= mysql_result($result, $i, "area_id");
			$area_name[$i]	= mysql_result($result, $i, "area_name");
		}

	closesql();

?>

	 <div class="content-box column-left1">		
	  
	  <!-- top menu -->
	  <div class="content-box-header">
	   <h3>אזורים במערכת</h3>
	   <ul class="content-box-tabs">
	    <li><a class="various_small" href="3_areas_add.php">הוסף איזור חדש</a></li>
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
		  <!-- shipping methods -->
		  <?
		   for ($i=0;$i<$total_areas;$i++)
		   {
		 	echo '
			<tr>
			 <td>'.$area_id[$i].'</td>
			 <td>'.$area_name[$i].'</td>
			 <td><a class="various_small" href="3_areas_edit.php?id='.$area_id[$i].'"><img src="resources/images/icons/pencil.png" border="0"></a></td>
			</tr>
			';
		   }
		  ?>
		  </table><!-- end of shipping methods -->
	  </div>
	 </div>
	</div>

<? include "footer.php"; ?>