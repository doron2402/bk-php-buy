<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! Functions - all Deals ! ..                                                 *
*********************************************************************************  */


	opensql();

		$result			= mysql_query("SELECT * FROM `Coupons_Deals` WHERE `deal_status`='1' ORDER BY `deal_position` ASC;");
		$total_deals	= mysql_num_rows($result);
		
		for ($i=0;$i<$total_deals;$i++)
		{

			$deal_id[$i]			= mysql_result($result,$i,"deal_id");
			$deal_reg_price[$i]		= mysql_result($result,$i,"deal_reg_price");
			$deal_our_price[$i]		= mysql_result($result,$i,"deal_our_price");
			$deal_bill_price[$i]	= mysql_result($result,$i,"deal_bill_price");
			$deal_min_buyers[$i]	= mysql_result($result,$i,"deal_min_buyers");
			$deal_name[$i]			= mysql_result($result,$i,"deal_name");
			$deal_name_left[$i]		= mysql_result($result,$i,"deal_name_left");
			$deal_text_1[$i]		= mysql_result($result,$i,"deal_text_1");
			$deal_text_2[$i]		= mysql_result($result,$i,"deal_text_2");
			$deal_text_3[$i]		= mysql_result($result,$i,"deal_text_3");
			$deal_image[$i]			= mysql_result($result,$i,"deal_image");
			$deal_real_buyers[$i] 	= mysql_result($result,$i,"deal_real_buyers");
			$deal_fake_buyers[$i]	= mysql_result($result,$i,"deal_fake_buyers");
			$deal_status[$i]		= mysql_result($result,$i,"deal_status");
			$total_buyers[$i]		= $deal_real_buyers[$i]+$deal_fake_buyers[$i];

			// You save
				$you_save[$i]				= $deal_reg_price[$i]-$deal_our_price[$i];
				$you_save_avr[$i]			= 100-(($deal_our_price[$i]/$deal_reg_price[$i])*100);
				$you_save_avr_exp[$i]		= explode(".", $you_save_avr[$i]);
				$you_save_avr[$i]			= $you_save_avr_exp[$i][0];

			// Date
				$deal_end_date[$i]			= mysql_result($result,$i,"deal_end_date");

				$days[$i]					= (generate_times($deal_end_date[$i], date("d-m-Y")))-1;
				$hours[$i]					= 24-date("H");
				$minutes[$i]				= 60-date("i");
				$seconds[$i]				= 60-date("s");
		}

?>