<?
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! functions ! ..                                                             *
*********************************************************************************  */

	// --------------------------
	// Generate time
	// --------------------------
	function generate_times($today, $added)
	{
		if ($today == $added) $time_before_days = "<b>מהיום</b>";
		else
		{
			$today_a		= strtotime($today);			$added_a = strtotime($added);
			$time_before	= $today_a - $added_a;			$time_before1 = $time_before/86400;
			$time_before1	= explode(".", $time_before1);
			$time_before1	= $time_before1[0];
			if ($time_before1 == 1) $time_before_days = "1";
			else					$time_before_days = "".$time_before1."";
		}
		return $time_before_days;
	}

	include "function_add_to_newsletter.php";	// Send newsletter
	include "function_show_deal.php";
	include "function_show_more_deals.php";

	/* --------------------------
	--------- Pelecard ----------
	-------------------------- */

	define('goodUrl', 'http://www.buy10.co.il/charge_good.php');
	define('errorUrl', 'http://www.buy10.co.il/charge_bad.php');
	define('maxPayments', '1');
	define('minPaymentsNo', '1');
	define('logo', 'https://order-secure.com/logos/buy10_big.png');
	define('smallLogo', 'https://order-secure.com/logos/buy10.png');

	define('Theme', '3'); 
								/*
									0 - אפור
									1 - שחור
									2 - כחול
									3 - ירוק
									4 - סגול
									5 - אדום
									6 - צהוב
								*/

	define('Background', '6b6b6b'); 

	define('pele_user', 'PeleTest');
	define('pele_pass', 'Pelecard@Test');
	define('pele_numb', '0962210');
	define('text2', ''); 
	define('text3', ''); 
	define('text4', ''); 
	define('text5', ''); 


?>