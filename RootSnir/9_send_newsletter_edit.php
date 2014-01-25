<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! add\edit newsletter list ! ..                                              *
*********************************************************************************  */

	// ------------- // 
	// -- defines -- //
	// ------------- // 
	$color = 9;
	
	// -------------- // 
	// -- includes -- //
	// -------------- // 
	include "header.php";
	include "right_menu.php";
	include "main_menu.php";

	opensql();

		$selected_id = $HTTP_GET_VARS['id'];

		// ------------------------------------ //
		// -------- Add or update deal -------- //
		// ------------------------------------ //
		$is_set = '';
		if ($_POST['set'] != NULL)
		{

			$days = $_POST['deal_end_date'];
			$end_date  = mktime(0, 0, 0, date("m") , date("d")+$days, date("Y"));
			$end_date  = date("d-m-Y", $end_date);

			// ------------------------ //
			// ---- generate deals ---- //
			// ------------------------ //
			$total_a = $_POST['total_deals'];
			$d_string = ',';
			for ($i=0;$i<$total_a;$i++)
			{
				if ($_POST['deal'.$i.''] == "on")
				{
					$d_string = ''.$d_string.''.$_POST['deal_reg'.$i.''].',';
				}
			}

			$start_date = ''.$_POST['day'].'-'.$_POST['month'].'-'.$_POST['year'].'';
			$start_hour = ''.$_POST['hour'].':'.$_POST['minute'].'';

			$is_set = ' - עודכן בהצלחה!';

			// --------------------- //
			// ---- Add product ---- //
			// --------------------- //
			if ($_POST['set'] == 1)
			{
				mysql_query("INSERT INTO `Coupons_Send_Newsletter` VALUES ( NULL , 
				'1',
				'".$d_string."',
				'".$_POST['subject']."',
				'".$start_date."',
				'".$start_hour."',
				'0',
				'0',
				'".$_POST['pending_to_send']."');");
			}

			// ------------------------ //
			// ---- update product ---- //
			// ------------------------ //
			else
			{
				mysql_query("UPDATE `Coupons_Send_Newsletter` SET 
				`deals_id`		= '".$d_string."',
				`subject`		= '".$_POST['subject']."',
				`start_date`	= '".$start_date."',
				`start_hour`	= '".$start_hour."' WHERE `Coupons_Send_Newsletter`.`id` =".$selected_id.";");
			}


					// Optimize sql!
					mysql_query("OPTIMIZE TABLE `Coupons_Send_Newsletter`");
						mysql_query("REPAIR TABLE `Coupons_Send_Newsletter`");
							mysql_query("ANALYZE TABLE `Coupons_Send_Newsletter`");

		}

		// --------------------------------------- //
		// -------- Select Deals from SQL -------- //
		// --------------------------------------- //
		$result = mysql_query("SELECT * FROM `Coupons_Deals` WHERE `deal_status`='0' OR `deal_status`='1' ORDER BY `deal_id` DESC");
		$total_deals_to_send  = mysql_num_rows($result); 
		for ($i=0;$i<$total_deals_to_send;$i++)
		{
			$deal_id[$i]			= mysql_result($result, $i, "deal_id");
			$deal_name[$i]			= mysql_result($result, $i, "deal_name");

				$deal_name_str = strlen($deal_name[$i]);
					if ($deal_name_str > 60)
					{
						$temp_name = '';
						$deal_exp = explode(" ", $deal_name[$i]);
						for ($z=0;$z<15;$z++)
						{
							$temp_name = ''.$temp_name.''.$deal_exp[$z].' ';
						}
						$deal_name[$i] = $temp_name;
						$deal_name[$i] = ''.$deal_name[$i].'...';
					}

			$deal_is_newsletter[$i]	= mysql_result($result, $i, "deal_is_newsletter");
		}

		// ------------------------------------------------- //
		// -------- Select Newsletter list from SQL -------- //
		// ------------------------------------------------- //
		$result = mysql_query("SELECT * FROM `Coupons_Send_Newsletter` WHERE `id`='".$selected_id."' LIMIT 1;");
		$if_exsist = mysql_num_rows($result);
		if ($if_exsist == 1)
		{
			$newsletter_deals_id			= mysql_result($result, 0, "deals_id");
			$newsletter_subject				= mysql_result($result, 0, "subject");
				if (($newsletter_subject == "2") || ($newsletter_subject == "3"))
					echo '<script type="text/javascript">window.location = "9_send_newsletter.php";</script>';

			$newsletter_start_date			= mysql_result($result, 0, "start_date");	$date_exp = explode("-", $newsletter_start_date);
			$newsletter_start_hour			= mysql_result($result, 0, "start_hour");	$hour_exp = explode(":", $newsletter_start_hour);
				$top_text = 'עדכן ניוזלטר';
		}

		else
		{
			$top_text = 'הוסף ניוזלטר';
		}

	closesql();

?>

 <style>
  table,tr,td { direction:rtl; text-align:right; }
  div.cat { background-color:#ebebeb; height:30px; line-height:30px; padding-right:10px; width:700px; }
  div.spacer { padding-top:10px; }
 </style>

	 <div class="content-box column-left1">		
	  
	  <!-- top menu --><div class="content-box-header"><h3><?=$top_text;?><?=$is_set;?></h3></div><!-- end of top menu -->

<script>
function checkform ( form )
{

	if (form.subject.value == '')	{ alert( "חובה להזין Subject למייל." ); form.subject.focus(); return false ; }
	if (form.day.value == '')		{ alert( "חובה להזין יום." ); form.day.focus(); return false ; }
	if (form.month.value == '')		{ alert( "חובה להזין חודש." ); form.month.focus(); return false ; }
	if (form.year.value == '')		{ alert( "חובה להזין שנה." ); form.year.focus(); return false ; }
	if (form.minute.value == '')	{ alert( "חובה להזין דקות" ); form.minute.focus(); return false ; }
	if (form.hour.value == '')		{ alert( "חובה להזין שעה." ); form.hour.focus(); return false ; }

  return true ;
}
</script>

	  <!-- add\edit deal -->
	   <form method="post" onsubmit="return checkform(this);">
	    <input type="hidden" name="set" value="<?=$if_exsist+1;?>">
        <div style="padding:20px;">
       
		<!-- 1 -> Subject of the mail -->
		 <ul style="display:table; width:730px; padding:0px; margin:0px;">
		  <li style="float:right; text-align:right; background-image: none;"><div style="padding-top:10px;"></div><b>Subject המייל:</b></li>
		  <li style="float:left; text-align:left; background-image: none; line-height:20px;">
		   <textarea style="width:600px; height:15px; overflow: hidden;" name="subject" rows="1"><?=$newsletter_subject;?></textarea>
		  </li>
		 </ul>
		<!-- end of Subject of mail -->

		<!-- 2 -> Select Deals -->
		 <input type="hidden" name="total_deals" value="<?=$total_deals_to_send;?>">
		 <ul style="display:table; width:730px; padding:0px; margin:0px;">
		  <li style="float:right; text-align:right; background-image: none;"><div style="padding-top:10px;"></div><b>בחר דילים:</b></li>
		  <li style="float:right; text-align:right; background-image: none; line-height:20px; padding-right:30px;">
		   <?
			for ($i=0;$i<$total_deals_to_send;$i++)
			{

				$pattern = '/,'.$deal_id[$i].',/';
				preg_match($pattern, $newsletter_deals_id, $matches, PREG_OFFSET_CAPTURE);

				if ($matches[0][0] == ','.$deal_id[$i].',')
					echo '<input name="deal'.$i.'" type="checkbox" checked> '.$deal_name[$i].' <span style="color:blue;"> - נשלח '.$deal_is_newsletter[$i].' פעמים</span><br>';

				else
					echo '<input name="deal'.$i.'" type="checkbox"> '.$deal_name[$i].' <span style="color:blue;"> - נשלח '.$deal_is_newsletter[$i].' פעמים</span><br>';

				echo '<input type="hidden" name="deal_reg'.$i.'" value="'.$deal_id[$i].'">';

			}
		   ?>
		  </li>
		 </ul>
		<!-- end of Select Deals -->

		<!-- 3 -> Date to send -->
		 <div style="padding-top:10px;"></div>
		 <ul style="display:table; width:730px; padding:0px; margin:0px;">
		  <li style="float:right; text-align:right; background-image: none;"><div style="padding-top:10px;"></div><b>לשלוח בתאריך:</b></li>
		  <li style="float:right; text-align:right; background-image: none; line-height:20px; padding-right:8px;">
		   
           <!-- day -->
           <select name="day" style="width:100px;">
		    <option value="">יום</option>
			<?
			for ($i=1;$i<32;$i++)
			{
				$z = $i;
				if ($i<10) $z = '0'.$i.'';

				$flag = 0;
				if ($date_exp[0] == $z)
				{
					echo '<option value="'.$z.'" SELECTED>'.$z.'</option>';
					$flag = 1;
				}
				if ($flag == 0)
				{
					if (($date_exp[0] == NULL) && (date("d") == $z))
						echo '<option value="'.$z.'" SELECTED>'.$z.'</option>';
					else
						echo '<option value="'.$z.'">'.$z.'</option>';
				}
			}
			?>
		   </select>
		   
            <!-- month -->
            <select name="month" style="width:100px;">
		    <option value="">חודש</option>
			<?
			for ($i=1;$i<13;$i++)
			{
				$z = $i;
				if ($i<10) $z = '0'.$i.'';

				$flag = 0;
				if ($date_exp[1] == $z)
				{
					echo '<option value="'.$z.'" SELECTED>'.$z.'</option>';
					$flag = 1;
				}
				if ($flag == 0)
				{
					if (($date_exp[1] == NULL) && (date("m") == $z))
						echo '<option value="'.$z.'" SELECTED>'.$z.'</option>';
					else
						echo '<option value="'.$z.'">'.$z.'</option>';
				}
			}
			?>
		   </select>
           
           <!-- year -->
		   <select name="year" style="width:100px;">
		    <option value="">שנה</option>
			<?
			for ($i=2012;$i<2100;$i++)
			{
				$z= $i;

				$flag = 0;
				if ($date_exp[2] == $z)
				{
					echo '<option value="'.$z.'" SELECTED>'.$z.'</option>';
					$flag = 1;
				}
				if ($flag == 0)
				{
					if (($date_exp[2] == NULL) && (date("Y") == $z))
						echo '<option value="'.$z.'" SELECTED>'.$z.'</option>';
					else
						echo '<option value="'.$z.'">'.$z.'</option>';
				}
			}
			?>
		   </select>
		   התאריך היום: <?=date("d-m-Y");?>
		  </li>
		 </ul>
		<!-- end of Date to send -->

		<!-- 4 -> Hour to send -->
		 <ul style="display:table; width:730px; padding:0px; margin:0px;">
		  <li style="float:right; text-align:right; background-image: none;"><div style="padding-top:10px;"></div><b>לשלוח בשעה:</b></li>
		  <li style="float:right; text-align:right; background-image: none; line-height:20px; padding-right:14px;">
		   
           <!-- minute -->
           <select name="minute">
		    <option value="">דקות</option>
			<?
			for ($i=0;$i<60;$i++)
			{
				$z = $i;
				if ($i<10) $z = '0'.$i.'';

				if ($hour_exp[1] == $z)
					echo '<option value="'.$z.'" SELECTED>'.$z.'</option>';
				else
					echo '<option value="'.$z.'">'.$z.'</option>';
			}
			?>
		   </select>
		   :
           <!-- hour -->
		   <select name="hour">
		    <option value="">שעות</option>
			<?
			for ($i=0;$i<25;$i++)
			{
				$z = $i;
				if ($i<10) $z = '0'.$i.'';

				if ($hour_exp[0] == $z)
					echo '<option value="'.$z.'" SELECTED>'.$z.'</option>';
				else
					echo '<option value="'.$z.'">'.$z.'</option>';

			}
			?>
		   </select>
		  </li>
		 </ul>
		<!-- end of Hour to send -->


		<div class="spacer"></div>
		<input type="submit" value="<?=$top_text;?>!" style="width:700px; padding:10px; font-weight:bold;">

        </div>
	   </form>
	 </div>

<? include "footer.php"; ?>