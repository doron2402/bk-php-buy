<?
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! edit product cost ! ..                                                     *
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
	include "3_products_functions.php";


	if ($admin == 1)
	{

	// ---------------------------------- //
	// -- Get cost price price from db -- //
	// ---------------------------------- //
	opensql_redpoint();
		$result = mysql_query("SELECT * FROM `products` WHERE `entity_id`='".$id."'");
			$price				 = mysql_result($result,0,"price");
			$special_price		 = mysql_result($result,0,"special_price");
	closesql_redpoint();

	show_header();
	// ------------------- //
	// -- Update in sql -- //
	// ------------------- //
	if ($_POST['update'] == 1)
	{
			$store_price	= $_POST['store_price'];	// to logs
			$site_price		= $_POST['site_price'];	// to logs

			opensql_redpoint();

				mysql_query("UPDATE `products` SET `price` = '".$store_price."', `special_price` = '".$site_price."'  WHERE `products`.`entity_id` =".$id." LIMIT 1 ;");
					mysql_query("OPTIMIZE TABLE `products`");
						mysql_query("REPAIR TABLE `products`");
							mysql_query("ANALYZE TABLE `products`");

			closesql_redpoint();

			add_to_logs("עדכון מחירים למוצר - #".$id." - מחיר בחנות - ₪".$price." >> ₪".$store_price." - מחיר באתר ₪".$special_price." >> ₪".$site_price."");

			echo '<h1>המחיר למוצר עודכנו בהצלחה!<br><br>
			<a href="javascript:parent.$.fancybox.close();" style="color:#000000;">>> חזרה לטבלה</a></h1>';
	}

	// ------------------------------- //
	// -- Show form to update price -- //
	// ------------------------------- //
	else
	{
?>

	<!-- Valid form -->
	<script>
	function checkform ( form )
	{

		if (form.store_price.value == '') { alert( "חובה להזין מחיר בחנות" ); form.store_price.focus(); return false ; }
		if (form.site_price.value == '') { alert( "חובה להזין מחיר באתר" ); form.site_price.focus(); return false ; }

	  return true ;
	}
	</script>

	<!-- Update form -->
	<div style="padding-top:10px;"></div>
	<center>
	 <h1>שינוי מחיר למוצר - <? echo $id; ?></h1>
	<form method="post" action="" onsubmit="return checkform(this);">
     <input type="hidden" name="update" value="1">
	<table cellpadding="0" cellspacing="0">
	 <tr>
	  <td>מחיר בחנות</td><td width="5"></td>
	  <td><input type="text" name="store_price" value="<? echo $price; ?>"></td>
	 </tr>
	 <tr>
	  <td>מחיר באתר</td><td width="5"></td>
	  <td><input type="text" name="site_price" value="<? echo $special_price; ?>"></td>
	 </tr>
	 <tr>
	  <td></td><td></td>
	  <td align="left"><input type="submit" value="עדכן!" style="padding:5px;"></td>
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