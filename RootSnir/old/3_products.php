<?php

/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! redpoint products page ! ..                                                *
*********************************************************************************  */

	// --------------- //
	// --- defines --- //
	// --------------- //
	$color = 3;
	define('products_per_page', '50');

	// ---------------- //
	// --- includes --- //
	// ---------------- //
	include "header.php";
	include "right_menu.php";
	include "main_menu.php";
	include "3_functions.php";

	// --------------------- //
	// --- status & page --- //
	// --------------------- //
	$status = $HTTP_GET_VARS['status'];
		if ($status == NULL)
			$status = "active";
	$page = $HTTP_GET_VARS['page'];
		if ($page == NULL)
			$page = 1;

	// ----------------- //
	// --- functions --- //
	// ----------------- //
	opensql_redpoint();

	$status_top_text	= generate_top_text($status);
	$total_orders		= generate_count_procuts();
						  show_first_div($status,$total_orders, $admin);
	$sql_line			= generate_sql_line($status,$_POST['search'],$_POST['string']);
	$count_now			= generate_counter($sql_line);
	$result_array		= generate_results($page, $count_now);
						  show_top_navigator($status_top_text,$result_array, $count_now);

?>

		<!-- style -->
		<style>
			#preview{
			position:absolute;
			border:1px solid #ccc;
			background:#333;
			padding:2px;
			display:none;
			color:#fff;
			}
		</style>
		<script src="images/main.js" type="text/javascript"></script>

		<!-- notice -->
       <div class="notification information png_bg">
        <a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="סגור" alt="close" /></a>
        <div>על מנת לצפות בתמונה של המוצר עבור על שם המוצר או היכנס לעמוד המוצר..</div>
       </div> 

		<table dir="rtl">
		<!-- first tr -->
		<tr height="15">
		 <td style="text-align:right;" width="30">מספר</td>
		 <td style="text-align:right;" width="90">SKU</td>
		 <td style="text-align:right;" width="40">קישור</td>
		 <td style="text-align:right;">שם</td>
		 <td style="text-align:right;" width="30">פעיל?</td>
		 <td style="text-align:right;" width="30">עלות מוצר</td>
		 <td style="text-align:right;" width="30">שינוי עלות</td>
		 <? if ($admin == 1) { ?>
		  <td style="text-align:right;" width="30">מחיר בחנות</td>
		  <td style="text-align:right;" width="30">מחיר באתר</td>
		  <td style="text-align:right;" width="30">רווח משוער</td>
		  <td style="text-align:right;" width="30">עדכון מחירים</td>
		 <? } ?>
		</tr>

		<?
		// -------------------- //
		// --- sql by pages --- //
		// -------------------- //
		if (products_per_page < $count_now)
		{
		 $total_pages_t = ($count_now/products_per_page)+1;
		 $total_pages_exp = explode(".", $total_pages_t);
		 $total_pages = $total_pages_exp[0];
		 if ($page == 1)	$start_for_sql = 0;
		 else				$start_for_sql = ($page-1)*products_per_page;
		 $result = mysql_query("$sql_line LIMIT ".$start_for_sql.",".products_per_page.";");
		}
		else
		{	
			$result = mysql_query("$sql_line LIMIT ".products_per_page.";");
		}
		
		// ------------------- //
		// --- sql parsing --- //
		// ------------------- //
		// echo '<div style="text-align:left; direction:ltr;">'.$sql_line.'</div>';

		$count = mysql_num_rows($result);
		for ($i=0;$i<$count;$i++)
		{
		 $id			= mysql_result($result,$i,"entity_id");
		 $sku			= mysql_result($result,$i,"sku");
		 $url_path		= mysql_result($result,$i,"url_path");
		 $p_name		= mysql_result($result,$i,"name");
		 $small_image	= mysql_result($result,$i,"small_image");
		 $price			= mysql_result($result,$i,"price");
		 $special_price	= mysql_result($result,$i,"special_price");
		 $rprice		= mysql_result($result,$i,"rprice");
		 
		 $revah = $special_price-$rprice; // our revah

		 // --------------------- //
		 // --- active or not --- //
		 // --------------------- //
			if (($special_price != 0) && ($price != 0)) $active_status = '<img src="resources/images/icons/tick_circle.png">';
			if (($price != 0) && ($special_price == 0)) $active_status = '<img src="resources/images/icons/cross.png">';
			if (($special_price == 0) && ($price == 0)) $active_status = '<img src="resources/images/icons/information.png">';

		 ?>
		<tr dir="rtl">
		 <td style="text-align:right;"><? echo $id; ?></td>
		 <td style="text-align:right;"><? echo $sku; ?></td>
		 <td style="text-align:right;"><a href="http://www.sticash.com/ref.php?url=http://www.redpoint.co.il/<? echo $url_path; ?>" target="_blank">לחץ כאן</a></td>
		 <td style="text-align:right;">
		  <a rel="http://www.redpoint.co.il/products/<? echo $small_image; ?>" class="preview" style="color:#000000;"><? echo $p_name; ?></a>
		  <? if ($admin == 1) { ?> <a class="various" href="3_products_edit_full.php?id=<? echo $id; ?>"><img src="resources/images/icons/pencil.png" border="0"></a> <? } ?>
		 </td>
		 <td style="text-align:center;"><? echo $active_status; ?></td>
		 <td style="text-align:right;">₪<? echo $rprice; ?></td>
		 <td style="text-align:right;"><a class="various_small" href="3_products_edit_cost.php?id=<? echo $id; ?>"><img src="resources/images/icons/pencil.png" border="0"></a></td>
		 <? if ($admin == 1) { ?>
		 <td style="text-align:right;">₪<? echo $price; ?></td>
		 <td style="text-align:right;">₪<? echo $special_price; ?></td>
		 <td style="text-align:right;<? if ($revah < 50) echo 'background-color:#ff0000; color:#000000;'; ?>"><b>₪<? echo $revah; ?></b></td>
		 <td style="text-align:right;"><a class="various_small" href="3_products_edit_prices.php?id=<? echo $id; ?>"><img src="resources/images/icons/pencil.png" border="0"></a></td>
		 <? } ?>
		</tr>
		 <?
		}
		closesql_redpoint();
		?>
	 </table>

	<? 
	 // ------------------- //
	 // --- sql parsing --- //
	 // ------------------- //
	 show_pages($total_pages, $page,$status); 
	?>

   </div>
  </div>
 </div>
<? include "footer.php"; ?>