<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! newsletter ! ..                                                                 *
*********************************************************************************  */

	// ------------- // 
	// -- defines -- //
	// ------------- // 
	$color = 8;
	
	// -------------- // 
	// -- includes -- //
	// -------------- // 
	include "header.php";
	include "right_menu.php";
	include "main_menu.php";

	define('per_page', '50');

		// ---------------------- //
		// -------- Page -------- //
		// ---------------------- //
		$page = $HTTP_GET_VARS['page'];
		if ($page == NULL) $page = 1;

		if ($page == 1)	$start_for_sql = 0;
		else			$start_for_sql = ($page-1)*per_page;

	opensql();

		// ----------------------------------- //
		// -------- Total Newsletters -------- //
		// ----------------------------------- //
		$count_now = "SELECT COUNT(*) FROM `Coupons_Newsletter`"; 
			$count_now = mysql_query($count_now);
				$count_now = mysql_fetch_array($count_now);
					$count_now = $count_now[0];

		$total_pages = (int)($count_now/per_page)+1;

		// ---------------------------------- //
		// -------- deals counter -------- //
		// ---------------------------------- //
		$line[0] = "SELECT * FROM `Coupons_Newsletter`";
		$line[1] = "SELECT * FROM `Coupons_Newsletter` WHERE `newsletter_status`='1'";
		$line[2] = "SELECT * FROM `Coupons_Newsletter` WHERE `newsletter_status`='2'";

		for ($i=0;$i<3;$i++)
		{
			$count_now = str_replace("SELECT * FROM ", "SELECT COUNT(*) FROM ", $line[$i]);
				$count_now = mysql_query($count_now); $count_now = mysql_fetch_array($count_now); $total_orders[$i] = $count_now[0];
					if ($total_orders[$i] == NULL) $total_orders[$i] = 0;
		}


		// ---------------------------------- //
		// -------- generate line   -------- //
		// ---------------------------------- //
		$selected_id = $HTTP_GET_VARS['id'];
		if (($selected_id != NULL) && ($selected_id != 0))
		{
			// Active newsletters
			if ($selected_id == 1)	$result = mysql_query("SELECT * FROM `Coupons_Newsletter` WHERE `newsletter_status`='1' ORDER BY `newsletter_id` DESC LIMIT ".$start_for_sql.", ".per_page."");
			
			// Deactive newsletters
			else					$result = mysql_query("SELECT * FROM `Coupons_Newsletter` WHERE `newsletter_status`='2' ORDER BY `newsletter_id` DESC LIMIT ".$start_for_sql.", ".per_page."");
		}

		// All newsletters
		else
			$result = mysql_query("SELECT * FROM `Coupons_Newsletter` ORDER BY `newsletter_id` DESC LIMIT ".$start_for_sql.", ".per_page."");

		// --------------------------------- //
		// -------- Select from SQL -------- //
		// --------------------------------- //
		$total_newsletters  = mysql_num_rows($result);
		for ($i=0;$i<$total_newsletters;$i++)
		{
			// id, hour & email
			$newsletter_id[$i]		= mysql_result($result, $i, "newsletter_id");
			$newsletter_hour[$i]	= mysql_result($result, $i, "newsletter_hour");
			$newsletter_email[$i]	= mysql_result($result, $i, "newsletter_email");

			// Date
			$newsletter_date[$i]	= mysql_result($result, $i, "newsletter_date");
				$date_between		= generate_times(date("d-m-Y"), $newsletter_date[$i]);
					$newsletter_date[$i]	= ''.$newsletter_date[$i].' ('.$date_between.')';

			// Status
			$newsletter_status[$i]	= mysql_result($result, $i, "newsletter_status");
				if ($newsletter_status[$i] == 1) $newsletter_status[$i] = '<img src="resources/images/icons/tick_circle.png">';
				else							 $newsletter_status[$i] = '<img src="resources/images/icons/cross.png">';
		}

	closesql();

?>

	 <div class="content-box column-left1">		
	  
	  <!-- top menu -->
	  <div class="content-box-header">
	   <h3>רשימת תפוצה</h3>
	   <ul class="content-box-tabs">
	    <li><a href="?id=0"	<? if ($selected_id == 0) echo ' class="default-tab"'; ?>>כולם (<?=$total_orders[0];?>)</a></li>
	    <li><a href="?id=1"				<? if ($selected_id == 1) echo ' class="default-tab"'; ?>>פעילים (<?=$total_orders[1];?>)</a></li>
	    <li><a href="?id=2"				<? if ($selected_id == 2) echo ' class="default-tab"'; ?>>לא פעילים (<?=$total_orders[2];?>)</a></li>
	   </ul>
	  </div><!-- end of top menu -->

	   <!-- newslettter list -->
	   <div class="content-box-content">
	    <div class="tab-content default-tab">
		 <table>
		  <tr>
		   <td>id</td>
		   <td>סטטוס</td>
		   <td>תאריך</td>
		   <td>שעה</td>
		   <td>אימייל</td>
		  </tr>
		  <!-- show all -->
		  <?
		   for ($i=0;$i<$total_newsletters;$i++)
		   {
		 	echo '
			<tr>
			 <td>'.$newsletter_id[$i].'</td>
			 <td>'.$newsletter_status[$i].'</td>
			 <td>'.$newsletter_date[$i].'</td>
			 <td>'.$newsletter_hour[$i].'</td>
			 <td>'.$newsletter_email[$i].'</td>
			</tr>
			';
		   }
		  ?>
		  </table><!-- end of newslettter list -->

		  <!-- pages -->
		  <div class="pagination">
		  <?
			for ($i=1;$i<=$total_pages;$i++)
			{
				if ($i == $page) echo '<a href="?id='.$selected_id.'&page='.$i.'" class="number current">'.$i.'</a>';
				else			 echo '<a href="?id='.$selected_id.'&page='.$i.'" class="number">'.$i.'</a>';
			}
		  ?>
		  </div>
          <!-- end of pages -->

	  </div>
	 </div>
	</div>

<? include "footer.php"; ?>