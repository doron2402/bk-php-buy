<?

/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! product functions ! ..                                                     *
*********************************************************************************  */

	// ----------------- //
	// -- show header -- //
	// ----------------- //
	function show_header()
	{ ?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		 <head>
		 <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		 <style>
		  body { color:#000000; background-color:#f6f6f6; }
		  body { font-family: "Arial", "Arial (Hebrew)", "David (Hebrew)", "Courier New (Hebrew)"; font-size:12px; font-weight:normal; padding:0px; margin:0px; }
		  h1,h2,h3 { font-family: "Arial", "Arial (Hebrew)", "David (Hebrew)", "Courier New (Hebrew)"; }
		  #preview{
			position:absolute;
			border:1px solid #ccc;
			background:#333;
			padding:2px;
			display:none;
			color:#fff;
			}
		 </style>
		 <script src="images/jquery.js" type="text/javascript"></script>
		 <script src="images/main.js" type="text/javascript"></script>
		</head>
		<body dir="rtl">
		<center>
	<? }

	// ------------------------------- //
	// -- index - get products list -- //
	// ------------------------------- //
	function get_products_list()
	{
		opensql_redpoint();
			$result = mysql_query("SELECT * FROM `index` WHERE `id`='1'");
				$products = mysql_result($result,0,"products");
					$products_exp = explode(",", $products);
		closesql_redpoint();
		return $products_exp;
	}

?>