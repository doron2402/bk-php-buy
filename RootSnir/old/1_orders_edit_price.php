<?
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! edit price ! ..                                                            *
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

	if ($admin == 1)
	{

	include "1_orders_edit_data.php";
	include "1_orders_edit_functions.php";

	show_header();
	// ------------------- //
	// -- Update in sql -- //
	// ------------------- //
	if ($_POST['update'] == 1)
	{
			$price		= $_POST['price'];	// to logs

			opensql();

				mysql_query("UPDATE `orders` SET `t_price` = '".$price."' WHERE `orders`.`id` =".$id." LIMIT 1 ;");
					mysql_query("OPTIMIZE TABLE `orders`");
						mysql_query("REPAIR TABLE `orders`");
							mysql_query("ANALYZE TABLE `orders`");

			closesql();

			add_to_logs("עדכון מחיר להזמנה #".$id." - מחיר ישן - ₪".$tprice." - מחיר חדש - ₪".$price."");

			echo '<h1>המחיר התעדכן בהצלחה !<br><br>
			<a href="javascript:parent.$.fancybox.close();" style="color:#000000;">>> חזרה לטבלה</a></h1>';
	}

	// ------------------------------- //
	// -- Show form to update price -- //
	// ------------------------------- //
	else
	{
?>

	<!-- Update form -->
	<div style="padding-top:10px;"></div>
	<center>
	 <h1>הזמנה מספר <? echo $id; ?></h1>
	<form method="post" action="">
     <input type="hidden" name="update" value="1">
	<table cellpadding="0" cellspacing="0">
	 <tr>
	  <td>עדכן מחיר:</td><td width="5"></td>
	  <td><input type="text" name="price" value="<? echo $tprice; ?>"></td>
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

<? } } ?>