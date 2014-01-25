<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! show orders. ! ..                                                            *
*********************************************************************************  */

	// --------------- //
	// --- defines --- //
	// --------------- //
	$color = 1;
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
	// status for orders
	$status_tab = $HTTP_GET_VARS['status'];
		if ($status_tab == NULL) $status_tab = 'all';
	// pages for orders
	$page = $HTTP_GET_VARS['page'];
		if ($page == NULL) $page = 1;

	// ----------------- //
	// --- functions --- //
	// ----------------- //
	include "1_functions.php";
	opensql();
					  top_div($date_tab,$status_tab);
	$sql_line		= geneate_sql_line($_POST['search'], $_POST['string'], $status_tab,$date_tab);
	$count_now		= generate_count_now($sql_line);
	$result_array	= generate_results($page, $count_now);
					  top_navigator($status_top_text, $date_top_text, $result_array, $count_now);
	?>
	
			<table dir="rtl">
			 <!-- first tr -->
			 <tr height="15">
			  <td style="text-align:right;"># מספר</td>
			  <td style="text-align:right;">תאריך ההזמנה</td>
			  <td style="text-align:right;">שם המזמין</td>
			  <td style="text-align:right;">מחיר</td>
			  <? if ($admin == "1") { ?> <td style="text-align:right;">עלות</td>
			  <td style="text-align:right;">רווח</td> <? } ?>
			  <td style="text-align:right;">מצב הזמנה</td>
			  <td style="text-align:right;">הגיע מאתר</td>
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
				else			$start_for_sql = ($page-1)*orders_per_page;
				$result = mysql_query("$sql_line LIMIT ".$start_for_sql.",".orders_per_page.";");
			}
			else $result = mysql_query($sql_line);

			// parsing order from db..
			$count = mysql_num_rows($result);
			for ($i=0;$i<$count;$i++)
			{
				// results from db..
				$id				= mysql_result($result,$i,"id");
				$name			= "".mysql_result($result,$i,"lname")." ".mysql_result($result,$i,"fname")."";
				$tprice			= mysql_result($result,$i,"t_price");
				$cost			= mysql_result($result,$i,"cost");
				$status			= mysql_result($result,$i,"status");
				$site			= mysql_result($result,$i,"site");
				$date			= mysql_result($result,$i,"date");
				
					// date for order 
					$date_me = explode("-", $date);
					$date_check = "".$date_me[1]."-".$date_me[0]."-20".$date_me[2]."";
						$time_between = generate_times(date("d-m-Y"), $date_check);

				// generate color text	
				$color_t = generate_color($status);
			?>
			 <tr dir="rtl">
			  <td style="text-align:right;"><? echo $id; ?></td>
			  <td style="text-align:right;"><? echo $date; ?> (<? echo $time_between; ?>)</td>
			  <td style="text-align:right;"><? echo $name; ?></td>
			  <td style="text-align:right;">₪<? echo $tprice; ?>
					<? if ($admin == "1") { ?> <a class="various_small" href="1_orders_edit_price.php?id=<? echo $id; ?>"><img src="resources/images/icons/pencil.png" border="0"></a> <? } ?>
			  </td>
			  <? if ($admin == "1") { ?> <td style="text-align:right;">₪<? echo $cost; ?></td>
			  <td style="text-align:right;">₪<? echo $tprice-$cost; ?></td> <? } ?>
			  <td style="text-align:right; <? echo $color_t[0]; ?>"><? echo $color_t[1]; ?></td>
			  <td style="text-align:right;"><? echo $site; ?></td>
			  <td style="text-align:right;"><a class="various" href="1_orders_edit.php?id=<? echo $id; ?>"><img src="resources/images/icons/pencil.png" border="0"></a></td>
			 </tr>
			<? } closesql(); ?>
			</table>

	<!-- show pages -->
	<? show_pages($total_pages, $page,$date_tab,$status_tab); ?>
	<!-- end of show pages -->

   </div>
  </div>
 </div>
</div>
<? include "footer.php"; ?>