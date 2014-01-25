<?

/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! redpoint products function. ! ..                                           *
*********************************************************************************  */


	// ------------------------- //
	// --- generate top text --- //
	// ------------------------- //
	function generate_top_text($status)
	{
		switch ($status)
		{
			case "active":			$status_top_text = 'פעילים';			break;
			case "deactive":		$status_top_text = 'לא פעילים';			break;
			case "pending":			$status_top_text = 'ממתינים לאישור';	break;
		}
		return $status_top_text;
	}
	// ------------------------- //
	// --- generate sql line --- //
	// ------------------------- //
	function get_sql_line($status)
	{
		switch($status)
		{
			case "active":			$sql_line = "SELECT * FROM `products` WHERE `special_price`!=0 ORDER BY `entity_id` DESC";					break;
			case "deactive":		$sql_line = "SELECT * FROM `products` WHERE `price`!=0 AND `special_price`=0 ORDER BY `entity_id` DESC";	break;
			case "pending":			$sql_line = "SELECT * FROM `products` WHERE `price`=0 AND `special_price`=0 ORDER BY `entity_id` DESC";			break;
		}
		return $sql_line; 
	}

	// ------------------------------- //
	// --- generate count products --- //
	// ------------------------------- //
	function generate_count_procuts()
	{
		$total_orders[0] = get_sql_line("active");
		$total_orders[1] = get_sql_line("deactive");
		$total_orders[2] = get_sql_line("pending");

		for ($i=0;$i<3;$i++)
		{
			$count_now = str_replace("SELECT * FROM ", "SELECT COUNT(*) FROM ", $total_orders[$i]);
				$count_now = mysql_query($count_now); $count_now = mysql_fetch_array($count_now); $total_orders[$i] = $count_now[0];
					if ($total_orders[$i] == NULL) $total_orders[$i] = 0;
		}

		return $total_orders; 
	}

	// ----------------- //
	// --- first div --- //
	// ----------------- //
	function show_first_div($status,$total_orders, $admin)
	{ ?>
     <div class="content-box column-left1">		
      <div class="content-box-header">
	   <h3>מוצרים באתר Redpoint.co.il</h3>
	   <h3><a class="various" href="3_products_add.php">הוספת מוצר חדש</a></h3>
	   <? if ($admin == 1)
	   echo '
	   <h3><a class="various" href="3_products_texts.php">תכנים באתר</a></h3>
	   <h3><a class="various_medium" href="3_products_index.php">עמוד ראשי</a></h3>
	   ';
	   ?>
	   <ul class="content-box-tabs">
        <li><a href="?status=active"<? if ($status == "active") echo ' class="default-tab" style="color:#0084ff; font-weight:bold;"'; ?>>פעילים (<? echo $total_orders[0]; ?>)</a></li>
        <li><a href="?status=deactive"<? if ($status == "deactive") echo ' class="default-tab" style="color:#0084ff; font-weight:bold;"'; ?>>לא פעילים (<? echo $total_orders[1]; ?>)</a></li>
        <li><a href="?status=pending"<? if ($status == "pending") echo ' class="default-tab" style="color:#0084ff; font-weight:bold;"'; ?>>מחכים לאישור (<? echo $total_orders[2]; ?>)</a></li>
       </ul>
	   <div class="clear"></div>
	  </div>
	 <div class="content-box-content">
	<? }

	// --------------------------------------------- //
	// --- search sql string - by type or search --- //
	// --------------------------------------------- //
	function generate_sql_line($status,$search,$string)
	{
		if ($search == 1)
		{
			$sql_line = "SELECT * FROM `products` WHERE `entity_id` = '".$string."' OR `sku` = '".$string."' OR `name` LIKE '%".$string."%'";
		}
		else
		{
			$sql_line = get_sql_line($status);
		}

		return $sql_line;
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

	// ------------------------------------- //
	// --- generate start & end position --- //
	// ------------------------------------- //
	function generate_results($page, $count_now)
	{
		if ($page == 1)
		{
			$array[0] = '1';
			$array[1] = products_per_page;
			if ($array[1] > $count_now) $array[1] = $count_now;
		}
		else
		{
			$page_results = ($page-1)*products_per_page;
			$array[0] = $page_results;
			$array[1] = $page_results+products_per_page;
			if ($array[1] > $count_now) $array[1] = $count_now;
		}

		return $array;
	}

	// -------------------------- //
	// --- show top navigator --- //
	// -------------------------- //
	function show_top_navigator($status_top_text,$result_array, $count_now)
	{ ?>
		 <div style="padding:15px 20px 0px 20px;">
		  <div style="padding-top:10px;"></div>
		   <form method="post" style="padding:0px; margin:0px;" action="3_products.php">
		    <input type="hidden" name="search" value="1">
             <table width="100%"><tr>
              <td align="right" style="text-align:right;"><b>מציג מוצרים >> <? echo $status_top_text; ?></b></td>
			  <td align="center" width="50%">
			   חיפוש מוצר (שם, SKU או מס)
			   <input type="text" name="string">
			   <input class="button" type="submit" value="חפש!">
			  </form>
			 </td>
             <td align="left">מציג מוצרים <b><? echo $result_array[0]; ?></b> עד <b><? echo $result_array[1]; ?></b> מתוך <b><? echo $count_now; ?></b></td>
            </tr></table>
           <br><br>
	<? }

	// -------------------------- //
	// --- show pages --- //
	// -------------------------- //
	function show_pages($total,$page,$status)
	{
		if ($total != NULL)
		{ 
			echo '<div style="padding-top:10px;"></div><center><div class="pagination">';
				for ($i=1;$i<=$total;$i++)
				{
					if ($i == $page) echo '<a href="3_products.php?status='.$status.'&page='.$i.'" class="number current">'.$i.'</a>';
					else			 echo '<a href="3_products.php?status='.$status.'&page='.$i.'" class="number">'.$i.'</a>';
					echo "\n";
				}
			echo '</div><div style="padding-top:10px;"></div></center>';
		}
	}

?>