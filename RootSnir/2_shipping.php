<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! shipping page ! ..                                                         *
*********************************************************************************  */

	// ------------- // 
	// -- defines -- //
	// ------------- // 
	$color = 2;
	
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
		$result = mysql_query("SELECT * FROM `Coupons_Shipping` ORDER BY `shipping_id` ASC");
		$total_shipping  = mysql_num_rows($result);
		for ($i=0;$i<$total_shipping;$i++)
		{
			$shipping_id[$i]	= mysql_result($result, $i, "shipping_id");
			$shipping_name[$i]	= mysql_result($result, $i, "shipping_name");
			$shipping_price[$i] = mysql_result($result, $i, "shipping_price");
		}

	closesql();

?>

	 <div class="content-box column-left1">		
	  
	  <!-- top menu -->
	  <div class="content-box-header">
	   <h3>אפשרויות משלוח</h3>
	   <ul class="content-box-tabs">
	    <li><a class="various_small" href="2_shipping_add.php">הוסף אפשרות משלוח</a></li>
	   </ul>
	  </div><!-- end of top menu -->

	   <div class="content-box-content">
	    <div class="tab-content default-tab">
		 <table>
		  <tr>
		   <td>id</td>
		   <td>שם</td>
		   <td>מחיר</td>
		   <td>עריכה</td>
		  </tr>
		  <!-- shipping methods -->
		  <?
		   for ($i=0;$i<$total_shipping;$i++)
		   {
		 	echo '
			<tr>
			 <td>'.$shipping_id[$i].'</td>
			 <td>'.$shipping_name[$i].'</td>
			 <td>₪'.$shipping_price[$i].'</td>
			 <td><a class="various_small" href="2_shipping_edit.php?id='.$shipping_id[$i].'"><img src="resources/images/icons/pencil.png" border="0"></a></td>
			</tr>
			';
		   }
		  ?>
		  </table><!-- end of shipping methods -->
	  </div>
	 </div>
	</div>

<? include "footer.php"; ?>