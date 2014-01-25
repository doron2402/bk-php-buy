<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! xdeals.co.il functions ! ..                                                *
*********************************************************************************  */


	// ----------------
	// Add new deal
	// ----------------
	function add_new_deal($add)
	{
		if ($add == "1")
		{
			mysql_query("
			INSERT INTO `dreamsol_toysil`.`Xdeals` ( `id` , `active` , `product_id` , `reg_price` , `our_price` , `rprice` , `end_date` , `deal_name` , `deal_name_left` , `full_text` , `mifrat` , `image` , `buyers`) VALUES (NULL , '0', '0', '0', '0', '0', '', 'ממתין..', 'ממתין..', '', '', '0', '');");
			echo '<script type="text/javascript">window.location = "zxz_7_xdeals.php"</script>';
		}
	}

	// ----------------
	// Count of deals
	// ----------------
	function check_counters()
	{

		$line[0] = "SELECT * FROM `Xdeals` WHERE active='1'";
		$line[1] = "SELECT * FROM `Xdeals` WHERE active='2'";
		$line[2] = "SELECT * FROM `Xdeals` WHERE active='0'";

		for ($i=0;$i<3;$i++)
		{
			$count_now = str_replace("SELECT * FROM ", "SELECT COUNT(*) FROM ", $line[$i]);
				$count_now = mysql_query($count_now); $count_now = mysql_fetch_array($count_now); $total_orders[$i] = $count_now[0];
					if ($total_orders[$i] == NULL) $total_orders[$i] = 0;
		}

		return $total_orders; 

	}

	// --------------------------
	// Show header for pages 
	// --------------------------
	function show_header()
	{

		echo '
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
		<center>';

	}

	// --------------------------
	// Generate time
	// --------------------------
	function generate_times($today, $added)
	{
		if ($today == $added) $time_before_days = "<b>1</b>";
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

	// --------------------------
	// Select product
	// --------------------------
	function select_product($pro)
	{ 
		// get list of active products from redpoint
		opensql_redpoint();
			$result = mysql_query("SELECT * FROM `products` WHERE `price`!=0 AND `special_price`!=0 ORDER BY `entity_id` DESC;");
			$exsist = mysql_num_rows($result);
			for ($i=0;$i<$exsist;$i++)
			{
				$pro_name[$i] = mysql_result($result,$i,"name");
				$pro_id[$i] = mysql_result($result,$i,"entity_id");
			}
		closesql_redpoint();

		// check num of uses
		opensql();
			for ($i=0;$i<$exsist;$i++)
			{
				$result = mysql_query("SELECT * FROM `Xdeals` WHERE `product_id`=".$pro_id[$i].";");
				$count[$i] = mysql_num_rows($result);
			}
		closesql();
	?>
		<div style="padding-top:10px;"></div><center>
		 <h1>שלב 1 > בחר מוצר לליד #<? echo $pro['deal']; ?></h1>
		
		 <form method="post" action="">
		  <input type="hidden" name="update_product" value="1">
		    
			<select name="product">
			 <option value="0"></option>
			 <?
			  for ($i=0;$i<$exsist;$i++)
			  {
				if ($count[$i] == 0)
					echo '<option value="'.$pro_id[$i].'">'.$pro_name[$i].'</option>';
				else
				{
					if ($count[$i] < 5) $option_bg_color = '00aeff';
					if ($count[$i] > 10) $option_bg_color = 'ff9c00';
					if ($count[$i] > 20) $option_bg_color = 'ff2a00';
					if ($count[$i] > 30) $option_bg_color = '5a00ff';
					echo '<option style="background-color:#'.$option_bg_color.';" value="'.$pro_id[$i].'">'.$pro_name[$i].' | הופיע '.$count[$i].' פעמים</option>';
				}
				echo "\n";
			  }
			 ?>
			</select><br><br>
			<input type="submit" value="בחר מוצר!" style="padding:5px;">

		</center></form>
	<? }

	// --------------------------
	// Update product to db
	// --------------------------
	function update_product_in_db($pro_id, $id)
	{

		// parse data from redpoint
		opensql_redpoint();
			$result = mysql_query("SELECT * FROM `products` WHERE `entity_id`='".$pro_id."' LIMIT 1;");
				$name		= mysql_result($result,0,"name");
				$reg_price  = mysql_result($result,0,"price");
				$rprice		= mysql_result($result,0,"rprice");
				$taktzir    = mysql_result($result,0,"taktzir");
						$taktzir = str_replace("'", "", $taktzir);
						$taktzir = str_replace("\r\n", " ", $taktzir);
						$taktzir = str_replace("\n", " ", $taktzir);
						$taktzir = str_replace("\r", " ", $taktzir);

				$params		= mysql_result($result,0,"params");
						$params = str_replace("'", "", $params);
						$params = str_replace("\r\n", " ", $params);
						$params = str_replace("\n", " ", $params);
						$params = str_replace("\r", " ", $params);

				$image		= mysql_result($result,0,"small_image");

		closesql_redpoint();

		// update xdeals database
		opensql();

			mysql_query("UPDATE `Xdeals` SET 
			`product_id` = '".$pro_id."',
			`reg_price` = '".$reg_price."',
			`rprice` = '".$rprice."',
			`deal_name` = '".$name." במחיר חסר תקדים!',
			`deal_name_left` = '".$name."',
			`full_text` = '".$taktzir."',
			`mifrat` = '".$params."',
			`image` = '".$image."'
			WHERE `Xdeals`.`id` =".$id." LIMIT 1 ;");
				mysql_query("OPTIMIZE TABLE `Xdeals`");
					mysql_query("REPAIR TABLE `Xdeals`");
						mysql_query("ANALYZE TABLE `Xdeals`");

		closesql();

		add_to_logs("XDEALS - נבחר מוצר לדיל #".$id." - #".$pro_id." - ".$name."");

		echo '<h1>המוצר נבחר בהצלחה!<br><br>
		<a href="zxz_7_xdeals_edit.php?id='.$id.'" style="color:#000000;">>> המשך לשלב הבא</a></h1>';
	}


	// --------------------------
	// Show deal form
	// --------------------------
	function show_deal_form($pro)
	{ ?>
	
		<!-- CKeditor -->
		<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
		<script src="ckeditor/_samples/sample.js" type="text/javascript"></script>
		<link href="ckeditor/_samples/sample.css" rel="stylesheet" type="text/css" />

		<script>
		function checkform ( form )
		{
			if ((form.active.value == '1') && (form.end.value == '0')) { alert( "חובה להזין מספר ימים לדיל!" ); form.end.focus(); return false ; }
			if ((form.active.value == '1') && (form.our.value == '0')) { alert( "חובה להזין את המחיר של המוצר אצל Xdeals!" ); form.our.focus(); return false ; }
		  return true ;
		}
		</script>
		<style>	input { font-size:12px; width:400px; } input.small { font-size:12px; width:100px; }	</style>

		<div style="padding-top:10px;"></div><center>
		 <h1>עדכן פרטי דיל #<? echo $pro['deal']; ?></h1>
		 <form method="post" action="" onsubmit="return checkform(this);">
		  <input type="hidden" name="update_deal" value="1">

		  <div style="padding:0px 20px 0px 20px;">
		  <table width="100%" cellpadding="0" cellspacing="0">
		   <tr><td align="center" valign="top">
		
		   <table><tr>
		    <td>טקסט עליון</td>		<td><input name="name" value='<? echo $pro['name']; ?>'></td></tr>
		    <td>טקטס צד שמאל</td>	<td><input name="name_left"	value='<? echo $pro['name_left']; ?>'></td></tr>
		    <td>פעיל</td><td>
			<?
			  if ($pro['active'] == 1)
			  {
			   echo '<select name="active"><option value="1" SELECTED>פעיל</option><option value="2">סיים דיל</option></select></td>';
			  }
			  if ($pro['active'] == 0)
			  {
			  echo '<select name="active">
			   <option value="0" SELECTED>ממתין..</option>
			   <option value="1">התחל דיל</option>
			  </select></td></tr><tr>
			  <td>ימים לדיל</td><td><input class="small" name="end" value=""></td>';
			  }
			  if ($pro['active'] == 2) echo 'הדיל הסתיים!</td>';
			?>
			</tr>
		    <tr height="10"></tr>
		   </table>

		   <table><tr><td>
			  עלות <input class="small" name="red" value="<? echo $pro['red']; ?>">
		      מחיר רגיל <input class="small" name="reg" value="<? echo $pro['reg']; ?>">
		      מחיר בXdeals <input class="small" name="our" value="<? echo $pro['our']; ?>">
		   </td></tr></table>

		   <br><br>תיאור מוצר<br><textarea name="full_text" id="text1"><? echo $pro['text']; ?></textarea>

			<? $p_exp = explode("<RtB>", $pro['mifrat']); ?>
			 <table cellpadding="2" cellspacing="2">
			  <tr><td valign="top"><table>
				 <tr><td>חברה</td><td><input type="text" name="p1" style="width:230px;" value='<? echo $p_exp[0]; ?>'></td></tr>
				 <tr><td>צבע</td><td><input type="text" name="p2" style="width:230px;" value='<? echo $p_exp[1]; ?>'></td></tr>
				 <tr><td>עשוי מ</td><td><input type="text" name="p3" style="width:230px;" value='<? echo $p_exp[2]; ?>'></td></tr>
				 <tr><td>אורך</td><td><input type="text" name="p4" style="width:230px;" value='<? echo $p_exp[3]; ?>'></td></tr>
			 </table></td><td valign="top"><table>
				 <tr><td>עובי</td><td><input type="text" name="p5" style="width:230px;" value='<? echo $p_exp[4]; ?>'></td></tr>
				 <tr><td>סוללות</td><td><input type="text" name="p6" style="width:230px;" value='<? echo $p_exp[5]; ?>'></td></tr>
				 <tr><td>שימוש</td><td><input type="text" name="p7" style="width:230px;" value='<? echo $p_exp[6]; ?>'></td></tr>
				 <tr><td>מתאים ל</td><td><input type="text" name="p8" style="width:230px;" value='<? echo $p_exp[7]; ?>'></td></tr>
			 </table></td></tr></table>

	      </td>
		  <td width="200" valign="top"><img src="http://www.redpoint.co.il/products/<? echo $pro['image']; ?>" width="200" height="200"></td>
		
		</tr></table></div>

		<br><br>
		<input type="submit" value="עדכן דיל!" style="padding:5px;">
           
		</center></form>

		 <script type='text/javascript'>
		  CKEDITOR.replace( 'text1',
		  { skin : 'v2', extraPlugins : 'uicolor', width : '550px', height: '100px', toolbar : [ [ 'Source', '-', 'Bold', 'Italic', 'Underline', 'Strike','-','Link', '-', 'MyButton' ] ], enterMode : CKEDITOR.ENTER_BR, shiftEnterMode: CKEDITOR.ENTER_P });
		  CKEDITOR.replace( 'text2',
		  { skin : 'v2', extraPlugins : 'uicolor', width : '550px', height: '100px', toolbar : [ [ 'Source', '-', 'Bold', 'Italic', 'Underline', 'Strike','-','Link', '-', 'MyButton' ] ], enterMode : CKEDITOR.ENTER_BR, shiftEnterMode: CKEDITOR.ENTER_P
		  });
		 </script>

	<? }

	// --------------------------
	// edit deal details
	// --------------------------
	function edit_deal($_POST, $id)
	{
		//print_r($_POST);

			$param = "param1<RtB>param2<RtB>param3<RtB>param4<RtB>param5<RtB>param6<RtB>param7<RtB>param8";
			if ($_POST['p1'] != NULL) $param = str_replace("param1", $_POST['p1'], $param);
			if ($_POST['p2'] != NULL) $param = str_replace("param2", $_POST['p2'], $param);
			if ($_POST['p3'] != NULL) $param = str_replace("param3", $_POST['p3'], $param);
			if ($_POST['p4'] != NULL) $param = str_replace("param4", $_POST['p4'], $param);
			if ($_POST['p5'] != NULL) $param = str_replace("param5", $_POST['p5'], $param);
			if ($_POST['p6'] != NULL) $param = str_replace("param6", $_POST['p6'], $param);
			if ($_POST['p7'] != NULL) $param = str_replace("param7", $_POST['p7'], $param);
			if ($_POST['p8'] != NULL) $param = str_replace("param8", $_POST['p8'], $param);
				$param = str_replace("param1", "", $param);
				$param = str_replace("param2", "", $param);
				$param = str_replace("param3", "", $param);
				$param = str_replace("param4", "", $param);
				$param = str_replace("param5", "", $param);
				$param = str_replace("param6", "", $param);
				$param = str_replace("param7", "", $param);
				$param = str_replace("param8", "", $param);

				$full = $_POST['full_text'];
				$full = str_replace('\"', '"', $full);
				$full = str_replace("\'", "'", $full);

			opensql();

				mysql_query("UPDATE `Xdeals` SET 
				`deal_name` = '".str_replace("'", "", $_POST['name'])."',
				`deal_name_left` = '".str_replace("'", "", $_POST['name_left'])."',
				`rprice` = '".$_POST['red']."',
				`reg_price` = '".$_POST['reg']."',
				`our_price` = '".$_POST['our']."',
				`full_text` = '".$full."',
				`mifrat` = '".$param."'
				WHERE `Xdeals`.`id` =".$id." LIMIT 1 ;");
					mysql_query("OPTIMIZE TABLE `Xdeals`");
						mysql_query("REPAIR TABLE `Xdeals`");
							mysql_query("ANALYZE TABLE `Xdeals`");

				if ($_POST['active'] != NULL)
					mysql_query("UPDATE `Xdeals` SET `active` = '".$_POST['active']."' WHERE `Xdeals`.`id` =".$id." LIMIT 1 ;");

				if ($_POST['end'] != NULL)
				{
					$end_date  = mktime(0, 0, 0, date("m")  , date("d")+$_POST['end'], date("Y"));
					mysql_query("UPDATE `Xdeals` SET `end_date` = '".date("m-d-y", $end_date)."' WHERE `Xdeals`.`id` =".$id." LIMIT 1 ;");
				}

					mysql_query("OPTIMIZE TABLE `Xdeals`");
						mysql_query("REPAIR TABLE `Xdeals`");
							mysql_query("ANALYZE TABLE `Xdeals`");

			closesql();

			add_to_logs("עדכון דיל #".$id."");

			echo '<h1>הדיל התעדכן בהצלחה!<br><br>
			<a href="javascript:parent.$.fancybox.close();" style="color:#000000;">>> חזרה לטבלה</a></h1>';

	}
?>