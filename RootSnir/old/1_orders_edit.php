<?
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! edit order ! ..                                                            *
*********************************************************************************  */

	// -------------- //
	// -- Config -- //
	// -------------- //
	$id = $HTTP_GET_VARS['id'];

	// -------------- //
	// -- Includes -- //
	// -------------- //
	include "sql.php";
	include "check_user.php";
	include "1_orders_edit_data.php";
	include "1_orders_edit_functions.php";

	show_header();
	order_id				($id, $today, $ip, $site);

	// ------------------- //
	// -- Update in sql -- //
	// ------------------- //
	if ($_POST['update'] == 1)
	{
			$old_cost	= $cost;	// to logs
			$id			= $_POST['orderid'];
			$status 	= $_POST['status'];
			$old 		= $_POST['oldstatus'];
			$cost 		= $_POST['cost'];

			opensql();

				$result = mysql_query("UPDATE `orders` SET `status` = '".$status."', `cost` = '".$cost."' WHERE `orders`.`id` =".$id." LIMIT 1 ;");

				if (($old == 'p') && ($status == 'a') || ($old == 'p') && ($status == 'c'))
					$result = mysql_query("UPDATE `orders` SET `c_type` = '', `c_num` = '', `c_exp` = '', `c_id` = '' WHERE `orders`.`id` =".$id." LIMIT 1 ;");

				$result = mysql_query("OPTIMIZE TABLE `orders`");
					$result = mysql_query("REPAIR TABLE `orders`");
						$result = mysql_query("ANALYZE TABLE `orders`");

			closesql();

			add_to_logs("עדכון הזמנה #".$id." - סטטוס ישן - ".$old." - סטטוס חדש - ".$status." - עלות ישן: ₪".$old_cost." - עלות חדש: ₪".$cost."");

			echo '<br><br><h1>ההזמנה עודכנה בהצלחה !<br><br>
			<a href="javascript:parent.$.fancybox.close();" style="color:#000000;">>> חזרה לטבלה</a></h1>';
	}

	// --------------------------------- //
	// -- Show product details & Form -- //
	// --------------------------------- //
	else
	{
		echo '<div style="padding-top:10px;"><a href="javascript:window.print()">הדפסה</a>';
		show_products			($products, $product, $p_count, $site);
		show_prices				($pprice, $sprice, $tprice);
		show_order_details		($lname, $fname, $address, $city, $phone, $notes, $status, $c_type, $c_num, $c_exp, $c_id);
?>

	<!-- Update form -->
	<div style="padding-top:30px;"></div>
	<center>
	<form method="post" action="">
     <input type="hidden" name="update" value="1">
	 <input type="hidden" name="orderid" value="<? echo $id; ?>">
	 <input type="hidden" name="oldstatus" value="<? echo $status; ?>">
	<table cellpadding="0" cellspacing="0">
	 <tr>
	  <td style="background-color:#e7e7e7; height:30px; font-weight:bold; padding:10px;">עדכן סטטוס הזמנה >> </td><td width="10"></td>
	  <td>מצב:</td><td width="5"></td>
	  <td>
	  <select name="status" style="padding:5px;">
	   <option value="a" <? if ($status == "a") echo "SELECTED"; ?>>מאושר</option>
	   <option value="c" <? if ($status == "c") echo "SELECTED"; ?>>מושלם</option>
	   <option value="d" <? if ($status == "d") echo "SELECTED"; ?>>מבוטל</option>
	  </select></div></td>
	  <td width="10"></td>
	  <td>עלות(כולל משלוח): </td><td width="5"></td>
	  <td><input type="text" name="cost" value="<? echo $cost; ?>" style="padding:5px;"></td><td width="5"></td>
	  <td><input type="submit" value="עדכן!" style="padding:5px;"></td>
	 </tr>
	</table>
	</center>
	<!-- end of Update form -->

     </div>
    </div>
   </div>
  </div>
 </div>
</div>
<div style="padding-top:20px;"></div>

<? } ?>