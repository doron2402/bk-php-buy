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
	function show_deal($id)
	{

		if ($id == "main")	$result = mysql_query("SELECT * FROM `Coupons_Deals` WHERE `deal_status`='1' ORDER BY `deal_position` ASC LIMIT 1;");
		else				$result = mysql_query("SELECT * FROM `Coupons_Deals` WHERE `deal_id`='".$id."' LIMIT 1;");

		$xdeals_count = mysql_num_rows($result);
		if ($xdeals_count != 0)
		{

			$deal_id			= mysql_result($result,0,"deal_id");
			$deal_reg_price		= mysql_result($result,0,"deal_reg_price");
			$deal_our_price		= mysql_result($result,0,"deal_our_price");
			$deal_bill_price	= mysql_result($result,0,"deal_bill_price");

			$deal_min_buyers	= mysql_result($result,0,"deal_min_buyers");

			$deal_name			= mysql_result($result,0,"deal_name");
			$deal_name_left		= mysql_result($result,0,"deal_name_left");

			$deal_text_1		= mysql_result($result,0,"deal_text_1");
			$deal_text_2		= mysql_result($result,0,"deal_text_2");
			$deal_text_3		= mysql_result($result,0,"deal_text_3");

			$deal_image			= mysql_result($result,0,"deal_image");

			$deal_real_buyers 	= mysql_result($result,0,"deal_real_buyers");
			$deal_fake_buyers	= mysql_result($result,0,"deal_fake_buyers");

			$deal_status		= mysql_result($result,0,"deal_status");

			$total_buyers = $deal_real_buyers+$deal_fake_buyers;

			// You save
				$you_save			= $deal_reg_price-$deal_our_price;
				$you_save_avr		= 100-(($deal_our_price/$deal_reg_price)*100);
				$you_save_avr_exp	= explode(".", $you_save_avr);
				$you_save_avr		= $you_save_avr_exp[0];

			// Date
				$deal_end_date		= mysql_result($result,0,"deal_end_date");

				$days = (generate_times($deal_end_date, date("d-m-Y")))-1;
				$hours =   24-date("H");
				$minutes = 60-date("i");
				$seconds = 60-date("s");
		?>
		

      <div class="main_conttxt_title"><?=$deal_name;?></div>
		<div class="main_conttxt_cont">
		 <div class="main_deal_text">
          <?=$deal_text_1;?>
		 </div>
        </div>
       </div>

       <div class="right_imagecont">
        <div class="imagecont_right">
         <div class="buy_but">
          <? if ($deal_status == 1) { ?><a href="buy.php?id=<?=$deal_id;?>" style="outline:none;"><? } ?>
           <img src="images/buy_button.png" alt="buy_button" width="257" height="127" border="0" />
          <? if ($deal_status == 1) { ?></a><? } ?>
         </div>
         <div class="pric_area"><div class="pric_areatxt"><?=$deal_bill_price;?> &#8362</div></div>
         <div class="pric_off"><div class="txt_perc" style="text-align:center;">שווי  <br/><span><?=$deal_reg_price;?> &#8362</span></div>
         <div class="txt_perc" style="text-align:center;">חסכון<br/><span><?=$you_save;?> &#8362</span></div>
         <div class="txt_perc" style="text-align:center;">הנחה<br/><span><?=$you_save_avr;?>%</span></div>
		 </div>

		<? $gp = "'"; echo '
			<script type="text/javascript">
			var _expire = "'.$days.':'.$hours.':'.$minutes.':'.$seconds.'";
			_expire = _expire.split('.$gp.':'.$gp.');

			_days = _expire[0];
			_hrs = _expire[1];
			_mins = _expire[2];
			_secs = _expire[3];

			var _updateExpire = function() {
				run = 1;
				
				if(--_secs < 0) {
					if(--_mins < 0) {
						if(--_hrs < 0) {
							if(--_days < 0)
								_days = _hrs = _mins = _secs = run = 0;
							else {
								_hrs = 23;
								_mins = _secs = 59;
							}
						}
						else
							_mins = _secs = 59;
					}
					else
						_secs = 59;
				}
				
				$(".timer").html(
					_format(_days)+'.$gp.' : '.$gp.'+_format(_hrs)+'.$gp.' : '.$gp.'+_format(_mins)+'.$gp.' : '.$gp.'+_format(_secs)
				);
				
				if(run)
					setTimeout("_updateExpire()", 1000);
				else
					location.reload();
			};

			var _format = function(data) {
				return (data.toString().length < 2) ?'.$gp.'0'.$gp.'+data :data;
			};
			$(document).ready(function(){
				_updateExpire();
			});
		</script>'; ?>

		 <div class="pric_txt01">זמן שנשאר עד תום ההצעה</div>
		 <div class="counter">
          <div class="timer_area">
		   <div class="timer" style="direction:ltr; font-size:30px; margin-top:7px; margin-left:20px;">00 : 00 : 00 : 00</div>
		  </div>
		 </div>
		 <div class="pric_icon"><img src="images/usser_pric.png" alt="usericon" width="49" height="45" border="0" /></div>
		 <div class="user_txt">
		  <div class="usertxt_01">סטטוס הדיל: פעיל</div>
		  <div class="usertxt_01" style="color:#000">נרכשו עד כה :<span><?=$total_buyers;?></span></div></div>
		 </div>

		 <div class="imagecont_left">
		  <div class="imagecont_leftimage">
		   <a href="products/<?=$deal_image;?>" rel="_productImage" style="outline:none;">
		    <img src="products/<?=$deal_image;?>" width="436" height="328" alt="" />
		   </a>
		  </div>
        </div>
        </div>


        <? if ($deal_text_2 != NULL) { ?>
        <div class="mapaddress_cont">
         <div class="address_full">
          <?=$deal_text_2;?>
         </div>
        </div>
		<? } ?>

        <? if ($deal_text_3 != NULL) { ?>
        <div class="right_fullcont">
         <div class="map_text" style="width: auto;">
          <?=$deal_text_3;?>
         </div>
        </div>
		<? } ?>

<div>


<? } } ?>