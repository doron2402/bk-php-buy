<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! prev deals ! ..                                                            *
*********************************************************************************  */

	include "sql.php";

	opensql();
		$result = mysql_query("SELECT * FROM `Coupons_Titles` WHERE `text_id`='3'");
		$meta_title			= mysql_result($result, 0, "text_meta_title");
		$meta_description	= mysql_result($result, 0, "text_meta_description");
		$meta_keywords		= mysql_result($result, 0, "text_meta_keywords");
	closesql();

	$long_page = 1;
	include "header.php";
	
	opensql();

		$result			= mysql_query("SELECT * FROM `Coupons_Deals` WHERE `deal_status`='2' AND `deal_is_latest`='0' ORDER BY `deal_position` ASC;");
		$total_deals	= mysql_num_rows($result);
		echo '<style>.txt_perc { width:56px; }</style>';

		for ($i=0;$i<$total_deals;$i++)
		{

			$deal_id			= mysql_result($result,$i,"deal_id");
			$deal_reg_price		= mysql_result($result,$i,"deal_reg_price");
			$deal_our_price		= mysql_result($result,$i,"deal_our_price");
			$deal_bill_price	= mysql_result($result,$i,"deal_bill_price");

			$deal_min_buyers	= mysql_result($result,$i,"deal_min_buyers");

			$deal_name			= mysql_result($result,$i,"deal_name");
			$deal_name_left		= mysql_result($result,$i,"deal_name_left");

			$deal_text_1		= mysql_result($result,$i,"deal_text_1");
			$deal_text_2		= mysql_result($result,$i,"deal_text_2");
			$deal_text_3		= mysql_result($result,$i,"deal_text_3");

			$deal_image			= mysql_result($result,$i,"deal_image");

			$deal_real_buyers 	= mysql_result($result,$i,"deal_real_buyers");
			$deal_fake_buyers	= mysql_result($result,$i,"deal_fake_buyers");

			$deal_status		= mysql_result($result,$i,"deal_status");

			$total_buyers = $deal_real_buyers+$deal_fake_buyers;

			// You save
				$you_save			= $deal_reg_price-$deal_our_price;
				$you_save_avr		= 100-(($deal_our_price/$deal_reg_price)*100);
				$you_save_avr_exp	= explode(".", $you_save_avr);
				$you_save_avr		= $you_save_avr_exp[0];

			// Date
				$deal_end_date		= mysql_result($result,$i,"deal_end_date");

				$days = (generate_times($deal_end_date, date("d-m-Y")))-1;
				$hours =   24-date("H");
				$minutes = 60-date("i");
				$seconds = 60-date("s");
	?>

	<div class="previous_dealbox" onclick="location.href='/deal.php?id=<?=$deal_id;?>';" style="cursor:pointer;">
		<div class="predeal_head"></div>
		<div class="predeal_cont">
		 <div class="predeal_contant"><?=$deal_name;?></div>
		  <div class="predeal_image"><img src="/products/<?=$deal_image;?>" alt="" height="115" width="122"></div>
		   <div class="prevpric_off">
		    <div class="txt_perc">נמכרו<br><span><?=$total_buyers;?></span></div>
		    <div class="txt_perc">מחיר<br><span><?=$deal_reg_price;?> ₪</span></div>
		    <div class="txt_perc">חיסכון<br><span><?=$you_save;?> ₪</span></div>
		    <div class="txt_perc">הנחה<br><span><?=$you_save_avr;?>%</span></div>
		   </div>
		  </div>
		 </div>
		

	<?
		}

	closesql();

	include "footer.php";
	
?>