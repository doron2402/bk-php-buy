<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! reports of orders ! ..                                                     *
*********************************************************************************  */

	// defines
	$color = 5;
	
	$total_m = $HTTP_GET_VARS['total'];
	if ($total_m == NULL) define('total_months', 5);
	else				  define('total_months', $total_m);

	// includes
	include "header.php";
	include "right_menu.php";
	include "main_menu.php";

	// --------- make sql line ------------ //
	function get_sql_line($date_tab)
	{

		if ($date_tab == 0) $date_now = date("m-d-y");
		else
		{
			$date_tab_gen = $date_tab-1;
			$date_now = date("m-d-y", strtotime("-".$date_tab_gen." month"));
		}
		$date_exp = explode("-", $date_now);

		$string = '';
		for ($i=1;$i<32;$i++)
		{
			if ($i<10)	$string = ''.$string.'`date`="'.$date_exp[0].'-0'.$i.'-'.$date_exp[2].'" OR ';
			else		$string = ''.$string.'`date`="'.$date_exp[0].'-'.$i.'-'.$date_exp[2].'" OR ';
		}
		$string = substr($string, 0, -3);
		$sql_line = "SELECT * FROM `orders` WHERE (".$string.") AND `status` = 'c' ORDER BY id DESC";
			return $sql_line; 
	}

	// --------- make sql line for cash ------------ //
	function get_sql_line2($date_tab)
	{

		if ($date_tab == 0) $date_now = date("m-d-y");
		else
		{
			$date_tab_gen = $date_tab-1;
			$date_now = date("m-d-y", strtotime("-".$date_tab_gen." month"));
		}
		$date_exp = explode("-", $date_now);

		$string = '';
		for ($i=1;$i<32;$i++)
		{
			if ($i<10)	$string = ''.$string.'`date`="'.$date_exp[0].'-0'.$i.'-'.$date_exp[2].'" OR ';
			else		$string = ''.$string.'`date`="'.$date_exp[0].'-'.$i.'-'.$date_exp[2].'" OR ';
		}
		$string = substr($string, 0, -3);
		$sql_line = "SELECT * FROM `cash` WHERE (".$string.") ORDER BY id DESC";
			return $sql_line; 
	}

	// --------- only admin ------------ //
	if ($admin == 1) {
?>


     <div class="content-box column-left1">		
      <div class="content-box-header">
	   <h3>דוחות</h3>
	   <ul class="content-box-tabs">
        <li><a href="?total=5"<? if (total_months == "5") echo ' class="default-tab" style="color:#0084ff; font-weight:bold;"'; ?>>5 חודשים אחורה</a></li>
        <li><a href="?total=10"<? if (total_months == "10") echo ' class="default-tab" style="color:#0084ff; font-weight:bold;"'; ?>>10 חודשים אחורה</a></li>
        <li><a href="?total=15"<? if (total_months == "15") echo ' class="default-tab" style="color:#0084ff; font-weight:bold;"'; ?>>15 חודשים אחורה</a></li>
        <li><a href="?total=20"<? if (total_months == "20") echo ' class="default-tab" style="color:#0084ff; font-weight:bold;"'; ?>>20 חודשים אחורה</a></li>
        <li><a href="?total=25"<? if (total_months == "25") echo ' class="default-tab" style="color:#0084ff; font-weight:bold;"'; ?>>25 חודשים אחורה</a></li>
        <li><a href="?total=30"<? if (total_months == "30") echo ' class="default-tab" style="color:#0084ff; font-weight:bold;"'; ?>>30 חודשים אחורה</a></li>
       </ul>
	  </div>
	   <div class="content-box-content">

     <div class="notification information png_bg">
      <a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="סגור" alt="close" /></a>
      <div>
	   מספר ההזמנות והסכומים לא כוללים את המזומן!!!
	   על מנת לחשב את הסכום הכולל יש לעשות את הסכום + המזומן!!!
	  </div>
     </div> 

	    <div class="tab-content default-tab">
		 <div style="padding:0px 20px 0px 20px;">
		  <div style="padding-top:10px;"></div>
		   <table>
		    <tr>
			 <td></td>
			 <td style="text-align:right;">סה"כ הזמנות</td>
			 <td style="text-align:right;">סה"כ מכירות</td>
			 <td style="text-align:right;">סה"כ עלות</td>
			 <td style="text-align:right;" width="70">סה"כ רווח</td>
			 <td style="text-align:right;" width="140">סה"כ רווח ללא מע"מ</td>
			 <td style="text-align:right;" width="70">להוסיף מזומן</td>
			</tr>
			<? 
				opensql();

					// ------------------- //
					// -- Generate data -- //
					// ------------------- //
					for ($i=1;$i<=total_months;$i++)
						$month[$i] = get_sql_line($i);
	
					for ($i=1;$i<=total_months;$i++)
					{
						$l = $i-1;

						$month_text[$i] = "לפני ".$l." חודשים";
						if ($i == 1) $month_text[$i] = "החודש";
						if ($i == 2) $month_text[$i] = "חודש שעבר";

						$count_now = str_replace("SELECT * FROM ", "SELECT COUNT(*) FROM", $month[$i]); 
							$count_now = mysql_query($count_now);
								$count_now = mysql_fetch_array($count_now);
									$total_count[$i] = $count_now[0];
							
						$result = mysql_query($month[$i]);
						$exsist = mysql_num_rows($result);
						$count_total_price[$i] = 0;
						$count_cost_price[$i] = 0;
						for ($q=0;$q<$exsist;$q++)
						{
							$tprice = mysql_result($result,$q,"t_price");
							$cost = mysql_result($result,$q,"cost");

							$count_total_price[$i] = $count_total_price[$i]+$tprice;	// total price
							$count_cost_price[$i] = $count_cost_price[$i]+$cost;		// cost price
						}

						$count_per_order[$i] = $count_total_price[$i]/$total_count[$i];		// avg for order
								$count_per_order[$i] = explode(".", $count_per_order[$i]);
										$count_per_order[$i] = $count_per_order[$i][0];

						$avg[$i] = ($count_cost_price[$i]*100)/$count_total_price[$i];
								$avg[$i] = explode(".", $avg[$i]);
										$avg[$i] = $avg[$i][0];							// avg alot

						$revah[$i] = $count_total_price[$i]-$count_cost_price[$i];			// our revah

						$revah_maam[$i] = ($revah[$i]*0.84);							// revah withouth %16.
								$revah_maam[$i] = explode(".", $revah_maam[$i]);
										$revah_maam[$i] = $revah_maam[$i][0];		
						
						// --------------- Cash -------------- //
						$cash[$i] = get_sql_line2($i);
						$result = mysql_query($cash[$i]);
						$exsist = mysql_num_rows($result);
						$total_cash[$i] = 0;
						for ($q=0;$q<$exsist;$q++)
						{
							$total = mysql_result($result,$q,"total");
							$total_cash[$i] = $total_cash[$i]+$total;
						}
					}

					// ----------------- //
					// -- write table -- //
					// ----------------- //
					for ($i=1;$i<=total_months;$i++)
					{

						$l = $i+1;

						$total_orders_jpg ='';
						$count_total_price_jpg = '';
						$count_per_order_jpg = '';		
						$count_cost_price_jpg = '';
						$avg_jpg = '';
						$revah_jpg = '';
						$revah_maam_jpg = '';

						if ($total_count[$l] != 0)
						{
							if ($total_count[$i] > $total_count[$l])			 $total_orders_jpg = '<img src="resources/images/up.jpg">';
																				 else $total_orders_jpg = '<img src="resources/images/down.jpg">';
						
							if ($count_total_price[$i] > $count_total_price[$l]) $count_total_price_jpg = '<img src="resources/images/up.jpg">';
																				 else $count_total_price_jpg = '<img src="resources/images/down.jpg">';

							if ($count_per_order[$i] > $count_per_order[$l])	 $count_per_order_jpg = '<img src="resources/images/up.jpg">';
																				 else	$count_per_order_jpg = '<img src="resources/images/down.jpg">';

							if ($count_cost_price[$i] > $count_cost_price[$l])	 $count_cost_price_jpg = '<img src="resources/images/up.jpg">';
																				 else	$count_cost_price_jpg = '<img src="resources/images/down.jpg">';

							if ($avg[$i] > $avg[$l])							 $avg_jpg = '<img src="resources/images/up.jpg">';
																				 else	$avg_jpg = '<img src="resources/images/down.jpg">';

							if ($revah[$i] > $revah[$l])						 $revah_jpg = '<img src="resources/images/up.jpg">';
																				 else	$revah_jpg = '<img src="resources/images/down.jpg">';

							if ($revah_maam[$i] > $revah_maam[$l])				 $revah_maam_jpg = '<img src="resources/images/up.jpg">';
																				 else	$revah_maam_jpg = '<img src="resources/images/down.jpg">';
						}

						echo '<tr>';
						echo '<td style="text-align:right;">'.$month_text[$i].'</td>';
						echo '<td style="text-align:right;">'.$total_count[$i].' '.$total_orders_jpg.'</td>';
						echo '<td style="text-align:right;">₪'.$count_total_price[$i].' '.$count_total_price_jpg.' (ממוצע ₪'.$count_per_order[$i].' להזמנה '.$count_per_order_jpg.')</td>';
						echo '<td style="text-align:right;">₪'.$count_cost_price[$i].' '.$count_cost_price_jpg.' (עלות ממוצעת: '.$avg[$i].'% '.$avg_jpg.')</td>';
						echo '<td style="text-align:right; font-weight:bold;">₪'.$revah[$i].' '.$revah_jpg.'</td>';
						echo '<td style="text-align:right; font-weight:bold;">₪'.$revah_maam[$i].' '.$revah_maam_jpg.'</td>';
						echo '<td style="text-align:right; font-weight:bold;">₪'.$total_cash[$i].'</td>';	// cash
						echo '</tr>';
					}

				closesql();
			?>
		 </table>
        </div>
       </div>
      </div>
	 </div>

<? } include "footer.php"; ?>