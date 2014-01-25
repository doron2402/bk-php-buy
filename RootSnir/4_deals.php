<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! deals ! ..                                                                 *
*********************************************************************************  */

	// ------------- // 
	// -- defines -- //
	// ------------- // 
	$color = 4;
	
	// -------------- // 
	// -- includes -- //
	// -------------- // 
	include "header.php";
	include "right_menu.php";
	include "main_menu.php";

	opensql();

		// ------------------------------ //
		// -------- find next id -------- //
		// ------------------------------ //
		$result = mysql_query("SHOW TABLE STATUS LIKE 'Coupons_Deals'");
		$row = mysql_fetch_array($result);
		$nextId = $row['Auto_increment'];

		$selected_id = $HTTP_GET_VARS['id'];

		// ---------------------------------- //
		// -------- deals counter -------- //
		// ---------------------------------- //
		$line[0] = "SELECT * FROM `Coupons_Deals` WHERE deal_status='1'";
		$line[1] = "SELECT * FROM `Coupons_Deals` WHERE deal_status='0'";
		$line[2] = "SELECT * FROM `Coupons_Deals` WHERE deal_status='2'";

		for ($i=0;$i<3;$i++)
		{
			$count_now = str_replace("SELECT * FROM ", "SELECT COUNT(*) FROM ", $line[$i]);
				$count_now = mysql_query($count_now); $count_now = mysql_fetch_array($count_now); $total_orders[$i] = $count_now[0];
					if ($total_orders[$i] == NULL) $total_orders[$i] = 0;
		}

		// ---------------------------------- //
		// -------- generate sql line -------- //
		// ---------------------------------- //
		switch ($selected_id)
		{
			case "1": $result = mysql_query("SELECT * FROM `Coupons_Deals` WHERE `deal_status`='0' ORDER BY `deal_position` ASC"); break;
			case "2": $result = mysql_query("SELECT * FROM `Coupons_Deals` WHERE `deal_status`='2' ORDER BY `deal_id` DESC"); break;
			case "0": $result = mysql_query("SELECT * FROM `Coupons_Deals` WHERE `deal_status`='1' ORDER BY `deal_position` ASC"); break;
			case NULL: $result = mysql_query("SELECT * FROM `Coupons_Deals` WHERE `deal_status`='1' ORDER BY `deal_position` ASC"); break;
		}

		// --------------------------------- //
		// -------- Select from SQL -------- //
		// --------------------------------- //
		$total_newsletters  = mysql_num_rows($result);
		for ($i=0;$i<$total_newsletters;$i++)
		{
			// id, position & prices
			$deal_id[$i]		= mysql_result($result, $i, "deal_id");
			$deal_position[$i]	= mysql_result($result, $i, "deal_position");
			$deal_reg_price[$i]	= mysql_result($result, $i, "deal_reg_price");
			$deal_our_price[$i]	= mysql_result($result, $i, "deal_our_price");
			$deal_bill_price[$i]	= mysql_result($result, $i, "deal_bill_price");

			// name, end date
			$deal_name[$i]			= mysql_result($result, $i, "deal_name");
				$deal_name_str = strlen($deal_name[$i]);
					if ($deal_name_str > 40)
					{
						$temp_name = '';
						$deal_exp = explode(" ", $deal_name[$i]);
						for ($z=0;$z<5;$z++)
						{
							$temp_name = ''.$temp_name.''.$deal_exp[$z].' ';
						}
						$deal_name[$i] = $temp_name;
						$deal_name[$i] = ''.$deal_name[$i].'...';
					}

			$deal_end_date[$i]		= mysql_result($result, $i, "deal_end_date");
				if ($deal_end_date[$i] != NULL)
				{
					$deal_end_date[$i] = generate_numbers($deal_end_date[$i], date("d-m-Y"));
					$deal_end_date[$i] = 'בעוד '.$deal_end_date[$i].' ימים';
				}


			// buyers + special
			$deal_real_buyers[$i]	= mysql_result($result, $i, "deal_real_buyers");
			$deal_fake_buyers[$i]	= mysql_result($result, $i, "deal_fake_buyers");
			$deal_is_special[$i]	= mysql_result($result, $i, "deal_is_special");
				if ($deal_is_special[$i] == 2) $deal_is_special[$i] = 'מיוחד';
				else $deal_is_special[$i] = 'רגיל';
		}

	closesql();

?>

	 <div class="content-box column-left1">		
	  
	  <!-- top menu -->
	  <div class="content-box-header">
	   <h3>רשימת דילים</h3>
	   <h3><A href="4_deals_edit.php?id=<?=$nextId;?>">הוסף דיל חדש</a></h3>
	   <ul class="content-box-tabs">
	    <li><a href="?id=0"				<? if ($selected_id == 0) echo ' class="default-tab"'; ?>>פעילים (<?=$total_orders[0]; ?>)</a></li>
	    <li><a href="?id=1"				<? if ($selected_id == 1) echo ' class="default-tab"'; ?>>ממתינים (<?=$total_orders[1]; ?>)</a></li>
	    <li><a href="?id=2"				<? if ($selected_id == 2) echo ' class="default-tab"'; ?>>פגו (<?=$total_orders[2]; ?>)</a></li>
	   </ul>
	  </div><!-- end of top menu -->

	   <!-- newslettter list -->
	   <div class="content-box-content">
	    <div class="tab-content default-tab">
		 <table>
		  <tr>
		   <td>id</td>
		   <td>שם</td>
		   <td>מיקום</td>
		   <td>מחירים</td>
		   <? if ($selected_id == 0) { ?><td>מסתיים</td><? } ?>
		   <td>קניות</td>
		   <td>מיוחד?</td>
		   <td>ערוך</td>
		  </tr>
		  <!-- show all -->
		  <?
		   for ($i=0;$i<$total_newsletters;$i++)
		   {
		 	echo '
			<tr>
			 <td>'.$deal_id[$i].'</td>
			 <td>'.$deal_name[$i].'</td>
			 <td>'.$deal_position[$i].' <a class="various_small" href="4_deals_edit_position.php?id='.$deal_id[$i].'"><img src="resources/images/icons/pencil.png" border="0"></a></td>
			 <td>₪'.$deal_reg_price[$i].' / ₪'.$deal_our_price[$i].' / ₪'.$deal_bill_price[$i].' <a class="various_small" href="4_deals_edit_prices.php?id='.$deal_id[$i].'"><img src="resources/images/icons/pencil.png" border="0"></a></td>';
			 if ($selected_id == 0) echo '<td>'.$deal_end_date[$i].'</td>';
			 echo '<td><b style="font-size:16px;"><a href="4_deals_view_all.php?id='.$deal_id[$i].'">'.$deal_real_buyers[$i].'</a></b> / '.$deal_fake_buyers[$i].' <a class="various_small" href="4_deals_edit_buyers.php?id='.$deal_id[$i].'"><img src="resources/images/icons/pencil.png" border="0"></a></td>
			 <td>'.$deal_is_special[$i].'</td>
			 <td><a href="4_deals_edit.php?id='.$deal_id[$i].'"><img src="resources/images/icons/pencil.png" border="0"></a></td>
			</tr>
			';
		   }
		  ?>
		  </table><!-- end of all -->
	  </div>
	 </div>
	</div>

<? include "footer.php"; ?>