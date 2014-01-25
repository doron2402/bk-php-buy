<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! xdeals.co.il ! ..                                                          *
*********************************************************************************  */

	// defines
	$color = 7;
	
	// includes
	include "header.php";
	include "right_menu.php";
	include "main_menu.php";
	if ($admin == 1) {

		opensql();
		
		// include for xdeals
		include "zxz_7_xdeals_functions.php";
		add_new_deal($HTTP_GET_VARS['add']);
		
		// check for status
		$st = $HTTP_GET_VARS['status'];
		if ($st == NULL) $st = 1;

		$total_orders = check_counters();

?>

     <div class="content-box column-left1">		
      <div class="content-box-header">
	   <h3>מערכת Xdeals</h3>
	   <h3><A href="?add=1">הוסף דיל חדש</a></h3>
	  <ul class="content-box-tabs">
       <li><a href="?status=1"<? if ($st == "1") echo ' class="default-tab" style="color:#0084ff; font-weight:bold;"'; ?>>דילים פעילים (<? echo $total_orders[0]; ?>)</a></li>
       <li><a href="?status=2"<? if ($st == "2") echo ' class="default-tab" style="color:#0084ff; font-weight:bold;"'; ?>>דילים קודמים (<? echo $total_orders[1]; ?>)</a></li>
       <li><a href="?status=0"<? if ($st == "0") echo ' class="default-tab" style="color:#0084ff; font-weight:bold;"'; ?>>דילים ממתינים (<? echo $total_orders[2]; ?>)</a></li>
      </ul>
	  </div>
	 <div class="content-box-content">
	
		<!-- style -->
		<style>
			#preview{
			position:absolute;
			border:1px solid #ccc;
			background:#333;
			padding:2px;
			display:none;
			color:#fff;
			float:right;
			}
		</style>
		<script src="images/main.js" type="text/javascript"></script>

	<table>
	 <tr>
	  <td>id</td>
	  <td>active</td>
	  <td style="text-align:right;">דיל</td>
	  <td>עלות</td>
	  <td>מחיר רגיל</td>
	  <td>xdeals</td>
	  <td>רווח</td>
	  <td>תאריך סיום</td>
	  <td>buyers</td>
	  <td>עדכן</td>
	 </tr>

	 <?

			$result = mysql_query("SELECT * FROM `Xdeals` WHERE active='".$st."' ORDER BY `id` DESC;");
			$exsist = mysql_num_rows($result);
			for ($i=0;$i<$exsist;$i++)
			{
				$active			= mysql_result($result,$i,"active");
				if ($active == 1) $active_icon = 'tick_circle.png';
				if ($active == 2) $active_icon = 'cross.png';
				if ($active == 0) $active_icon = 'cross.png';

				$id				= mysql_result($result,$i,"id");
				$revah			= mysql_result($result,$i,"our_price")-mysql_result($result,$i,"rprice");
				
				$today			= mysql_result($result,$i,"end_date");
				$today_exp		= explode("-", $today);
				$today			= "".$today_exp[1]."-".$today_exp[0]."-20".$today_exp[2]."";
				
				if ($active == 1) $date_to_end	= 'בעוד '.generate_times($today, date("d-m-20y")).' ימים';
				else			  $date_to_end = '';

				echo '
				<tr>
				 <td>'.$id.'</td>
				 <td><img src="resources/images/icons/'.$active_icon.'"></td>
				 <td style="text-align:right;"><a rel="http://www.redpoint.co.il/products/'.mysql_result($result,$i,"image").'" class="preview" style="color:#000000; text-align:right;">'.mysql_result($result,$i,"deal_name").'</a></td>
				 <td>₪'.mysql_result($result,$i,"rprice").'</td>
				 <td>₪'.mysql_result($result,$i,"reg_price").'</td>
				 <td>₪'.mysql_result($result,$i,"our_price").'</td>
				 <td><b style="color:red;">₪'.$revah.'</b></td>
				 <td>'.$date_to_end.'';
				 if ($date_to_end != '') echo '<a class="various_small" href="zxz_7_xdeals_expired.php?id='.$id.'"><img src="resources/images/icons/pencil.png" border="0"></a>';
				 echo '</td>
				 <td>
				  '.mysql_result($result,$i,"buyers").' 
				  <a class="various_small" href="zxz_7_xdeals_buyers.php?id='.$id.'"><img src="resources/images/icons/pencil.png" border="0"></a>
				 </td>
				 <td><a class="various" href="zxz_7_xdeals_edit.php?id='.$id.'"><img src="resources/images/icons/pencil.png" border="0"></a></td>
                </tr>
				';
			}

		closesql();
	 ?>

	 </table>
	</div>
   </div>

<?
	} include "footer.php";
?>