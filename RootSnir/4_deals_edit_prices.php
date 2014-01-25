<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! edit price to deal ! ..                                                    *
********************************************************************************  */

	include "iframe_html.php";
	include "sql.php";


	// ---------------------------- //
	// -- select from db -- //
	// ---------------------------- //
	$id = $HTTP_GET_VARS['id'];
	opensql();
		$result = mysql_query("SELECT * FROM `Coupons_Deals` WHERE `deal_id`='".$id."' LIMIT 1;");
			$deal_reg_price		= mysql_result($result, 0, "deal_reg_price");
			$deal_our_price		= mysql_result($result, 0, "deal_our_price");
			$deal_bill_price	= mysql_result($result, 0, "deal_bill_price");
	closesql();

	// ------------------------- //
	// -- edit position in db -- //
	// ------------------------- //
	if ($_POST['edit'] == "1")
	{
		opensql();

		mysql_query("UPDATE `Coupons_Deals` SET 
			`deal_reg_price` = '".$_POST['deal_reg_price']."',
			`deal_our_price` = '".$_POST['deal_our_price']."',
			`deal_bill_price` = '".$_POST['deal_bill_price']."'	WHERE `Coupons_Deals`.`deal_id` =".$id.";");
				
				mysql_query("OPTIMIZE TABLE `Coupons_Deals`");
					mysql_query("REPAIR TABLE `Coupons_Deals`");
						mysql_query("ANALYZE TABLE `Coupons_Deals`");

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
   <center>
    <h1>עדכן מחירים</h1>
	<form method="post" action="">
     <input type="hidden" name="edit" value="1">
     <table cellpadding="4" cellspacing="2">
	  <tr>
       <td>מחיר רגיל</td><td width="5"></td>
       <td><input type="text" name="deal_reg_price" value="<?=$deal_reg_price;?>">₪</td>
	  </tr>

	  <tr>
       <td>מחיר שלנו</td><td width="5"></td>
       <td><input type="text" name="deal_our_price" value="<?=$deal_our_price;?>">₪</td>
	  </tr>

	  <tr>
       <td>מחיר בפועל</td><td width="5"></td>
       <td><input type="text" name="deal_bill_price" value="<?=$deal_bill_price;?>">₪</td>
	  </tr>

	  <tr>
	   <td></td><td></td>
       <td align="left"><input type="submit" value="עדכן!" style="padding:5px;"></td>
      </tr>
     </table>
    </center>
   <!-- end of Update form -->

<? } ?>