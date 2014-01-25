<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! send newsletter list ! ..                                                  *
*********************************************************************************  */

	// ------------- // 
	// -- defines -- //
	// ------------- // 
	$color = 9;
	
	// -------------- // 
	// -- includes -- //
	// -------------- // 
	include "header.php";
	include "right_menu.php";
	include "main_menu.php";

	// ---------------------------------- //
	// -- generate time between orders -- //
	// ---------------------------------- //
	function generate_times_future($today, $added)
	{
		if ($today == $added) $time_before_days = "<b>היום</b>";
		else
		{
			$today_a = strtotime($today);			$added_a = strtotime($added);
			$time_before = $today_a - $added_a;		$time_before1 = $time_before/86400;
			$time_before1 = explode(".", $time_before1);
			$time_before1 = $time_before1[0];
			if ($time_before1 == 1) $time_before_days = "<b>מחר</b>";
			else $time_before_days = "בעוד ".$time_before1." ימים";
		}
		return $time_before_days;
	}

	define('per_page', '50');

		// ---------------------- //
		// -------- Page -------- //
		// ---------------------- //
		$page = $HTTP_GET_VARS['page'];
		if ($page == NULL) $page = 1;

		if ($page == 1)	$start_for_sql = 0;
		else			$start_for_sql = ($page-1)*per_page;

	opensql();

		// ------------------------------ //
		// -------- find next id -------- //
		// ------------------------------ //
		$result = mysql_query("SHOW TABLE STATUS LIKE 'Coupons_Send_Newsletter'");
		$row = mysql_fetch_array($result);
		$nextId = $row['Auto_increment'];

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
		$line[0] = "SELECT * FROM `Coupons_Send_Newsletter`";
		$line[1] = "SELECT * FROM `Coupons_Send_Newsletter` WHERE `status`='1'";	// pending
		$line[2] = "SELECT * FROM `Coupons_Send_Newsletter` WHERE `status`='2'";	// sending
		$line[3] = "SELECT * FROM `Coupons_Send_Newsletter` WHERE `status`='3'";	// already sent

		for ($i=0;$i<4;$i++)
		{
			$count_now = str_replace("SELECT * FROM ", "SELECT COUNT(*) FROM ", $line[$i]);
				$count_now = mysql_query($count_now); $count_now = mysql_fetch_array($count_now); $total_orders[$i] = $count_now[0];
					if ($total_orders[$i] == NULL) $total_orders[$i] = 0;
		}

		// ---------------------------------- //
		// -------- generate line   -------- //
		// ---------------------------------- //
		$selected_id = $HTTP_GET_VARS['id'];
			if ($selected_id == 0)
				$selected_id = 1;

			// Pending newsletter..
			if ($selected_id == 1)	$result = mysql_query("SELECT * FROM `Coupons_Send_Newsletter` WHERE `status`='1' ORDER BY `id` DESC LIMIT ".$start_for_sql.", ".per_page."");
			
			// Sending now..
			if ($selected_id == 2)	$result = mysql_query("SELECT * FROM `Coupons_Send_Newsletter` WHERE `status`='2' ORDER BY `id` DESC LIMIT ".$start_for_sql.", ".per_page."");

			// Already sent..
			if ($selected_id == 3)	$result = mysql_query("SELECT * FROM `Coupons_Send_Newsletter` WHERE `status`='3' ORDER BY `id` DESC LIMIT ".$start_for_sql.", ".per_page."");

		// --------------------------------- //
		// -------- Select from SQL -------- //
		// --------------------------------- //
		$total_newsletters  = mysql_num_rows($result);
		for ($i=0;$i<$total_newsletters;$i++)
		{

			$id[$i]				= mysql_result($result, $i, "id");

			$status[$i]			= mysql_result($result, $i, "status");
				if ($status[$i] == "1") { $status_text[$i] = 'ממתין..'; } 
				if ($status[$i] == "2") { $status_text[$i] = 'נשלח כרגע..'; } 
				if ($status[$i] == "3") { $status_text[$i] = 'סיים לשלוח..'; } 

			$deals_id[$i]			= mysql_result($result, $i, "deals_id");
			$subject[$i]			= mysql_result($result, $i, "subject");
			$start_date[$i]			= mysql_result($result, $i, "start_date");
				if ($selected_id == 1)
				{
					$date_between		= generate_times_future($start_date[$i], date("d-m-Y"));
						$start_date[$i]	= ''.$date_between.' -> '.$start_date[$i].'';
				}
				
			$start_hour[$i]			= mysql_result($result, $i, "start_hour");
			$clicks[$i]				= mysql_result($result, $i, "clicks");

			$total_sent[$i]			= mysql_result($result, $i, "total_sent");
			$pending_to_send[$i]	= mysql_result($result, $i, "pending_to_send");

		}

	closesql();

?>

	 <div class="content-box column-left1">		
	  
	  <!-- top menu -->
	  <div class="content-box-header">
	   <h3>שליחת רשימת תפוצה</h3>
	   <h3><A href="9_send_newsletter_edit.php?id=<?=$nextId;?>">הוסף ניוזלטר חדש</a></h3>
	   <ul class="content-box-tabs">
	    <li><a href="?id=1"	<? if ($selected_id == 1) echo ' class="default-tab"'; ?>>ממתינים לשליחה (<?=$total_orders[1];?>)</a></li>
	    <li><a href="?id=2"	<? if ($selected_id == 2) echo ' class="default-tab"'; ?>>נשלח כרגע (<?=$total_orders[2];?>)</a></li>
	    <li><a href="?id=3"	<? if ($selected_id == 3) echo ' class="default-tab"'; ?>>נשלחו (<?=$total_orders[3];?>)</a></li>
	   </ul>
	  </div><!-- end of top menu -->

	   <!-- newslettter list -->
	   <div class="content-box-content">
	    <div class="tab-content default-tab">

          <!-- first tr -->
		  <?
			echo '
		   <table>
		    <tr>
		     <td>id</td>
		     <td>תאריך שליחה</td>
		     <td>נושא</td>';
			 
		     if ($selected_id != 1) // clicks + sent
			  echo '<td>קליקים</td>
		      <td>סה"כ נשלחו</td>';
			 
			 if ($selected_id == 1) // edit + send test
			  echo '<td>שלח אלי בדיקה</td>
		      <td>ערוך</td>';
		     echo '</tr>';
		  ?>
		  <!-- end of first tr -->

		  <!-- show all -->
		  <?
		   for ($i=0;$i<$total_newsletters;$i++)
		   {
		 	echo '
			<tr>
			 <td>'.$id[$i].'</td>
			 <td>'.$start_date[$i].' בשעה: '.$start_hour[$i].'</td>
			 <td>'.$subject[$i].'</td>';
			
			 if ($status[$i] != 1) // show clicks + total sent
			 echo '<td>'.$clicks[$i].'</td>
			 <td>'.$total_sent[$i].'</td>';

			 if ($status[$i] == 1) // edit & send
			 echo '<td><a href="9_send_newsletter_test.php?id='.$id[$i].'">שלח אלי לבדיקה</a></td>
			  <td><a href="9_send_newsletter_edit.php?id='.$id[$i].'">ערוך</a></td>';

			echo '
			</tr>
			';
		   }
		  ?>
		  </table><!-- end of show all -->

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