<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! edit exsist shipping method ! ..                                           *
********************************************************************************  */

	include "iframe_html.php";
	include "sql.php";


	// ---------------------------- //
	// -- select shipping method -- //
	// ---------------------------- //
	$id = $HTTP_GET_VARS['id'];
	opensql();
		$result = mysql_query("SELECT * FROM `Coupons_Shipping` WHERE `shipping_id`='".$id."' LIMIT 1;");

			$shipping_name	= mysql_result($result, 0, "shipping_name");
			$shipping_price = mysql_result($result, 0, "shipping_price");
	closesql();

	// ------------------------------- //
	// -- add shipping method to db -- //
	// ------------------------------- //
	if ($_POST['edit'] == "1")
	{
		opensql();

		mysql_query("UPDATE `Coupons_Shipping` SET 
			`shipping_name` = '".$_POST['name']."',
			`shipping_price` = '".$_POST['price']."' WHERE `Coupons_Shipping`.`shipping_id` =".$id.";");
				
				mysql_query("OPTIMIZE TABLE `Coupons_Shipping`");
					mysql_query("REPAIR TABLE `Coupons_Shipping`");
						mysql_query("ANALYZE TABLE `Coupons_Shipping`");

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
    <h1>עדכן משלוח</h1>
	<form method="post" action="">
     <input type="hidden" name="edit" value="1">
     <table cellpadding="4" cellspacing="2">
      <tr>
       <td>שם המשלוח</td><td width="5"></td>
       <td><input type="text" name="name" value="<?=$shipping_name;?>"></td>
	  </tr>
	  <tr>
       <td>מחיר המשלוח<br>מס' בלבד!</td><td width="5"></td>
       <td><input type="text" name="price" value="<?=$shipping_price;?>">₪</td>
	  </tr>
	  <tr>
	   <td></td><td></td>
       <td align="left"><input type="submit" value="עדכן!" style="padding:5px;"></td>
      </tr>
     </table>
    </center>
   <!-- end of Update form -->

<? } ?>