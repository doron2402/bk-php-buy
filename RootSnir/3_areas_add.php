<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! add new area option ! ..                                               *
********************************************************************************  */

	include "iframe_html.php";
	include "sql.php";

	// ------------------------------- //
	// -- add shipping method to db -- //
	// ------------------------------- //
	if ($_POST['add'] == "1")
	{
		opensql();

			mysql_query("INSERT INTO `Coupons_Areas` VALUES (NULL, '".$_POST['name']."');");
				mysql_query("OPTIMIZE TABLE `Coupons_Areas`");
					mysql_query("REPAIR TABLE `Coupons_Areas`");
						mysql_query("ANALYZE TABLE `Coupons_Areas`");

		closesql();

		echo '<h1>נוסף בהצלחה!</h1>';
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
    <h1>הוסף איזור חדש</h1>
	<form method="post" action="">
     <input type="hidden" name="add" value="1">
     <table cellpadding="4" cellspacing="2">
      <tr>
       <td>שם האיזור</td><td width="5"></td>
       <td><input type="text" name="name"></td>
	  </tr>
	   <td></td><td></td>
       <td align="left"><input type="submit" value="הוסף!" style="padding:5px;"></td>
      </tr>
     </table>
    </center>
   <!-- end of Update form -->

<? } ?>