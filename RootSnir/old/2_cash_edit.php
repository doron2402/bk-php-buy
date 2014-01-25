<?
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! edit cash ! ..                                                             *
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

	// ----------------- //
	// -- show header -- //
	// ----------------- //
	function show_header()
	{ ?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		 <head>
		 <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		 <style>
		  body { color:#000000; color:#000000; background-color:#f6f6f6; }
		  body { font-family: "Arial", "Arial (Hebrew)", "David (Hebrew)", "Courier New (Hebrew)"; font-size:12px; font-weight:normal; padding:0px; margin:0px; }
		  h1,h2,h3 { font-family: "Arial", "Arial (Hebrew)", "David (Hebrew)", "Courier New (Hebrew)"; }
		  #preview{
			position:absolute;
			border:1px solid #ccc;
			background:#333;
			padding:2px;
			display:none;
			color:#fff;
			}
		 </style>
		 <script src="images/jquery.js" type="text/javascript"></script>
		 <script src="images/main.js" type="text/javascript"></script>
		</head>
		<body dir="rtl">
		<center>
	<? }
	show_header();

	opensql();
		$result = mysql_query("SELECT * FROM `cash` WHERE `id`='".$id."'");
		$description		= mysql_result($result,0,"description");
		$total				= mysql_result($result,0,"total");
	closesql();
	// ------------------- //
	// -- Update in sql -- //
	// ------------------- //
	if ($_POST['update'] == 1)
	{
			$new_price				= $_POST['price'];			// to logs
			$new_description		= $_POST['description'];	// to logs

			opensql();

				mysql_query("UPDATE `cash` SET `total` = '".$new_price."', `description` = '".$new_description."' WHERE `cash`.`id` =".$id." LIMIT 1 ;");
					mysql_query("OPTIMIZE TABLE `cash`");
						mysql_query("REPAIR TABLE `cash`");
							mysql_query("ANALYZE TABLE `cash`");

			closesql();

			add_to_logs("עדכון הזמנת מזומן #".$id." - מחיר ישן - ₪".$total." - מחיר חדש - ₪".$new_price."");

			echo '<h1>ההזמנה התעדכנה בהצלחה !<br><br>
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
	 <h1>עדכון הזמנת מזומן - #<? echo $id; ?></h1><br>
	<form method="post" action="">
     <input type="hidden" name="update" value="1">
	<table cellpadding="2" cellspacing="2">
	 <tr><td>רווח נטו</td><td><input type="text" name="price" value="<? echo $total; ?>"></td></tr>
	 <tr><td>תיאור</td><td><input type="text" name="description" style="width:400px; padding:3px;" value="<? echo $description; ?>"></td></tr>
	 <tr><td></td><td align="left"><input type="submit" value="עדכן!" style="padding:5px;"></td>
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