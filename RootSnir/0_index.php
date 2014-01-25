<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! index page ! ..                                                            *
*********************************************************************************  */

	// ------------- // 
	// -- defines -- //
	// ------------- // 
	$color = 0;
	
	// -------------- // 
	// -- includes -- //
	// -------------- // 
	include "header.php";
	include "right_menu.php";
	include "main_menu.php";

	opensql();

		$today = date("d-m-Y");
		$yesterday = date("d-m-Y", strtotime("-1 day"));

		/* ----------------------------
		----------- Coupons -----------
		---------------------------- */
		$sql_line = "SELECT COUNT(*) FROM `Coupons_Deals` WHERE `deal_status`='0'";
			$count_now = mysql_query($sql_line); $count_now = mysql_fetch_array($count_now); $total_pending_coupons = $count_now[0];

		$sql_line = "SELECT COUNT(*) FROM `Coupons_Deals` WHERE `deal_status`='1'";
			$count_now = mysql_query($sql_line); $count_now = mysql_fetch_array($count_now); $total_active_coupons = $count_now[0];

		$sql_line = "SELECT COUNT(*) FROM `Coupons_Deals` WHERE `deal_status`='2'";
			$count_now = mysql_query($sql_line); $count_now = mysql_fetch_array($count_now); $total_expired_coupons = $count_now[0];

		$sql_line = "SELECT COUNT(*) FROM `Coupons_Deals`";
			$count_now = mysql_query($sql_line); $count_now = mysql_fetch_array($count_now); $total_coupons = $count_now[0];

		/* ----------------------------
		----------- Orders -----------
		---------------------------- */

		$sql_line = "SELECT COUNT(*) FROM `Coupons_Orders` WHERE `order_date`='".$today."'";
			$count_now = mysql_query($sql_line); $count_now = mysql_fetch_array($count_now); $today_orders = $count_now[0];

		$sql_line = "SELECT COUNT(*) FROM `Coupons_Orders` WHERE `order_date`='".$yesterday."'";
			$count_now = mysql_query($sql_line); $count_now = mysql_fetch_array($count_now); $yesterday_orders = $count_now[0];

		$sql_line = "SELECT COUNT(*) FROM `Coupons_Orders`";
			$count_now = mysql_query($sql_line); $count_now = mysql_fetch_array($count_now); $total_orders = $count_now[0];


		/* ----------------------------
		----------- Members -----------
		---------------------------- */

		$sql_line = "SELECT COUNT(*) FROM `Coupons_Clients` WHERE `client_join_date`='".$today."'";
			$count_now = mysql_query($sql_line); $count_now = mysql_fetch_array($count_now); $today_members = $count_now[0];

		$sql_line = "SELECT COUNT(*) FROM `Coupons_Clients` WHERE `client_join_date`='".$yesterday."'";
			$count_now = mysql_query($sql_line); $count_now = mysql_fetch_array($count_now); $yesterday_members = $count_now[0];

		$sql_line = "SELECT COUNT(*) FROM `Coupons_Clients`";
			$count_now = mysql_query($sql_line); $count_now = mysql_fetch_array($count_now); $total_members = $count_now[0];


		/* ----------------------------
		----------- Newsletter -----------
		---------------------------- */

		$sql_line = "SELECT COUNT(*) FROM `Coupons_Newsletter` WHERE `newsletter_date`='".$today."'";
			$count_now = mysql_query($sql_line); $count_now = mysql_fetch_array($count_now); $today_newsletter = $count_now[0];

		$sql_line = "SELECT COUNT(*) FROM `Coupons_Newsletter` WHERE `newsletter_date`='".$yesterday."'";
			$count_now = mysql_query($sql_line); $count_now = mysql_fetch_array($count_now); $yesterday_newsletter = $count_now[0];

		$sql_line = "SELECT COUNT(*) FROM `Coupons_Newsletter`";
			$count_now = mysql_query($sql_line); $count_now = mysql_fetch_array($count_now); $total_newsletter = $count_now[0];


	closesql();

?>

	 <div class="content-box column-left3">		
	  <div class="content-box-header"><h3>סטטיסטיקה דילים</h3></div>
	   <div class="content-box-content">
	    <div class="tab-content default-tab">
       
		 <ul style="display:table; width:100%; padding:2px; margin:0px;">
		  <li style="float:right; text-align:right; background-image: none;"><a href="4_deals.php" style="color:#8a00ff; font-weight:bold;">דילים פעילים</a></li>
		  <li style="float:left; text-align:left; background-image: none; line-height:20px;"><? echo $total_active_coupons; ?></li>
		 </ul>
		 <ul style="display:table; width:100%; padding:2px; margin:0px;">
		  <li style="float:right; text-align:right; background-image: none;"><a href="4_deals.php?id=1" style="color:#3066ff; font-weight:bold;">דילים ממתינים</a></li>
		  <li style="float:left; text-align:left; background-image: none; line-height:20px;"><? echo $total_pending_coupons; ?></li>
		 </ul>
		 <ul style="display:table; width:100%; padding:2px; margin:0px;">
		  <li style="float:right; text-align:right; background-image: none;"><a href="4_deals.php?id=2" style="color:#ff7200; font-weight:bold;">דילים שהסתיימו</a></li>
		  <li style="float:left; text-align:left; background-image: none; line-height:20px;"><? echo $total_expired_coupons; ?></li>
		 </ul>
		 <ul style="display:table; width:100%; padding:2px; margin:0px;">
		  <li style="float:right; text-align:right; background-image: none;"><a href="4_deals.php" style="color:#000000; font-weight:bold;">סה"כ דילים</a></li>
		  <li style="float:left; text-align:left; background-image: none; line-height:20px;"><? echo $total_coupons; ?></li>
		 </ul>

	</div>
	</div>
	</div>


	 <div class="content-box column-left3">		
	  <div class="content-box-header"><h3>סטטיסטיקה הזמנות</h3></div>
	   <div class="content-box-content">
	    <div class="tab-content default-tab">

		 <ul style="display:table; width:100%; padding:2px; margin:0px;">
		  <li style="float:right; text-align:right; background-image: none;"><a href="6_orders.php" style="color:#8a00ff; font-weight:bold;">הזמנות מהיום</a></li>
		  <li style="float:left; text-align:left; background-image: none; line-height:20px;"><? echo $today_orders; ?></li>
		 </ul>
		 <ul style="display:table; width:100%; padding:2px; margin:0px;">
		  <li style="float:right; text-align:right; background-image: none;"><a href="6_orders.php" style="color:#3066ff; font-weight:bold;">הזמנות מאתמול</a></li>
		  <li style="float:left; text-align:left; background-image: none; line-height:20px;"><? echo $yesterday_orders; ?></li>
		 </ul>
		 <ul style="display:table; width:100%; padding:2px; margin:0px;">
		  <li style="float:right; text-align:right; background-image: none;"><a href="6_orders.php" style="color:#000000; font-weight:bold;">סה"כ הזמנות</a></li>
		  <li style="float:left; text-align:left; background-image: none; line-height:20px;"><? echo $total_orders; ?></li>
		 </ul>

	</div>
	</div>
	</div>

<div style="padding-top:210px;"></div>


	 <div class="content-box column-left3">		
	  <div class="content-box-header"><h3>סטטיסטיקה משתמשים</h3></div>
	   <div class="content-box-content">
	    <div class="tab-content default-tab">

		 <ul style="display:table; width:100%; padding:2px; margin:0px;">
		  <li style="float:right; text-align:right; background-image: none;"><a href="7_clients.php" style="color:#8a00ff; font-weight:bold;">משתמשים מהיום</a></li>
		  <li style="float:left; text-align:left; background-image: none; line-height:20px;"><? echo $today_members; ?></li>
		 </ul>
		 <ul style="display:table; width:100%; padding:2px; margin:0px;">
		  <li style="float:right; text-align:right; background-image: none;"><a href="7_clients.php" style="color:#3066ff; font-weight:bold;">משתמשים מאתמול</a></li>
		  <li style="float:left; text-align:left; background-image: none; line-height:20px;"><? echo $yesterday_members; ?></li>
		 </ul>
		 <ul style="display:table; width:100%; padding:2px; margin:0px;">
		  <li style="float:right; text-align:right; background-image: none;"><a href="7_clients.php" style="color:#000; font-weight:bold;">סה"כ משתמשים</a></li>
		  <li style="float:left; text-align:left; background-image: none; line-height:20px;"><? echo $total_members; ?></li>
		 </ul>

	</div>
	</div>
	</div>


	 <div class="content-box column-left3">		
	  <div class="content-box-header"><h3>רשימת תפוצה</h3></div>
	   <div class="content-box-content">
	    <div class="tab-content default-tab">

		 <ul style="display:table; width:100%; padding:2px; margin:0px;">
		  <li style="float:right; text-align:right; background-image: none;"><a href="8_newsletter.php" style="color:#8a00ff; font-weight:bold;">נרשמו היום</a></li>
		  <li style="float:left; text-align:left; background-image: none; line-height:20px;"><? echo $today_newsletter; ?></li>
		 </ul>
		 <ul style="display:table; width:100%; padding:2px; margin:0px;">
		  <li style="float:right; text-align:right; background-image: none;"><a href="8_newsletter.php" style="color:#3066ff; font-weight:bold;">נרשמו אתמול</a></li>
		  <li style="float:left; text-align:left; background-image: none; line-height:20px;"><? echo $yesterday_newsletter; ?></li>
		 </ul>
		 <ul style="display:table; width:100%; padding:2px; margin:0px;">
		  <li style="float:right; text-align:right; background-image: none;"><a href="8_newsletter.php" style="color:#000; font-weight:bold;">סה"כ במאגר</a></li>
		  <li style="float:left; text-align:left; background-image: none; line-height:20px;"><? echo $total_newsletter; ?></li>
		 </ul>

	</div>
	</div>
	</div>



<? include "footer.php"; ?>