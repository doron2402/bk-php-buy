<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! edit buyers of deals ! ..                                                  *
********************************************************************************  */

	include "iframe_html.php";
	include "sql.php";


	// ---------------------------- //
	// -- select from db -- //
	// ---------------------------- //
	$id = $HTTP_GET_VARS['id'];
	opensql();
		$result = mysql_query("SELECT * FROM `Coupons_Deals` WHERE `deal_id`='".$id."' LIMIT 1;");
			$deal_real_buyers	= mysql_result($result, 0, "deal_real_buyers");
			$deal_fake_buyers	= mysql_result($result, 0, "deal_fake_buyers");
	closesql();

	// ------------------------- //
	// -- edit position in db -- //
	// ------------------------- //
	if ($_POST['edit'] == "1")
	{
		opensql();

		mysql_query("UPDATE `Coupons_Deals` SET 
			`deal_fake_buyers` = '".$_POST['deal_fake_buyers']."' WHERE `Coupons_Deals`.`deal_id` =".$id.";");
				
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
  <div style="padding-top:10px;"></div>
   <center>
    <h1>עדכן כמות קניות</h1>
	<form method="post" action="">
     <input type="hidden" name="edit" value="1">
     <table cellpadding="4" cellspacing="2">
	  <tr>
       <td>אמיתי</td><td width="5"></td>
       <td><?=$deal_real_buyers?></td>
	  </tr>
	  <tr>
       <td>מזויף</td><td width="5"></td>
       <td><input type="text" name="deal_fake_buyers" value="<?=$deal_fake_buyers;?>"></td>
	  </tr>
	  <tr>
	   <td></td><td></td>
       <td align="left"><input type="submit" value="עדכן!" style="padding:5px;"></td>
      </tr>
     </table>
    </center>
   <!-- end of Update form -->

<? } ?>