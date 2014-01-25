<?

/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! product functions ! ..                                                          *
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

	// ------------------- //
	// -- order id base -- //
	// ------------------- //
	function order_id($id, $today, $ip, $site)
	{ ?>
		<div style="padding-top:10px;"></div>
		<div style="background-color:#e7e7e7; padding:10px 10px 15px 10px;">
		 <h2>מספר הזמנה: <? echo $id; ?> | תאריך: <? echo $today; ?> | IP: <? echo $ip; ?> | אתר: <? echo $site; ?></h2>
		</div>
	<? }

	// ------------------- //
	// -- show products -- //
	// ------------------- //
	function show_products($products, $product, $p_count, $site)
	{ ?>
		<div style="padding-top:10px;"></div>
		<table width="610" cellpadding="0" cellspacing="0">
		 <tr height="30" style="background-color:#e7e7e7;">
		  <td width="10"></td>
		  <td>מספר</td>
		  <td>תמונה</td>
		  <td>שם</td>
		  <td>כמות</td>
		  <td>מחיר</td>
		 </tr>
			<?
			$t_p = explode('"RtB"', $products);
			for ($i=0;$i<$p_count;$i++) { $num = $i*3; $product[$i] = "".$t_p[$num].",".$t_p[$num+1].",".$t_p[$num+2].""; }

			for ($i=0;$i<$p_count;$i++)
			{ $p_data = explode(",", $product[$i]); $p_data_url = explode("<br>",file_get_contents("http://www.".$site."/p_info.php?id=".$p_data[0]."")); ?>
			  <tr height="30">
			   <td></td>
			   <td><? echo $p_data[0]; ?></td>
			   <td><a rel="<? echo $p_data_url[1]; ?>" class="preview"><img src="<? echo $p_data_url[1]; ?>" width="60" height="60" border="0"></a></td>
			   <td><? echo $p_data_url[0]; ?></td>
			   <td><? echo $p_data[1]; ?></td>
			   <td>₪<? echo $p_data[2]; ?></td>
			  </tr>
			<? }
			?>
		</table>
	<? }

	// ----------------- //
	// -- show prices -- //
	// ----------------- //
	function show_prices($pprice, $sprice, $tprice)
	{ ?>
		<div style="padding-top:10px;"></div>
		<div style="padding-left:30px; padding-top:5px; background-color:#e7e7e7; width:800px;">
		מחיר עבור מוצרים: ₪<? echo $pprice; ?> - מחיר עבור משלוח: ₪<? echo $sprice; ?> - <b style="font-size:15px;">מחיר כולל: ₪<? echo $tprice; ?></b></div>
		<br>
	<? }

	// ------------------------ //
	// -- show order details -- //
	// ------------------------ //
	function show_order_details($lname, $fname, $address, $city, $phone, $notes, $status, $c_type, $c_num, $c_exp, $c_id)
	{ ?>
		<div style="width:610px; text-align:right; font-size:15px;">
		<table width="100%"><tr>
		 <td align="right" valign="top">
		 <div style="font-weight:bold; font-size:14px;">
		<!-- Client Details -->
		שם מלא: <? echo "$lname $fname"; ?><br>
		כתובת:  <? echo "$address"; ?><br>
		עיר:    <? echo "$city"; ?><br>
		טלפון:  <? echo "$phone"; ?><br>
		 </div>
		 </td>
		 <td width="10"></td>
		 <td align="left" valign="top">
		<? if($status == "p")
		{ ?>
		<div style="font-weight:bold; font-size:14px;">
		סוג אשראי: <? echo $c_type; ?><br>
		מספר אשראי: <?echo $c_num; ?><br>
		תאריך תוקף: <? echo $c_exp; ?><br>
		ת.ז: <? echo $c_id; ?>
		</div>
		<? } ?>
		</div>
		  </td>
		 </tr>
		</table><br>
		<div style="font-weight:bold; font-size:14px;">
		 הערות הלקוח: <? echo "$notes"; ?>
		</div>
	<? }

?>