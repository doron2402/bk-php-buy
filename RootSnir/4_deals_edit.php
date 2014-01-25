<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! add\edit deals ! ..                                                        *
*********************************************************************************  */

	// ------------- // 
	// -- defines -- //
	// ------------- // 
	$color = 4;
	
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

			// ----------------------- //
			// ---- generate area ---- //
			// ----------------------- //
			$total_a = $_POST['total_area'];
			$a_string = ',';
			for ($i=0;$i<$total_a;$i++)
			{
				if ($_POST['area'.$i.''] == "on")
				{
					$a_string = ''.$a_string.''.$_POST['area_id'.$i.''].',';
				}
			}
			// --------------------------- //
			// ---- generate shipping ---- //
			// --------------------------- //
			$total_s = $_POST['total_shipping'];
			$s_string = ',';
			for ($i=0;$i<$total_s;$i++)
			{
				if ($_POST['shipping'.$i.''] == "on")
				{
					$s_string = ''.$s_string.''.$_POST['shipping_id'.$i.''].',';
				}
			}

			$is_set = ' - עודכן בהצלחה!';
			// --------------------- //
			// ---- Add product ---- //
			// --------------------- //
			if ($_POST['set'] == 1)
			{
				mysql_query("INSERT INTO `Coupons_Deals` VALUES ( NULL , 
				'".$_POST['deal_status']."',
				'0',
				'".$_POST['deal_reg_price']."',
				'".$_POST['deal_our_price']."',
				'".$_POST['deal_bill_price']."',
				'".$end_date."',
				'".$_POST['deal_min_buyers']."',
				'".$_POST['deal_name']."',
				'".$_POST['deal_name_left']."',
				'".$_POST['deal_text_1']."',
				'".$_POST['deal_text_2']."',
				'".$_POST['deal_text_3']."',
				'".$_POST['deal_image']."',
				'".$_POST['deal_real_buyers']."',
				'".$_POST['deal_fake_buyers']."',
				'".$a_string."',
				'".$s_string."',
				'".$_POST['deal_snifim']."',
				'0',
				'0',
				'".$_POST['deal_is_special']."',
				'".$_POST['deal_is_latest']."',
				'".$_POST['deal_must_shipping']."',
				'".$_POST['deal_xml_area']."',
				'".$_POST['deal_xml_category']."',
				'".$_POST['deal_xml_description']."');");
			}

			// ------------------------ //
			// ---- update product ---- //
			// ------------------------ //
			else
			{
				mysql_query("UPDATE `Coupons_Deals` SET 
				`deal_status`		= '".$_POST['deal_status']."',
				`deal_reg_price`		= '".$_POST['deal_reg_price']."',
				`deal_our_price`		= '".$_POST['deal_our_price']."',
				`deal_bill_price`		= '".$_POST['deal_bill_price']."',
				`deal_end_date`			= '".$end_date."',
				`deal_min_buyers`		= '".$_POST['deal_min_buyers']."',
				`deal_name`				= '".$_POST['deal_name']."',
				`deal_name_left`		= '".$_POST['deal_name_left']."',
				`deal_text_1`			= '".$_POST['deal_text_1']."',
				`deal_text_2`			= '".$_POST['deal_text_2']."',
				`deal_text_3`			= '".$_POST['deal_text_3']."',
				`deal_image`			= '".$_POST['deal_image']."',
				`deal_real_buyers`		= '".$_POST['deal_real_buyers']."',
				`deal_fake_buyers`		= '".$_POST['deal_fake_buyers']."',
				`deal_areas`			= '".$a_string."',
				`deal_shipping`			= '".$s_string."',
				`deal_snifim`			= '".$_POST['deal_snifim']."',
				`deal_is_special`		= '".$_POST['deal_is_special']."',
				`deal_is_latest`		= '".$_POST['deal_is_latest']."',
				`deal_xml_area`			= '".$_POST['deal_xml_area']."',
				`deal_xml_category`		= '".$_POST['deal_xml_category']."',
				`deal_xml_description`	= '".$_POST['deal_xml_description']."',
				`deal_must_shipping`    = '".$_POST['deal_must_shipping']."' WHERE `Coupons_Deals`.`deal_id` =".$selected_id.";");
			}


					// Optimize sql!
					mysql_query("OPTIMIZE TABLE `Coupons_Deals`");
						mysql_query("REPAIR TABLE `Coupons_Deals`");
							mysql_query("ANALYZE TABLE `Coupons_Deals`");

		}

		// --------------------------------- //
		// -------- Select Areas SQL -------- //
		// --------------------------------- //
		$result = mysql_query("SELECT * FROM `Coupons_Areas` ORDER BY `area_id` ASC");
		$total_areas  = mysql_num_rows($result);
		for ($i=0;$i<$total_areas;$i++)
		{
			$area_id[$i]	= mysql_result($result, $i, "area_id");
			$area_name[$i]	= mysql_result($result, $i, "area_name");
		}

		// ------------------------------------- //
		// -------- Select Shipping SQL -------- //
		// ------------------------------------- //
		$result = mysql_query("SELECT * FROM `Coupons_Shipping` ORDER BY `shipping_id` ASC");
		$total_shipping  = mysql_num_rows($result);
		for ($i=0;$i<$total_shipping;$i++)
		{
			$shipping_id[$i]	= mysql_result($result, $i, "shipping_id");
			$shipping_name[$i]	= mysql_result($result, $i, "shipping_name");
			$shipping_price[$i] = mysql_result($result, $i, "shipping_price");
		}

		// -------------------------------------- //
		// -------- Select Deal from SQL -------- //
		// -------------------------------------- //
		$result = mysql_query("SELECT * FROM `Coupons_Deals` WHERE `deal_id`='".$selected_id."' LIMIT 1;");
		$if_exsist = mysql_num_rows($result);
		if ($if_exsist == 1)
		{
		
				$deal_name				= mysql_result($result, 0, "deal_name");
				$deal_name_left			= mysql_result($result, 0, "deal_name_left");
				$deal_image				= mysql_result($result, 0, "deal_image");
				$deal_status			= mysql_result($result, 0, "deal_status");
				$deal_end_date			= mysql_result($result, 0, "deal_end_date");		$deal_end_date = generate_numbers($deal_end_date, date("d-m-Y"));
				$deal_fake_buyers		= mysql_result($result, 0, "deal_fake_buyers");
				
				$deal_areas				= mysql_result($result, 0, "deal_areas");			$deal_areas_exp = explode(",", $deal_areas);
				$deal_shipping			= mysql_result($result, 0, "deal_shipping");		$deal_shipping_exp = explode(",", $deal_shipping);

				$deal_reg_price			= mysql_result($result, 0, "deal_reg_price");
				$deal_our_price			= mysql_result($result, 0, "deal_our_price");
				$deal_bill_price		= mysql_result($result, 0, "deal_bill_price");
				$deal_min_buyers		= mysql_result($result, 0, "deal_min_buyers");

				$deal_text_1			= mysql_result($result, 0, "deal_text_1");
				$deal_text_2			= mysql_result($result, 0, "deal_text_2");
				$deal_text_3			= mysql_result($result, 0, "deal_text_3");

				$deal_is_special		= mysql_result($result, 0, "deal_is_special");
				$deal_snifim			= mysql_result($result, 0, "deal_snifim");
				$deal_is_latest			= mysql_result($result, 0, "deal_is_latest");

				$deal_must_shipping		= mysql_result($result, 0, "deal_must_shipping");

				$deal_xml_area			= mysql_result($result, 0,"deal_xml_area");
				$deal_xml_category		= mysql_result($result, 0,"deal_xml_category");
				$deal_xml_description	= mysql_result($result, 0,"deal_xml_description");

			$top_text = 'עדכן דיל';
		}

		else
		{
			$top_text = 'הוסף דיל חדש';
		}

	closesql();

?>

 <style>
  table,tr,td { direction:rtl; text-align:right; }
  div.cat { background-color:#ebebeb; height:30px; line-height:30px; padding-right:10px; width:700px; }
  div.spacer { padding-top:10px; }
 </style>

<script>
function selected(elementID)
{
	var object = document.getElementById('content' + elementID);	object.style.display = 'block';
	object = document.getElementById('contentm' + elementID);	object.style.display = 'none'

	for (x = 0; x <= 30; x++) {
		if (x.toString() != elementID) {
			var obj2 = document.getElementById('content' + x.toString());
			if (obj2 != null) {
				obj2.style.display = 'none';
				obj2 = document.getElementById('contentm' + x.toString());
				obj2.style.display = 'block'; }	} } return; }
</script>

  <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
  <script src="ckeditor/_samples/sample.js" type="text/javascript"></script>
  <link href="ckeditor/_samples/sample.css" rel="stylesheet" type="text/css" />

	 <div class="content-box column-left1">		
	  
	  <!-- top menu --><div class="content-box-header"><h3><?=$top_text;?><?=$is_set;?></h3></div><!-- end of top menu -->

	  <!-- add\edit deal -->
	   <form method="post">
	    <input type="hidden" name="set" value="<?=$if_exsist+1;?>">
        <div style="padding:20px;">
       
	    <!-- deal details -->
	    <div class="cat">טקסטים על הדיל</div><div class="spacer"></div>
		 <ul style="display:table; width:730px; padding:0px; margin:0px;">
		  <li style="float:right; text-align:right; background-image: none;"><div style="padding-top:10px;"></div><b>שם הדיל:</b></li>
		  <li style="float:left; text-align:left; background-image: none; line-height:20px;">
		   <textarea style="width:600px; height:15px; overflow: hidden;" name="deal_name" rows="1"><?=$deal_name;?></textarea>
		  </li>
		 </ul>
		 <ul style="display:table; width:730px; padding:0px; margin:0px;">
		  <li style="float:right; text-align:right; background-image: none;"><div style="padding-top:10px;"></div><b>צד שמאל:</b></li>
		  <li style="float:left; text-align:left; background-image: none; line-height:20px;">
           <textarea style="width:600px; height:15px; overflow: hidden;" name="deal_name_left" rows="1"><?=$deal_name_left;?></textarea>
		  </li>
		 </ul>
		 <div style="padding-top:5px;"></div>

	    <!-- xml details -->
	    <div class="cat">פרטים ל-XML</div><div class="spacer"></div>
		 <ul style="display:table; width:730px; padding:0px; margin:0px;">
		  <li style="float:right; text-align:right; background-image: none;"><div style="padding-top:10px;"></div>איזורים:</li>
		  <li style="float:left; text-align:left; background-image: none; line-height:20px;">
		   <textarea style="width:600px; height:15px; overflow: hidden;" name="deal_xml_area" rows="1"><?=$deal_xml_area;?></textarea>
		  </li>
		 </ul>
		 <ul style="display:table; width:730px; padding:0px; margin:0px;">
		  <li style="float:right; text-align:right; background-image: none;"><div style="padding-top:10px;"></div>קטגוריות:</li>
		  <li style="float:left; text-align:left; background-image: none; line-height:20px;">
		   <textarea style="width:600px; height:15px; overflow: hidden;" name="deal_xml_category" rows="1"><?=$deal_xml_category;?></textarea>
		  </li>
		 </ul>
		 <ul style="display:table; width:730px; padding:0px; margin:0px;">
		  <li style="float:right; text-align:right; background-image: none;"><div style="padding-top:10px;"></div>תיאור:</li>
		  <li style="float:left; text-align:left; background-image: none; line-height:20px;">
		   <textarea style="width:600px; height:15px; overflow: hidden;" name="deal_xml_description" rows="1"><?=$deal_xml_description;?></textarea>
		  </li>
		 </ul>
		 <div style="padding-top:5px;"></div>

	    <!-- deal info -->
	    <div class="cat">פרטים כלליים</div><div class="spacer"></div>
		סוג הדיל: 
		<select name="deal_is_special">
		 <option value="1"<? if ($deal_is_special == 1) echo ' SELECTED'; ?>>רגיל</option>
		 <option value="2"<? if ($deal_is_special == 2) echo ' SELECTED'; ?>>מיוחד</option>
        </select>
		&nbsp;&nbsp;&nbsp; סטטוס הדיל:
		<select name="deal_status">
		 <option value="0"<? if ($deal_status == 0) echo ' SELECTED'; ?>>ממתין</option>
		 <option value="1"<? if ($deal_status == 1) echo ' SELECTED'; ?>>פעיל</option>
		 <option value="2"<? if ($deal_status == 2) echo ' SELECTED'; ?>>סיים</option>
        </select>
		&nbsp;&nbsp;&nbsp; מס' ימים: 
		<input type="text" style="width:50px;" value="<?=$deal_end_date;?>" name="deal_end_date">
		&nbsp;&nbsp;&nbsp; כמ' קניות מזויף: <input type="text" style="width:50px;" value="<?=$deal_fake_buyers;?>" name="deal_fake_buyers">
		&nbsp;&nbsp;&nbsp; להציג בדילים קודמים? 
		<select name="deal_is_latest">
		 <option value="0"<? if ($deal_is_latest == 0) echo ' SELECTED'; ?>>כן</option>
		 <option value="1"<? if ($deal_is_latest == 1) echo ' SELECTED'; ?>>לא</option>
        </select>

	    <!-- areas & shipping -->
		<div class="spacer"></div><div class="cat">איזורים ומשלוחים</div><div class="spacer"></div>
		 <input type="hidden" name="total_area" value="<?=$total_areas;?>">
		 <? for ($i=0;$i<$total_areas;$i++)
		 {
			 $flag = 0;
			 foreach ($deal_areas_exp as $d_area)
			 {
				 if ($d_area == $area_id[$i])
				 {
					 echo '<input type="checkbox" name="area'.$i.'" checked>'.$area_name[$i].' ';
					 $flag = 1;
				 }
			 }
			 echo '<input type="hidden" name="area_id'.$i.'" value="'.$area_id[$i].'">';
			 if ($flag == 0) echo '<input type="checkbox" name="area'.$i.'">'.$area_name[$i].' ';
			 echo "\n		 ";
		 }
		 ?>

		 <br><div style="padding-top:10px;"></div>
         <input type="hidden" name="total_shipping" value="<?=$total_shipping;?>">
		 <? for ($i=0;$i<$total_shipping;$i++)
		 {
			 $flag = 0;
			 foreach ($deal_shipping_exp as $d_ship)
			 {
				 if ($d_ship == $shipping_id[$i])
				 {
					 echo '<input type="checkbox" name="shipping'.$i.'" checked>'.$shipping_name[$i].' - ₪'.$shipping_price[$i].' ';
					 $flag = 1;
				 }
			 }
			 echo '<input type="hidden" name="shipping_id'.$i.'" value="'.$shipping_id[$i].'">';
			 if ($flag == 0) echo '<input type="checkbox" name="shipping'.$i.'">'.$shipping_name[$i].' - ₪'.$shipping_price[$i].' ';
			 echo "\n		 ";
		 }
		 ?>
		 <br><div style="padding-top:10px;"></div>
		 חייב לקבל פרטי משלוח?
		 <select name="deal_must_shipping">
          <option value="0"<? if ($deal_must_shipping == 0) echo ' SELECTED'; ?>>לא</option>
          <option value="1"<? if ($deal_must_shipping == 1) echo ' SELECTED'; ?>>כן</option>
		 </select>
        <!-- prices -->
		<div class="spacer"></div><div class="cat">מחירים</div><div class="spacer"></div>
		מחיר רגיל: <input type="text" style="width:50px;" value="<?=$deal_reg_price;?>" name="deal_reg_price">
		&nbsp;&nbsp;&nbsp; מחיר שלנו: <input type="text" style="width:50px;" value="<?=$deal_our_price;?>" name="deal_our_price">
		&nbsp;&nbsp;&nbsp; מחיר בפועל: <input type="text" style="width:50px;" value="<?=$deal_bill_price;?>" name="deal_bill_price">
		&nbsp;&nbsp;&nbsp; מינימום קונים: <input type="text" style="width:50px;" value="<?=$deal_min_buyers;?>" name="deal_min_buyers">


        <!-- snifim -->
		<div class="spacer"></div><div class="cat">סניפים - הכנס סניף בכל שורה.</div><div class="spacer"></div>
        <textarea name="deal_snifim" style="width:700px; height:50px;"><?=$deal_snifim;?></textarea>

        <!-- pics -->
		<div class="spacer"></div><div class="cat">תמונות</div><div class="spacer"></div>
        תמונה ראשית: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" style="width:350px;" value="<?=$deal_image;?>" name="deal_image"><div class="spacer"></div>
		<div style="height:150px; overflow:auto; scrollbar-face-color:black; scrollbar-shadow-color:black; scrollbar-highlight-color:black; width:710px;">
		 <table style="background-color:#fff; width:690px;" class="chi"><tr style="background-color:#fff;">
		<?
			// ------------
			// find files 
			// ------------
			$up_directory = '../products/';
			if($HTTP_GET_VARS['dir'] != NULL) {	$up_directory = ".".$HTTP_GET_VARS['dir'].""; $up_directory = str_replace("//", "/", $up_directory); }

				$myDirectory = opendir($up_directory);
				while($entryName = readdir($myDirectory)) {	$dirArray[] = $entryName; } closedir($myDirectory);

				$indexCount	= count($dirArray); sort($dirArray);

				$files = ''; $dirs = '';
				for($index=0; $index < $indexCount; $index++) {
				 if (substr($dirArray[$index], 0, 1) != ".")
				  {

					$type = filetype("".$up_directory."/".$dirArray[$index]."");
					$name = $dirArray[$index];

					if ($name != "edit.php")
					{
						if ($type == "file") $files[] = $name;
						else $dirs[] = $name;
					}
				  }
				}
			$count = 0;
			foreach ($files as $f)
			{
				echo '
				 <td style="background-color:#fff; text-align:right; direction:ltr; text-align:left;" align="right"><center><a href="../products/'.$f.'"><img src="../products/'.$f.'" height="50" width="50" border="0"></a><br>'.$f.'</td>';
				$count++;
				if($count%8 == 0)
					echo '</tr><tr>';
			}
		?>
		   </tr>
		  </table>
		  </div>


	    <!-- texts -->
		<div class="spacer"></div><div class="cat">טקסטים</div><div class="spacer"></div>
		<a href="javascript:selected('1');" style="background-color:#ebebeb; padding:5px; height:20px; line-height:20px; color:#000;">» טקסט 1</a>
		<span id=contentm1 style="DISPLAY: block"></span><span id=content1 style="DISPLAY: none">
		<textarea name="deal_text_1" id="c1" style="width:300px;"><?=$deal_text_1;?></textarea><br>
		 <script type='text/javascript'>
		  CKEDITOR.replace( 'c1', { 
			 skin: 'v2',
			 extraPlugins : 'uicolor', 
			 width : '700px', 
			 height: '280px', 
			 toolbar : 
				[ 
				 [ 'Source', '-', 'Bold', 'Italic', 'Underline', 'Strike','-','Link', '-', 'MyButton', 'Color', 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo', 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ],
				 [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv', '-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl', 'Link','Unlink','Anchor' ],
				 [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe' ],
				 [ 'Styles','Format','Font','FontSize', 'TextColor','BGColor', 'Maximize', 'ShowBlocks','-','About' ]
				], 
			 enterMode : CKEDITOR.ENTER_BR, 
			 shiftEnterMode: CKEDITOR.ENTER_P 
		  });</script>
		</span>

		<a href="javascript:selected('2');" style="background-color:#ebebeb; padding:5px; height:20px; line-height:20px; color:#000;">» טקסט 2</a>
		<span id=contentm2 style="DISPLAY: block"></span><span id=content2 style="DISPLAY: none">
		<textarea name="deal_text_2" id="c2" style="width:300px;"><?=$deal_text_2;?></textarea><br>
		 <script type='text/javascript'>
		  CKEDITOR.replace( 'c2', { 
			 skin: 'v2',
			 extraPlugins : 'uicolor', 
			 width : '700px', 
			 height: '280px', 
			 toolbar : 
				[ 
				 [ 'Source', '-', 'Bold', 'Italic', 'Underline', 'Strike','-','Link', '-', 'MyButton', 'Color', 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo', 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ],
				 [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv', '-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl', 'Link','Unlink','Anchor' ],
				 [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe' ],
				 [ 'Styles','Format','Font','FontSize', 'TextColor','BGColor', 'Maximize', 'ShowBlocks','-','About' ]
				], 
			 enterMode : CKEDITOR.ENTER_BR, 
			 shiftEnterMode: CKEDITOR.ENTER_P 
		  });</script>
		</span>

		<a href="javascript:selected('3');" style="background-color:#ebebeb; padding:5px; height:20px; line-height:20px; color:#000;">» טקסט 3</a>
		<span id=contentm3 style="DISPLAY: block"></span><span id=content3 style="DISPLAY: none">
		<textarea name="deal_text_3" id="c3" style="width:300px;"><?=$deal_text_3;?></textarea>
		 <script type='text/javascript'>
		  CKEDITOR.replace( 'c3', { 
			 skin: 'v2',
			 extraPlugins : 'uicolor', 
			 width : '700px', 
			 height: '280px', 
			 toolbar : 
				[ 
				 [ 'Source', '-', 'Bold', 'Italic', 'Underline', 'Strike','-','Link', '-', 'MyButton', 'Color', 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo', 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ],
				 [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv', '-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl', 'Link','Unlink','Anchor' ],
				 [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe' ],
				 [ 'Styles','Format','Font','FontSize', 'TextColor','BGColor', 'Maximize', 'ShowBlocks','-','About' ]
				], 
			 enterMode : CKEDITOR.ENTER_BR, 
			 shiftEnterMode: CKEDITOR.ENTER_P 
		  });</script>
		</span>

		<div class="spacer"></div>
		<input type="submit" value="<?=$top_text;?>!" style="width:700px; padding:10px; font-weight:bold;">


        </div>
	   </form>
	 </div>


<? include "footer.php"; ?>