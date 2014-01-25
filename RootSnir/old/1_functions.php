<?

/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! order function. ! ..                                                       *
*********************************************************************************  */


	// ---------------------------------- //
	// -- generate time between orders -- //
	// ---------------------------------- //
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

	// ---------------------------- //
	// -- top text for navigator -- //
	// ---------------------------- //
	switch ($date_tab)
	{
		case "all": $date_top_text = 'מכל הזמנים';		break;
		case "1":   $date_top_text = 'מהחודש הנוכחי';	break;
		case "2":   $date_top_text = 'מהחודש הקודם';	break;
		case "3":   $date_top_text = 'לפני חודשיים';	break;
	}

	// ------------------------- //
	// -- top text for status -- //
	// ------------------------- //
	switch ($status_tab)
	{
		case "all": $status_top_text = 'כל ההזמנות';		break;
		case "p":	$status_top_text = 'הזמנות ממתינות';	break;
		case "a":	$status_top_text = 'הזמנות מאושרות';	break;
		case "c":	$status_top_text = 'הזמנות מושלמות';	break;
		case "d":	$status_top_text = 'הזמנות מחוקות';		break;
	}

	// --------------------- //
	// -- count of orders -- //
	// --------------------- //
	function get_count_orders()
	{
		$month[0] = get_sql_line("all", "all");
		$month[1] = get_sql_line("all", "1");
		$month[2] = get_sql_line("all", "2");
		$month[3] = get_sql_line("all", "3");

		for ($i=0;$i<4;$i++)
		{
			$count_now = str_replace("SELECT * FROM ", "SELECT COUNT(*) FROM", $month[$i]); 
				$count_now = mysql_query($count_now); $count_now = mysql_fetch_array($count_now); $total_count[$i] = $count_now[0];
		}

		return $total_count;
	}

	// ------------------ //
	// -- top div code -- //
	// ------------------ //
	function top_div($date_tab,$status_tab)
	{ $totals_counters = get_count_orders(); ?>
	 <div class="content-box column-left1">		
      <div class="content-box-header">
       <h3>מציג הזמנות</h3>
       <ul class="content-box-tabs">
        <li><a href="?date=all&status=<? echo $status_tab; ?>"<? if ($date_tab == "all") echo ' class="default-tab" style="color:#0084ff; font-weight:bold;"'; ?>>כל ההזמנות (<? echo $totals_counters[0]; ?>)</a></li>
        <li><a href="?date=1&status=<? echo $status_tab; ?>"<? if ($date_tab == "1") echo ' class="default-tab" style="color:#0084ff; font-weight:bold;"'; ?>>מהחודש (<? echo $totals_counters[1]; ?>)</a></li>
        <li><a href="?date=2&status=<? echo $status_tab; ?>"<? if ($date_tab == "2") echo ' class="default-tab" style="color:#0084ff; font-weight:bold;"'; ?>>חודש שעבר (<? echo $totals_counters[2]; ?>)</a></li>
        <li><a href="?date=3&status=<? echo $status_tab; ?>"<? if ($date_tab == "3") echo ' class="default-tab" style="color:#0084ff; font-weight:bold;"'; ?>>לפני חודשיים (<? echo $totals_counters[3]; ?>)</a></li>
       </ul>
       <ul class="content-box-tabs" style="width:20%"></ul>
       <ul class="content-box-tabs">
        <li><a href="?date=<? echo $date_tab; ?>&status=all"<? if ($status_tab == "all") echo ' class="default-tab" style="color:#0084ff; font-weight:bold;"'; ?>>כל ההזמנות</a></li>
        <li><a href="?date=<? echo $date_tab; ?>&status=p"<? if ($status_tab == "p") echo ' class="default-tab" style="color:#0084ff; font-weight:bold;"'; ?>>הזמנות ממתינות</a></li>
        <li><a href="?date=<? echo $date_tab; ?>&status=a"<? if ($status_tab == "a") echo ' class="default-tab" style="color:#0084ff; font-weight:bold;"'; ?>>הזמנות מאושרות</a></li>
        <li><a href="?date=<? echo $date_tab; ?>&status=c"<? if ($status_tab == "c") echo ' class="default-tab" style="color:#0084ff; font-weight:bold;"'; ?>>הזמנות מושלמות</a></li>
        <li><a href="?date=<? echo $date_tab; ?>&status=d"<? if ($status_tab == "d") echo ' class="default-tab" style="color:#0084ff; font-weight:bold;"'; ?>>הזמנות מחוקות</a></li>
       </ul>
	   <div class="clear"></div>			
      </div>
	<? }

	// ----------------------- //
	// -- generate sql line -- //
	// ----------------------- //
	function get_sql_line($status_tab,$date_tab)
	{
		if ($date_tab != "all")
		{
			$date_now = date("m-d-y");
			if ($date_tab == 2) $date_now = date("m-d-y", strtotime("-1 month"));
			if ($date_tab == 3) $date_now = date("m-d-y", strtotime("-2 month"));
			$date_exp = explode("-", $date_now);

			$string = '';
			for ($i=1;$i<32;$i++)
			{
				if ($i<10)	$string = ''.$string.'`date`="'.$date_exp[0].'-0'.$i.'-'.$date_exp[2].'" OR ';
				else		$string = ''.$string.'`date`="'.$date_exp[0].'-'.$i.'-'.$date_exp[2].'" OR ';
			}
			$string = substr($string, 0, -3);
		}

		if (($status_tab == NULL) || ($status_tab == "all"))
		{
			if ($date_tab == "all")	$sql_line = "SELECT * FROM `orders` WHERE `status` = 'c' OR `status` = 'a' OR `status` = 'p' ORDER BY id DESC";
			else					$sql_line = "SELECT * FROM `orders` WHERE (".$string.") AND (`status` = 'c' OR `status` = 'a' OR `status` = 'p') ORDER BY id DESC";
		}
		else
		{	
			if ($date_tab == "all")	$sql_line = "SELECT * FROM `orders` WHERE `status` = '".$status_tab."' ORDER BY id DESC";
			else					$sql_line = "SELECT * FROM `orders` WHERE (".$string.") AND `status` = '".$status_tab."' ORDER BY id DESC";
		}

		return $sql_line; 
	}
	
	// ------------------------------- //
	// -- sql by search or regular? -- //
	// ------------------------------- //
	function geneate_sql_line($search, $string, $status_tab,$date_tab)
	{
		if ($search == 1)
			$sql_line = "SELECT * FROM `orders` WHERE `id` = '".$string."' OR `fname` LIKE '%".$string."%' OR `lname` LIKE '%".$string."%' ORDER BY id DESC";

		else $sql_line = get_sql_line($status_tab,$date_tab);
	
		return $sql_line;
	}

	// ------------------------------- //
	// -- total count for navigator -- //
	// ------------------------------- //
	function generate_count_now($sql_line)
	{

		$count_now = str_replace("SELECT * FROM ", "SELECT COUNT(*) FROM", $sql_line); 
			$count_now = mysql_query($count_now); $count_now = mysql_fetch_array($count_now); $count_now = $count_now[0];

		return $count_now;
	}

	// ------------------------------ //
	// -- start & end for sql line -- //
	// ------------------------------ //
	function generate_results($page, $count_now)
	{
		if ($page == 1)
		{
			$array[0] = '1';
			$array[1] = orders_per_page;
			if ($array[1] > $count_now) $array[1] = $count_now;
		}
		else
		{
			$page_results = ($page-1)*orders_per_page;
			$array[0] = $page_results;
			$array[1] = $page_results+orders_per_page;
			if ($array[1] > $count_now) $array[1] = $count_now;
		}

		return $array;
	}

	// ------------------- //
	// -- top navigator -- //
	// ------------------- //
	function top_navigator($status_top_text, $date_top_text, $result_array, $count_now)
	{ ?>

	   <div class="content-box-content">
	    <div class="tab-content default-tab">
		 <div style="padding:15px 20px 0px 20px;">
		  <div style="padding-top:10px;"></div>
		   <form method="post" style="padding:0px; margin:0px;" action="1_orders.php">
		    <input type="hidden" name="search" value="1">
           <table width="100%"><tr>
             <td align="right" style="text-align:right;"><b><? echo $status_top_text; ?> >> <? echo $date_top_text; ?></b></td>
			 <td align="center">
			  חפש הזמנה (מספר או שם)
			   <input type="text" name="string">
			   <input class="button" type="submit" value="חפש!">
			  </form>
			 </td>
             <td align="left">מציג הזמנות <b><? echo $result_array[0]; ?></b> עד <b><? echo $result_array[1]; ?></b> מתוך <b><? echo $count_now; ?></b></td>
            </tr></table>
           <br><br><br>

	<? }

	// ------------------ //
	// -- return color -- //
	// ------------------ //
	function generate_color($status)
	{
		if ($status == "c") { $color_t[0] = 'background-color:#79d1ff;'; $color_t[1] = 'מושלם'; }
		if ($status == "a") { $color_t[0] = 'background-color:#ffc065;'; $color_t[1] = 'מאושר'; }
		if ($status == "d") { $color_t[0] = 'background-color:#bebebe;'; $color_t[1] = 'מחוק'; }
		if ($status == "p") { $color_t[0] = 'background-color:#92df90;'; $color_t[1] = 'ממתין..'; }
		return $color_t;
	}

	// ---------------------- //
	// -- pages for footer -- //
	// ---------------------- //
	function show_pages($total,$page,$date_tab,$status_tab)
	{
		if ($total != NULL)
		{ 
			echo '<div style="padding-top:10px;"></div><center><div class="pagination">';
				for ($i=1;$i<=$total;$i++)
				{
					if ($i == $page) echo '<a href="1_orders.php?date='.$date_tab.'&status='.$status_tab.'&page='.$i.'" class="number current">'.$i.'</a>';
					else			 echo '<a href="1_orders.php?date='.$date_tab.'&status='.$status_tab.'&page='.$i.'" class="number">'.$i.'</a>';
					echo "\n";
				}
			echo '</div><div style="padding-top:10px;"></div></center>';
		}
	}

?>