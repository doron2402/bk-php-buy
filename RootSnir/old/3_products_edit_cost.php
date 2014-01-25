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

	// ---------------------------------- //
	// -- Get cost price price from db -- //
	// ---------------------------------- //
	opensql_redpoint();
		$result = mysql_query("SELECT * FROM `products` WHERE `entity_id`='".$id."'");
			$rprice =		mysql_result($result,0,"rprice");
	closesql_redpoint();

	show_header();
	// ------------------- //
	// -- Update in sql -- //
	// ------------------- //
	if ($_POST['update'] == 1)
	{
			$price		= $_POST['price'];	// to logs

			opensql_redpoint();

				mysql_query("UPDATE `products` SET `rprice` = '".$price."' WHERE `products`.`entity_id` =".$id." LIMIT 1 ;");
					mysql_query("OPTIMIZE TABLE `products`");
						mysql_query("REPAIR TABLE `products`");
							mysql_query("ANALYZE TABLE `products`");

			closesql_redpoint();

			add_to_logs("עדכון מחיר עלות - #".$id." - מחיר ישן - ₪".$rprice." - מחיר חדש - ₪".$price."");

			echo '<h1>עלות המוצר התעדכנה בהצלחה!<br><br>
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
	 <h1>שינוי מחיר עלות מוצר - <? echo $id; ?></h1>
	<form method="post" action="">
     <input type="hidden" name="update" value="1">
	<table cellpadding="0" cellspacing="0">
	 <tr>
	  <td>עדכן עלות</td><td width="5"></td>
	  <td><input type="text" name="price" value="<? echo $rprice; ?>"></td>
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