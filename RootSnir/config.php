<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! config file ! ..                                                           *
*********************************************************************************  */

	// ---------------------------------- //
	// -- generate time between orders -- //
	// ---------------------------------- //
	function generate_times($today, $added)
	{
		if ($today == $added) $time_before_days = "<b>מהיום</b>";
		else
		{
			$today_a = strtotime($today);			$added_a = strtotime($added);
			$time_before = $today_a - $added_a;		$time_before1 = $time_before/86400;
			$time_before1 = explode(".", $time_before1);
			$time_before1 = $time_before1[0];
			if ($time_before1 == 1) $time_before_days = "<b>אתמול</b>";
			else $time_before_days = "לפני ".$time_before1." ימים";
		}
		return $time_before_days;
	}


	// ----------------------------- //
	// -- generate time - numbers -- //
	// ----------------------------- //
	function generate_numbers($today, $added)
	{
		if ($today == $added) $time_before_days = "0";
		else
		{
			$today_a = strtotime($today);			$added_a = strtotime($added);
			$time_before = $today_a - $added_a;		$time_before1 = $time_before/86400;
			$time_before1 = explode(".", $time_before1);
			$time_before1 = $time_before1[0];
			if ($time_before1 == 1) $time_before_days = "1";
			else $time_before_days = $time_before1;
		}
		return $time_before_days;
	}

?>