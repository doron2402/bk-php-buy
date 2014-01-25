<?

/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! cash function. ! ..                                                       *
*********************************************************************************  */

	// ------------------- //
	// -- text for date -- //
	// ------------------- //
	switch ($date_tab)
	{
		case "all": $date_top_text = 'מכל הזמנים';		break;
		case "1":   $date_top_text = 'החודש';			break;
		case "2":   $date_top_text = 'חודש שעבר';		break;
		case "3":   $date_top_text = 'לפני חודשיים';	break;
		case "3":   $date_top_text = 'לפני 3 חודשים';	break;
	}

	// -------------- //
	// -- show div -- //
	// -------------- //
	function show_div($date_tab)
	{ ?>
	
	 <div class="content-box column-left1">		
      <div class="content-box-header">
       <h3>הזמנות במזומן</h3>
       <ul class="content-box-tabs">
        <li><a href="?date=all"<? if ($date_tab == "all") echo ' class="default-tab" style="color:#0084ff; font-weight:bold;"'; ?>>הכל</a></li>
        <li><a href="?date=1"<? if ($date_tab == "1") echo ' class="default-tab" style="color:#0084ff; font-weight:bold;"'; ?>>החודש</a></li>
        <li><a href="?date=2"<? if ($date_tab == "2") echo ' class="default-tab" style="color:#0084ff; font-weight:bold;"'; ?>>חודש שעבר</a></li>
        <li><a href="?date=3"<? if ($date_tab == "3") echo ' class="default-tab" style="color:#0084ff; font-weight:bold;"'; ?>>לפני 2 חודשים</a></li>
        <li><a href="?date=4"<? if ($date_tab == "4") echo ' class="default-tab" style="color:#0084ff; font-weight:bold;"'; ?>>לפני 3 חודשים</a></li>
       </ul>
	   <div class="clear"></div>			
      </div>

	<? }

	// ----------------------- //
	// -- generate sql line -- //
	// ----------------------- //
	function get_sql_line($date_tab)
	{
		if ($date_tab != "all")
		{
			$date_now = date("m-d-y");
			if ($date_tab == 2) $date_now = date("m-d-y", strtotime("-1 month"));
			if ($date_tab == 3) $date_now = date("m-d-y", strtotime("-2 month"));
			if ($date_tab == 4) $date_now = date("m-d-y", strtotime("-3 month"));
			$date_exp = explode("-", $date_now);

			$string = '';
			for ($i=1;$i<32;$i++)
			{
				if ($i<10)	$string = ''.$string.'`date`="'.$date_exp[0].'-0'.$i.'-'.$date_exp[2].'" OR ';
				else		$string = ''.$string.'`date`="'.$date_exp[0].'-'.$i.'-'.$date_exp[2].'" OR ';
			}
			$string = substr($string, 0, -3);
		}

		if ($date_tab == "all")	$sql_line = "SELECT * FROM `cash` ORDER BY id DESC";
		else					$sql_line = "SELECT * FROM `cash` WHERE (".$string.") ORDER BY id DESC";

		return $sql_line; 
	}

	// ------------------------- //
	// -- time between orders -- //
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

	// -------------------------- //
	// -- pages for the footer -- //
	// -------------------------- //
	function show_pages($total,$page,$date_tab)
	{
		if ($total != NULL)
		{ 
			echo '<div style="padding-top:10px;"></div><center><div class="pagination">';
				for ($i=1;$i<=$total;$i++)
				{
					if ($i == $page) echo '<a href="2_cash.php?date='.$date_tab.'&page='.$i.'" class="number current">'.$i.'</a>';
					else			 echo '<a href="2_cash.php?date='.$date_tab.'&page='.$i.'" class="number">'.$i.'</a>';
					echo "\n";
				}
			echo '</div><div style="padding-top:10px;"></div></center>';
		}
	}

	// ---------------------- //
	// -- results per page -- //
	// ---------------------- //
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
	function top_navigator($date_top_text,$result_array, $count_now)
	{ ?>
	   <div class="content-box-content">
	    <div class="tab-content default-tab">
		 <div style="padding:15px 20px 0px 20px;">
		  <div style="padding-top:10px;"></div>
           <table width="100%"><tr>
             <td align="right" style="text-align:right;"><b>מציג מזומן >> <? echo $date_top_text; ?></b></td>
			 <td align="center"><a href="2_cash_add.php" class="various_medium">הוסף הזמנה במזומן</a></td>
             <td align="left">מציג הזמנות מזומן <b><? echo $result_array[0]; ?></b> עד <b><? echo $result_array[1]; ?></b> מתוך <b><? echo $count_now; ?></b></td>
            </tr></table>
           <br><br><br>
	<? }
?>