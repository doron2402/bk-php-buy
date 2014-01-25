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
				$current_count = mysql_result($result,0,"buyers");
		closesql();

		// ------------------- //
		// -- Update in sql -- //
		// ------------------- //
		if ($_POST['update'] == 1)
		{
				$count		= $_POST['count'];	// to logs

				opensql();

					mysql_query("UPDATE `Xdeals` SET `buyers` = '".$count."' WHERE `Xdeals`.`id` =".$id." LIMIT 1 ;");
						mysql_query("OPTIMIZE TABLE `Xdeals`");
							mysql_query("REPAIR TABLE `Xdeals`");
								mysql_query("ANALYZE TABLE `Xdeals`");

				closesql();

				add_to_logs("XDEALS - שינוי כמות רכישות #".$id." - לפני - ".$current_count." - אחרי - ".$count."");

				echo '<h1>כמות הרוכשים התעדכנה!<br><br>
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
	 <h1>עדכן כמות רכישות עבור #<? echo $id; ?></h1>
	<form method="post" action="">
     <input type="hidden" name="update" value="1">
	<table cellpadding="0" cellspacing="0">
	 <tr>
	  <td>עדכן כמות:</td><td width="5"></td>
	  <td><input type="text" name="count" value="<? echo $current_count; ?>"></td>
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