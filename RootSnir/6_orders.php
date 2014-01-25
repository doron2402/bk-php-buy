<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! deals ! ..                                                                 *
*********************************************************************************  */

	// ------------- // 
	// -- defines -- //
	// ------------- // 
	$color = 6;
	
	// -------------- // 
	// -- includes -- //
	// -------------- // 
	include "header.php";
	include "right_menu.php";
	include "main_menu.php";


	// ----------------------- // 
	// -- generate counters -- //
	// ----------------------- // 
	opensql();

		$sql_line = "SELECT COUNT(*) FROM `Coupons_Orders` WHERE `order_status`='1'";
			$count_now = mysql_query($sql_line); $count_now = mysql_fetch_array($count_now); $total_approved_orders = $count_now[0];

		$sql_line = "SELECT COUNT(*) FROM `Coupons_Orders` WHERE `order_status`='0'";
			$count_now = mysql_query($sql_line); $count_now = mysql_fetch_array($count_now); $total_decline_orders = $count_now[0];

	closesql();

	// ---------------------- //
	// -------- Page -------- //
	// ---------------------- //
	define('per_page', '50');
	
		$page = $HTTP_GET_VARS['page'];
		if ($page == NULL) $page = 1;

		if ($page == 1)	$start_for_sql = 0;
		else			$start_for_sql = ($page-1)*per_page;

	$id = $HTTP_GET_VARS['id'];
	if ($id == 0) $total_pages = (int)($total_approved_orders/per_page)+1;
	if ($id == 1) $total_pages = (int)($total_decline_orders/per_page)+1;

	opensql();

		// --------------------------------- //
		// -------- Select from SQL -------- //
		// --------------------------------- //

		$flag_st = 0;

		if ($HTTP_GET_VARS['client_id'] != NULL)
		{
			$result = mysql_query("SELECT * FROM `Coupons_Orders` WHERE `order_client_id`='".$HTTP_GET_VARS['client_id']."' ORDER BY `order_id` DESC LIMIT ".per_page."");
			$flag_st=1;
		}

		if ($_POST['search'] == "1")
		{
			$result = mysql_query("SELECT * FROM `Coupons_Orders` WHERE `order_id`='".$_POST['string']."' OR `order_coupons` LIKE '%".$_POST['string']."-%' ORDER BY `order_id` DESC LIMIT ".per_page."");
			$flag_st=1;
		}

		if ($flag_st == 0)
		{
			if ($id == 0) $result = mysql_query("SELECT * FROM `Coupons_Orders` WHERE `order_status`='1' ORDER BY `order_id` DESC LIMIT ".$start_for_sql.", ".per_page."");
			if ($id == 1) $result = mysql_query("SELECT * FROM `Coupons_Orders` WHERE `order_status`='0' ORDER BY `order_id` DESC LIMIT ".$start_for_sql.", ".per_page."");
		}
		$total = mysql_num_rows($result);
		
		for ($i=0;$i<$total;$i++)
		{
			// id, hour & email
			$order_id[$i]			= mysql_result($result, $i, "order_id");
			$order_date[$i]			= mysql_result($result, $i, "order_date");
			$order_hour[$i]			= mysql_result($result, $i, "order_hour");
			$order_client_id[$i]	= mysql_result($result, $i, "order_client_id");
			$order_deal_id[$i]		= mysql_result($result, $i, "order_deal_id");
			$order_price[$i]		= mysql_result($result, $i, "order_price");
			$order_shipping[$i]		= mysql_result($result, $i, "order_shipping");
			$order_snif[$i]			= mysql_result($result, $i, "order_snif");		if ($order_snif[$i] == NULL) $order_snif[$i] = '-';

			$order_present[$i]			= mysql_result($result, $i, "order_present");			
																					if ($order_present[$i] == 0) $order_present_text[$i] = 'לא';
																					if ($order_present[$i] == 1) $order_present_text[$i] = 'כן';

			$order_present_name[$i]		= mysql_result($result, $i, "order_present_name");
			$order_present_email[$i]	= mysql_result($result, $i, "order_present_email");
			$order_present_msg[$i]		= mysql_result($result, $i, "order_present_msg");

			$order_autorize[$i]			= mysql_result($result, $i, "order_autorize");
			$order_token[$i]			= mysql_result($result, $i, "order_token");

			// Date
				$date_between		= generate_times(date("d-m-Y"), $order_date[$i]);
					$order_date[$i]	= ''.$order_date[$i].' ('.$date_between.')';
		}

	closesql();

?>

	 <div class="content-box column-left1">		
	  
	  <!-- top menu -->
	  <div class="content-box-header">
	   <h3>צפייה בהזמנות</h3>
	   <!--<h3><A href="4_deals_edit.php?id=<?=$nextId;?>">הוסף דיל חדש</a></h3>-->
	   <ul class="content-box-tabs">
	    <li><a href="?id=0"				<? if ($id == 0) echo ' class="default-tab"'; ?>>מאושרים (<?=$total_approved_orders; ?>)</a></li>
	    <li><a href="?id=1"				<? if ($id == 1) echo ' class="default-tab"'; ?>>מחוקים (<?=$total_decline_orders; ?>)</a></li>
	   </ul>
	  </div><!-- end of top menu -->

         <!-- search -->
		 <form method="post" style="padding:0px; margin:0px;" action="6_orders.php">
		  <input type="hidden" name="search" value="1">
		   <table width="100%">
		    <tr align="center">
			 <td width="40"></td>
		     <td align="center">
			  <b>חפש הזמנה</b>
		      <input type="text" name="string" value="<?=$_POST['string'];?>">
		      <input class="button" type="submit" value="חפש!">
		      ניתן להזין:
			  מספר הזמנה
			  או קוד קופון
			 </td>
            </tr>
		  </table>
		 </form>
         <!-- end of search -->

	   <!-- newslettter list -->
	   <div class="content-box-content">
	    <div class="tab-content default-tab">
		 <table>
		  <tr>
		   <td>id</td>
		   <td>תאריך</td>
		   <td>לקוח</td>
		   <td>דיל</td>
		   <td>סכום עיסקה</td>
		   <td>מתנה?</td>
		   <td>משלוח</td>
		   <td>סניף</td>
		   <td>פירוט מלא</td>
		  </tr>
		  <!-- show all -->
		  <?
		   for ($i=0;$i<$total;$i++)
		   {
		 	echo '
			<tr>
			 <td>'.$order_id[$i].'</td>
			 <td>'.$order_date[$i].' '.$order_hour[$i].'</td>
			 <td>'.$order_client_id[$i].'</td>
			 <td><A href="../buy.php?id='.$order_deal_id[$i].'" target="_blank">'.$order_deal_id[$i].'</a></td>
			 <td>₪'.$order_price[$i].'</td>
			 <td>'.$order_present_text[$i].'</td>
			 <td>'.$order_shipping[$i].'</td>
			 <td>'.$order_snif[$i].'</td>
			 <td><a class="various" href="6_orders_view.php?id='.$order_id[$i].'">צפייה</a></td>
			</tr>
			';
		   }
		  ?>
		  </table><!-- end of all -->

		  <!-- pages -->
		  <div class="pagination">
		  <?
			for ($i=1;$i<=$total_pages;$i++)
			{
				if ($i == $page) echo '<a href="?id='.$id.'&page='.$i.'" class="number current">'.$i.'</a>';
				else			 echo '<a href="?id='.$id.'&page='.$i.'" class="number">'.$i.'</a>';
			}
		  ?>
		  </div>
          <!-- end of pages -->

	  </div>
	 </div>
	</div>


<? include "footer.php"; ?>