<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! header ! ..                                                                *
*********************************************************************************  */
 header ("content-type: text/xml");

	echo '<?xml version="1.0" encoding="utf-8"?>
<root>';

	include "../../sql.php"; 
	include "../../functions.php"; 

	opensql();

		$result			= mysql_query("SELECT * FROM `Coupons_Deals` WHERE `deal_status`='1' ORDER BY `deal_position` ASC;");
		$total_deals	= mysql_num_rows($result);

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

			// specific for xml
			$deal_xml_area			= mysql_result($result,$i,"deal_xml_area");
			$deal_xml_category		= mysql_result($result,$i,"deal_xml_category");
			$deal_xml_description	= mysql_result($result,$i,"deal_xml_description");

echo '
	<deal>
			<title>'.$deal_name.'</title>
			<description>'.$deal_xml_description.'</description>
			<area>'.$deal_xml_area.'</area>
			<category>'.$deal_xml_category.'</category>
			<imageURL>http://www.'.$Company_name.'/products/'.$deal_image.'</imageURL>
			<regPrice>'.$deal_reg_price.'</regPrice>
			<priceAfterDiscount>'.$deal_our_price.'</priceAfterDiscount>
			<endTime>'.$deal_end_date.' 00:00</endTime>
			<orderAmount>'.$total_buyers.'</orderAmount>
			<orderMinAmount>'.$deal_min_buyers.'</orderMinAmount>
			<urlToSite>http://www.'.$Company_name.'/deal.php?id='.$deal_id.'</urlToSite>
	</deal>';
		}
		echo '
</root>';

	closesql();

?>