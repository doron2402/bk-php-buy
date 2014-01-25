<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! edit exsist area ! ..                                                      *
********************************************************************************  */

	include "iframe_html.php";
	include "sql.php";


	// ---------------------------- //
	// -- select shipping method -- //
	// ---------------------------- //
	$id = $HTTP_GET_VARS['id'];
	opensql();
		$result = mysql_query("SELECT * FROM `Coupons_Areas` WHERE `area_id`='".$id."' LIMIT 1;");

			$area_name	= mysql_result($result, 0, "area_name");
	closesql();

	// ------------------------------- //
	// -- add shipping method to db -- //
	// ------------------------------- //
	if ($_POST['edit'] == "1")
	{
		opensql();

		mysql_query("UPDATE `Coupons_Areas` SET `area_name` = '".$_POST['name']."' WHERE `Coupons_Areas`.`area_id` =".$id.";");
				
				mysql_query("OPTIMIZE TABLE `Coupons_Areas`");
					mysql_query("REPAIR TABLE `Coupons_Areas`");
						mysql_query("ANALYZE TABLE `Coupons_Areas`");

		closesql();

		echo '<h1>עודכן בהצלחה!</h1>';
	}

	// ------------------------------- //
	// -- show form -- //
	// ------------------------------- //
	else
	{
?>

  <!-- Update form -->
  <div style="padding-top:10px;"></div>
   <center>
    <h1>עדכן איזור קיים</h1>
	<form method="post" action="">
     <input type="hidden" name="edit" value="1">
     <table cellpadding="4" cellspacing="2">
      <tr>
       <td>שם האיזור</td><td width="5"></td>
       <td><input type="text" name="name" value="<?=$area_name;?>"></td>
	  </tr>
	  <tr>
	   <td></td><td></td>
       <td align="left"><input type="submit" value="עדכן!" style="padding:5px;"></td>
      </tr>
     </table>
    </center>
   <!-- end of Update form -->

<? } ?>