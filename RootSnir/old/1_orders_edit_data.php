<?

/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! order data ! ..                                                          *
*********************************************************************************  */

opensql();
$result = mysql_query("SELECT * FROM `orders` WHERE `id`='".$id."'");

// 0
	$today =		mysql_result($result,0,"date");
	$ip =			mysql_result($result,0,"ip");

// 1
	$fname =		mysql_result($result,0,"fname");
	$lname =		mysql_result($result,0,"lname");
	$address =		mysql_result($result,0,"address");
	$city =			mysql_result($result,0,"city");
	$phone =		mysql_result($result,0,"phone");

// 2
	$notes =		mysql_result($result,0,"notes");

// 3
	$products =		mysql_result($result,0,"products");
	$p_count =		mysql_result($result,0,"p_count");
	$site =			mysql_result($result,0,"site");

// 4
	$pprice =		mysql_result($result,0,"p_price");
	$sprice =		mysql_result($result,0,"s_price");
	$tprice =		mysql_result($result,0,"t_price");

// 5
	$c_type =		mysql_result($result,0,"c_type");
	$c_num =		mysql_result($result,0,"c_num");
	$c_exp =		mysql_result($result,0,"c_exp");
	$c_id =			mysql_result($result,0,"c_id");

// 6
	$status =		mysql_result($result,0,"status");
	$cost =			mysql_result($result,0,"cost");

closesql();

?>