<?
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! add cash order ! ..                                                            *
*********************************************************************************  */

	// -------------- //
	// -- Includes -- //
	// -------------- //
	include "sql.php";
	include "check_user.php";
	include "1_orders_edit_functions.php";

	show_header();

	// ------------------- //
	// -- Update in sql -- //
	// ------------------- //
	if ($_POST['update'] == 1)
	{
			$price		 = $_POST['price'];	// to logs
			$description = $_POST['description']; // to logs

			opensql();

				mysql_query("INSERT INTO `cash` ( `id` ,`date` ,`description` ,`total` ,`by` ) VALUES ( NULL , '".date("m-d-y")."', '".$description."', '".$price."', '".$_COOKIE['user']."');");
					mysql_query("OPTIMIZE TABLE `cash`");
						mysql_query("REPAIR TABLE `cash`");
							mysql_query("ANALYZE TABLE `cash`");
			closesql();

			add_to_logs("הזמנת מזומן חדשה! ₪".$price." לנו :)");

			echo '<h1>ההזמנה נוספה בהצלחה !<br><br>
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
	 <h1>הוסף הזמנה מזומן</h1><br>
	<form method="post" action="">
     <input type="hidden" name="update" value="1">
	<table cellpadding="2" cellspacing="2">
	 <tr><td>רווח נטו</td><td><input type="text" name="price"></td></tr>
	 <tr><td>תיאור</td><td><input type="text" name="description" style="width:400px; padding:3px;"></td></tr>
	 <tr><td></td><td align="left"><input type="submit" value="הוסף!" style="padding:5px;"></td>
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