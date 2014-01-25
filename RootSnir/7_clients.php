<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! clients ! ..                                                               *
*********************************************************************************  */

	// ------------- // 
	// -- defines -- //
	// ------------- // 
	$color = 7;
	
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

		// ------------------------------- //
		// -------- Total Clients -------- //
		// ------------------------------- //
		$count_now = "SELECT COUNT(*) FROM `Coupons_Clients`"; 
			$count_now = mysql_query($count_now);
				$count_now = mysql_fetch_array($count_now);
					$count_now = $count_now[0];

		$total_pages = (int)($count_now/per_page)+1;

		// --------------------------------- //
		// -------- Select from SQL -------- //
		// --------------------------------- //

		if ($_POST['search'] == "1")
		{
			$result = mysql_query("SELECT * FROM `Coupons_Clients` WHERE 
			`client_firstname`='".$_POST['string']."' 
			OR `client_lastname`='".$_POST['string']."' 
			OR `client_email`='".$_POST['string']."' 
			OR `client_address`='".$_POST['string']."' 
			OR `client_phone`='".$_POST['string']."' 
			OR `client_cellphone`='".$_POST['string']."' 
			ORDER BY `client_id` DESC LIMIT ".per_page."");
		}
		else
		{
			$result = mysql_query("SELECT * FROM `Coupons_Clients` ORDER BY `client_id` DESC LIMIT ".$start_for_sql.", ".per_page."");
		}
		$total = mysql_num_rows($result);
		for ($i=0;$i<$total;$i++)
		{
			// id, hour & email
			$client_id[$i]			= mysql_result($result, $i, "client_id");
			$client_firstname[$i]	= mysql_result($result, $i, "client_firstname");
			$client_lastname[$i]	= mysql_result($result, $i, "client_lastname");
			$client_email[$i]		= mysql_result($result, $i, "client_email");
			$client_city[$i]		= mysql_result($result, $i, "client_city");
			$client_address[$i]		= mysql_result($result, $i, "client_address");
			$client_bait[$i]		= mysql_result($result, $i, "client_bait");
			$client_dira[$i]		= mysql_result($result, $i, "client_dira");
			$client_phone[$i]		= mysql_result($result, $i, "client_phone");
			$client_cellphone[$i]	= mysql_result($result, $i, "client_cellphone");

			// Date
			$client_join_date[$i]	= mysql_result($result, $i, "client_join_date");
				$date_between		= generate_times(date("d-m-Y"), $client_join_date[$i]);
					$client_join_date[$i]	= ''.$client_join_date[$i].' ('.$date_between.')';

				$sql_line = "SELECT COUNT(*) FROM `Coupons_Orders` WHERE `order_client_id`='".$client_id[$i]."'";
					$count_now = mysql_query($sql_line); $count_now = mysql_fetch_array($count_now); $client_t_orders[$i] = $count_now[0];

		}

	closesql();

?>

	 <div class="content-box column-left1">		
	  <!-- top menu -->
	  <div class="content-box-header">
	   <h3>לקוחות</h3>
	  </div><!-- end of top menu -->
	   
         <!-- search -->
		 <form method="post" style="padding:0px; margin:0px;">
		  <input type="hidden" name="search" value="1">
		   <table width="100%">
		    <tr align="center">
			 <td width="40"></td>
		     <td align="center">
			  <b>חפש לקוח</b>
		      <input type="text" name="string" value="<?=$_POST['string'];?>">
		      <input class="button" type="submit" value="חפש!">
		      ניתן להזין:
				שם פרטי,
				שם משפחה,
				אימייל,
				כתובת,
				טלפון או
				פלאפון
			 </td>
            </tr>
		  </table>
		 </form>
         <!-- end of search -->

	   <!-- list -->
	   <div class="content-box-content">
	    <div class="tab-content default-tab">
		 <table>
		  <tr>
		   <td>id</td>
		   <td>שם</td>
		   <td>אימייל</td>
		   <td>כתובת</td>
		   <td>טלפונים</td>
		   <td>הרשמה</td>
		   <td>הזמנות</td>
		  </tr>

		  <!-- show all -->
		  <?
		   for ($i=0;$i<$total;$i++)
		   {
		 	echo '
			<tr>
			 <td>'.$client_id[$i].'</td>
			 <td>'.$client_firstname[$i].' '.$client_lastname[$i].'</td>
			 <td>'.$client_email[$i].'</td>
			 <td>'.$client_city[$i].', '.$client_address[$i].' '.$client_bait[$i].', דירה '.$client_dira[$i].'</td>
			 <td>'.$client_phone[$i].' / '.$client_cellphone[$i].'</td>
			 <td>'.$client_join_date[$i].'</td>
			 <td>'.$client_t_orders[$i].' -> <a href="6_orders.php?client_id='.$client_id[$i].'">צפייה</a></td>
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
				if ($i == $page) echo '<a href="?page='.$i.'" class="number current">'.$i.'</a>';
				else			 echo '<a href="?page='.$i.'" class="number">'.$i.'</a>';
			}
		  ?>
		  </div>
          <!-- end of pages -->

	  </div> <!-- end of list -->
	 </div>
	</div>
<? include "footer.php"; ?>