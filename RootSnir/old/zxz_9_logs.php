<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! logs page ! ..                                                             *
*********************************************************************************  */

	// ------------- //
	// -- defines -- //
	// ------------- //
	$color = 9;
	define('logs_per_page', '50');

	// includes
	include "header.php";
	include "right_menu.php";
	include "main_menu.php";

	if ($admin == 1) {
		opensql();


	// ------------------------------- //
	// --- bg colors for operators --- //
	// ------------------------------- //
	$bg_for_user[0] = 'background-color:#00aeff;';
	$bg_for_user[1] = 'background-color:#ff9000';
	$bg_for_user[2] = 'background-color:#ff005a; color:#ffffff';

	// ------------ //
	// --- page --- //
	// ------------ //
	$page = $HTTP_GET_VARS['page'];
		if ($page == NULL)
			$page = 1;

	// ------------------ //
	// --- show pages --- //
	// ------------------ //
	function show_pages($total,$page)
	{
		if ($total != NULL)
		{ 
			echo '<div style="padding-top:10px;"></div><center><div class="pagination">';
				for ($i=1;$i<=$total;$i++)
				{
					if ($i == $page) echo '<a href="zxz_8_logs.php?page='.$i.'" class="number current">'.$i.'</a>';
					else			 echo '<a href="zxz_8_logs.php?&page='.$i.'" class="number">'.$i.'</a>';
					echo "\n";
				}
			echo '</div><div style="padding-top:10px;"></div></center>';
		}
	}

	// ------------------------------------ //
	// --- generate counter of products --- //
	// ------------------------------------ //
	function generate_counter($sql_line)
	{
		$count_now = str_replace("SELECT * FROM ", "SELECT COUNT(*) FROM ", $sql_line); 
			$count_now = mysql_query($count_now);
				$count_now = mysql_fetch_array($count_now);
					$count_now = $count_now[0];
		return $count_now;
	}

	// ------------------------- //
	// -- time between logs -- //
	// ------------------------- //
	function generate_times($today, $added)
	{
		if ($today == $added) $time_before_days = "<b>מהיום</b>";
		else
		{
			$today_a = strtotime($today);			$added_a = strtotime($added);
			$time_before = $today_a - $added_a;		$time_before1 = $time_before/86400;
			$time_before1 = explode(".", $time_before1);
			$time_before1 = $time_before1[0];
			if ($time_before1 == 1) $time_before_days = "<b>אתמול</b>";
			else $time_before_days = "לפני ".$time_before1." ימים";
		}
		return $time_before_days;
	}

	$sql_line			= "SELECT * FROM `logs` ORDER BY `id` DESC";
	$count_now			= generate_counter($sql_line);

?>

     <div class="content-box column-left1">		
      <div class="content-box-header"><h3>לוגים במערכת</h3></div>
	 <div class="content-box-content">
	
	 <table dir="rtl">
	  <!-- first tr -->
	   <tr height="15">
		<td style="text-align:right;" width="100"># מספר</td>
		<td style="text-align:right;" width="150">תאריך</td>
		<td style="text-align:right;" width="100">שעה</td>
		<td style="text-align:right;" width="100">ע"י</td>
		<td style="text-align:right;">תיאור</td>
	    </tr>

		<?
		// -------------------- //
		// --- sql by pages --- //
		// -------------------- //
		if (logs_per_page < $count_now)
		{
		 $total_pages_t = ($count_now/logs_per_page)+1;
		 $total_pages_exp = explode(".", $total_pages_t);
		 $total_pages = $total_pages_exp[0];
		 if ($page == 1)	$start_for_sql = 0;
		 else				$start_for_sql = ($page-1)*logs_per_page;
		 $result = mysql_query("$sql_line LIMIT ".$start_for_sql.",".logs_per_page.";");
		}
		else $result = mysql_query($sql_line);

		$count = mysql_num_rows($result);
		for ($i=0;$i<$count;$i++)
		{
		 $id			= mysql_result($result,$i,"id");
		 $day			= mysql_result($result,$i,"day");
		 $hour			= mysql_result($result,$i,"hour");
		 $operator		= mysql_result($result,$i,"operator");
		 $description	= mysql_result($result,$i,"description");
	
		 $date_me = explode("-", $day);
		 $date_check = "".$date_me[1]."-".$date_me[0]."-20".$date_me[2]."";
		 $time_between = generate_times(date("d-m-Y"), $date_check);

		 $color_of_operator = 0;
		 for ($q=0;$q<total_users;$q++)
		 {
			 if ($operator == $user_login[$q])
				 $color_of_operator = $q;
		 }

		 echo '
		 <tr dir="rtl">
		  <td style="text-align:right;">'.$id.'</td>
		  <td style="text-align:right;">'.$day.' ('.$time_between.')</td>
		  <td style="text-align:right;">'.$hour.'</td>
		  <td style="text-align:right; '.$bg_for_user[$color_of_operator].'">'.$operator.'</td>
		  <td style="text-align:right;">'.$description.'</td>
		</tr>';
	   } ?>

      </table>
     </div></div>

	<? 
	 // ------------------- //
	 // --- sql parsing --- //
	 // ------------------- //
	 show_pages($total_pages, $page); 
	?>

<? closesql(); } include "footer.php"; ?>