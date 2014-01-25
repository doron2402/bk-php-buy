<?
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! show deal  ! ..                                                    *
*********************************************************************************  */

	// ----------------- //
	// --- show deal --- //
	// ---------------- //
	function show_more_deals($d_id, $a_id)
	{
		$add = '';
		if ($d_id != NULL)
		{
			if ($d_id == "main")
			{
				$check = mysql_query("SELECT * FROM `Coupons_Deals` WHERE `deal_status`=1 ORDER BY `deal_position` ASC LIMIT 1;");
				$d_id = mysql_result($check,0,"deal_id");
			}
			$add = " AND `deal_id`!=".$d_id."";
		}

		if ($a_id != NULL)
			$add = "".$add." AND `deal_areas` LIKE '%,".$a_id.",%'";

		$result = mysql_query("SELECT * FROM `Coupons_Deals` WHERE `deal_status`=1".$add." ORDER BY `deal_position` ASC;");
		$more_deals_count = mysql_num_rows($result);

		for ($i=0;$i<$more_deals_count;$i++)
		{
			$deal_id			= mysql_result($result,$i,"deal_id");
			$deal_reg_price		= mysql_result($result,$i,"deal_reg_price");
			$deal_our_price		= mysql_result($result,$i,"deal_our_price");
			$deal_bill_price	= mysql_result($result,$i,"deal_bill_price");
			$deal_min_buyers	= mysql_result($result,$i,"deal_min_buyers");

			$deal_name			= mysql_result($result,$i,"deal_name");
			$deal_name_str = strlen($deal_name);
				if ($deal_name_str > 40)
				{
					$temp_name = '';
					$deal_exp = explode(" ", $deal_name);
					for ($z=0;$z<5;$z++)
					{
						$temp_name = ''.$temp_name.''.$deal_exp[$z].' ';
					}
					$deal_name = $temp_name;
					$deal_name = ''.$deal_name.'...';
				}
			$deal_name_left		= mysql_result($result,$i,"deal_name_left");
				if ($deal_name_left == NULL) $deal_name_left = $deal_name;

			$deal_image			= mysql_result($result,$i,"deal_image");

			$deal_real_buyers 	= mysql_result($result,$i,"deal_real_buyers");
			$deal_fake_buyers	= mysql_result($result,$i,"deal_fake_buyers");
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

			<div class="deal_topbg">
			 <div class="dealoff_tit"><?=$deal_name_left; ?></div></div>
              <div class="dealoff_midl">
               <div class="dealoff_sampleimg"><img src="/products/<?=$deal_image;?>" width="108" height="102" alt="" /></div>
                <div class="pric_dealoff"><?=$deal_our_price;?> &#8362</div>
                <div class="txt_dealoff">נרכשו עד כה:<span><?=$total_buyers;?></span></div>
                <div class="dealoff_but">
				 <a href="deal.php?id=<?=$deal_id;?>" style="outline:none;">
                  <img src="images/dealoff_but.png" alt="dealoff_but" width="111" height="58" border="0" />
                 </a>
                </div>
               </div>
              <div class="dealoff_botm"></div>


		<?		
		}

	}

?>