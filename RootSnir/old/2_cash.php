<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! cash page ! ..                                                            *
*********************************************************************************  */

	// --------------- //
	// --- defines --- //
	// --------------- //
	$color = 2;
	define('orders_per_page', '100');

	// ---------------- //
	// --- includes --- //
	// ---------------- //
	include "header.php";
	include "right_menu.php";
	include "main_menu.php";

	// date for orders
	$date_tab = $HTTP_GET_VARS['date'];
		if ($date_tab == NULL) $date_tab = 'all';
	// pages for orders
	$page = $HTTP_GET_VARS['page'];
		if ($page == NULL) $page = 1;

	// ----------------- //
	// --- functions --- //
	// ----------------- //
	opensql();
	include "2_functions.php";

					show_div($date_tab);
		$sql_line	 = get_sql_line($date_tab);
		$count_now	 = str_replace("SELECT * FROM ", "SELECT COUNT(*) FROM", $sql_line); 
			$count_now	 = mysql_query($count_now); $count_now = mysql_fetch_array($count_now); $count_now = $count_now[0];
		$result_array = generate_results($page, $count_now);
						top_navigator($date_top_text,$result_array, $count_now);

?>
	
			<table dir="rtl">
			 <!-- first tr -->
			 <tr height="15">
			  <td style="text-align:right;" width="80"># מספר</td>
			  <td style="text-align:right;" width="170">תאריך</td>
			  <td style="text-align:right;">תיאור</td>
			  <td style="text-align:right;" width="100">סכום</td>
			  <td style="text-align:right;" width="60">נוסף ע"י</td>
			  <td style="text-align:right;" width="30">עריכה</td>
			 </tr>
			 <!-- end of first tr -->

			<?
			// generate sql line
			if (orders_per_page < $count_now)
			{
				$total_pages_t = ($count_now/orders_per_page)+1;
				$total_pages_exp = explode(".", $total_pages_t);
				$total_pages = $total_pages_exp[0];
				if ($page == 1)	$start_for_sql = 0;
				else			$start_for_sql = ($page-1)*100;
				$result = mysql_query("$sql_line LIMIT ".$start_for_sql.",".orders_per_page.";");
			}
			else $result = mysql_query($sql_line);

			// parsing order from db..
			$count = mysql_num_rows($result);
			for ($i=0;$i<$count;$i++)
			{
				// results from db..
				$id				= mysql_result($result,$i,"id");
				$date			= mysql_result($result,$i,"date");
				$total			= mysql_result($result,$i,"total");
				$description	= mysql_result($result,$i,"description");
				$by				= mysql_result($result,$i,"by");

					// date for order 
					$date_me = explode("-", $date);
					$date_check = "".$date_me[1]."-".$date_me[0]."-20".$date_me[2]."";
						$time_between = generate_times(date("d-m-Y"), $date_check);

			?>
			 <tr dir="rtl">
			  <td style="text-align:right;"><? echo $id; ?></td>
			  <td style="text-align:right;"><? echo $date; ?> (<? echo $time_between; ?>)</td>
			  <td style="text-align:right;"><? echo $description; ?></td>
			  <td style="text-align:right;">₪<? echo $total; ?></td>
			  <td style="text-align:right;"><? echo $by; ?></td>
			  <td style="text-align:right;"><a class="various_medium" href="2_cash_edit.php?id=<? echo $id; ?>"><img src="resources/images/icons/pencil.png" border="0"></a></td>
			 </tr>
			<? } closesql(); ?>
			</table>

	<!-- show pages -->
	<? show_pages($total_pages, $page,$date_tab); ?>
	<!-- end of show pages -->

   </div>
  </div>
 </div>
</div>

<? include "footer.php"; ?>