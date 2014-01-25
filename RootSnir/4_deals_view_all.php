<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! show all orders from deal ! ..                                             *
*********************************************************************************  */

	// ------------- // 
	// -- defines -- //
	// ------------- // 
	$color = 4;
	$deal_num = $HTTP_GET_VARS['id'];

	// -------------- // 
	// -- includes -- //
	// -------------- // 
	include "header.php";
	include "right_menu.php";
	include "main_menu.php";

	opensql();

		$str_to_search ="SELECT * FROM `Coupons_Orders` WHERE `order_deal_id`='".$deal_num."' AND `order_status`='1'ORDER BY `order_snif` DESC";

		$result = mysql_query($str_to_search);
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
	   <h3>צפייה בכל ההזמנות של דיל מספר <?=$deal_num;?></h3>
	  </div><!-- end of top menu -->

      <!-- show all orders -->
	   <div class="content-box-content">
	    <div class="tab-content default-tab">
		 <table>
		  <tr>
		   <td>id</td>
		   <td>תאריך</td>
		   <td>לקוח</td>
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

    </div>
   </div>
  </div>