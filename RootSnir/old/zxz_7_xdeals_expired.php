<?
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! edit buyers count ! ..                                                     *
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

		include "zxz_7_xdeals_functions.php";
		show_header();

		// --------------------- //
		// -- Get Xdeals Data -- //
		// --------------------- //
		opensql();
			$result = mysql_query("SELECT * FROM `Xdeals` WHERE id='".$id."'");
				$today = mysql_result($result,0,"end_date");
				$today_exp		= explode("-", $today);
				$today			= "".$today_exp[1]."-".$today_exp[0]."-20".$today_exp[2]."";
				$date_to_end	= generate_times($today, date("d-m-20y"));

		closesql();

		// ------------------- //
		// -- Update in sql -- //
		// ------------------- //
		if ($_POST['update'] == 1)
		{
				$days = $_POST['days'];	// to logs

				$end_date  = mktime(0, 0, 0, date("m")  , date("d")+$days, date("Y"));

				opensql();

					mysql_query("UPDATE `Xdeals` SET `end_date` = '".date("m-d-y", $end_date)."' WHERE `Xdeals`.`id` =".$id." LIMIT 1 ;");
						mysql_query("OPTIMIZE TABLE `Xdeals`");
							mysql_query("REPAIR TABLE `Xdeals`");
								mysql_query("ANALYZE TABLE `Xdeals`");

				closesql();

				add_to_logs("XDEALS - שינוי תוקף לדיל #".$id." - הקודם - ".$date_to_end." ימים - החדש ".$days." ימים");

				echo '<h1>תוקף הדיל עודכן בהצלחה!<br><br>
				<a href="javascript:parent.$.fancybox.close();" style="color:#000000;">>> חזרה לטבלה</a></h1>';
		}

	// ------------------------------- //
	// -- Show form to update count -- //
	// ------------------------------- //
	else
	{
?>

	<!-- Update form -->
	<div style="padding-top:10px;"></div>
	<center>
	 <h1>עדכן תוקף זמן עבור דיל #<? echo $id; ?></h1>
	<form method="post" action="">
     <input type="hidden" name="update" value="1">
	<table cellpadding="0" cellspacing="0">
	 <tr>
	  <td>בעוד</td><td width="5"></td>
	  <td><input type="text" name="days" value="<? echo $date_to_end; ?>" style="width:30px;"></td>
	  <td>ימים</td><td width="10"></td>
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