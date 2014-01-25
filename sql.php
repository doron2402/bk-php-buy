<?

/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! Sql + logs ! ..                                                            *
*********************************************************************************  */

	// ---------------- //
	// -- system Sql -- //
	// ---------------- //
	define("MYSQL_USER","buycoil_user");
	define("MYSQL_SERVER","localhost");
	define("MYSQL_PASS", "wkYoge4x");
	define("MYSQL_DB", "buycoil_buy10");
	define("Dbhost", MYSQL_SERVER);
	define("Dbuser", MYSQL_USER);
	define("Dbpass", MYSQL_PASS);
	define("Dbname", MYSQL_DB);

	function opensql() 
	{ 
		mysql_connect(Dbhost,Dbuser,Dbpass); 
		mysql_select_db(Dbname); 
		mysql_query("SET NAMES 'utf8'"); 
	}
	function closesql() { mysql_close(); }

	$Company_site = 'Buy10';
	$Company_name  = 'buy10.co.il';

	$buy_page_meta_title		= 'הזמנת קופון';
	$buy_page_meta_description	= 'הזמנת קופון';
	$buy_page_meta_keywords		= 'הזמנת קופון';

?>