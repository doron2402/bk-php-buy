<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! all deals ! ..                                                             *
*********************************************************************************  */

	include "sql.php";

	opensql();
		$result = mysql_query("SELECT * FROM `Coupons_Titles` WHERE `text_id`='2'");
		$meta_title			= mysql_result($result, 0, "text_meta_title");
		$meta_description	= mysql_result($result, 0, "text_meta_description");
		$meta_keywords		= mysql_result($result, 0, "text_meta_keywords");
	closesql();

	$long_page = 1;
	include "header.php";
	include "functions_all-deals.php";

		for ($i=0;$i<$total_deals;$i++)
		{ ?>

	<a href="/deal.php?id=<?=$deal_id[$i];?>">
	 <div class="dealpage-dealouter">
	  <div class="dealpage-img">
	   <img src="/products/<?=$deal_image[$i];?>" alt="" width="210" height="150" border="0" />
	  </div>
	  <div class="dealpage-details">
	   <div class="side-deal-button" style="height:65px">
	    <div style="float:right; padding:12px 10px 0 0;"><input class="side-deal-buttons" name="http://www.luckydeal.co.il/deal.php?id=<?=$deal_id[$i];?>" type="button" value=""/></div>
	   <div style="text-align:right; float:right; font-size:24px; padding:15px 10px 0 0; font-weight:bold; color:#fff"><?=$deal_our_price[$i];?><span style="font-size:16px"> &#8362 </span></div>
	  </div>

	  <div class="side-deal-details">
	   <div class="side-details-inner" style="padding-right:20px">
	    <span class="side-deal-lable">שווי</span>
	    <span class="side-deal-discount"><?=$deal_reg_price[$i];?><span style="font-size:12px"> &#8362 </span></span>
	   </div>

	   <div class="side-details-inner" style="margin-right:7px;">
	    <span class="side-deal-lable">הנחה</span>
	    <span class="side-deal-discount"><?=$you_save_avr[$i];?>%</span>
	   </div>

	   <div class="side-details-inner" style="margin-right:10px;">
	    <span class="side-deal-lable">חיסכון</span>
	    <span class="side-deal-discount"><?=$you_save[$i];?><span style="font-size:12px"> &#8362 </span></span>
	   </div>
	  </div>

	  <div class="dealpage-txt">
	   <?=$deal_name[$i];?>
	   </div>
	  </div>

	  <div class="like_but" style="margin-right:254px;">
	   <fb:like href="http://www.luckydeal.co.il/deal.php?id=<?=$deal_id[$i];?>" send="false" layout="button_count" width="98" show_faces="false"></fb:like>
	  </div>
	 </div>
	</a>

<? } include "footer.php"; ?>