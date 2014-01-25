<?
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! add product to db ! ..                                                     *
*********************************************************************************  */

	// -------------- //
	// -- Config -- //
	// -------------- //
	$id = $HTTP_GET_VARS['id'];

	// -------------- //
	// -- Includes -- //
	// -------------- //
	include "sql.php";
	include "check_user.php";
	include "3_products_functions.php";

	// ---------------------------------- //
	// -- Get cost price price from db -- //
	// ---------------------------------- //
	opensql_redpoint();

		// ---------------------- //
		// -- Product database -- //
		// ---------------------- //
		$result = mysql_query("SELECT * FROM `products` ORDER BY `entity_id` DESC");
	
			$last_id = mysql_result($result,0,"entity_id");
			$last_id++;
			$big_pic = "a".$last_id."_big.jpg";
			$small_pic = "a".$last_id."_small.jpg";

		// ----------------------- //
		// -- Category database -- //
		// ----------------------- //

		$result = mysql_query("SELECT * FROM `category` ORDER BY `entity_id` ASC");
		$total_cats = mysql_num_rows($result);
		for ($i=0;$i<$total_cats;$i++)
		{
			$cat_id[$i] = mysql_result($result,$i,"entity_id");
			$cat_name[$i] = mysql_result($result,$i,"name");
		}

	closesql_redpoint();

	show_header();
	// ------------------- //
	// -- Update in sql -- //
	// ------------------- //
	if ($_POST['update'] == 1)
	{

			$sku				= $_POST['sku'];
			$name				= $_POST['name'];
				$name = str_replace('"', '', $name);
				$name = str_replace("'", "", $name);

			$cost				= $_POST['cost'];

			$cat = ',';
			if ($_POST['cat0'] != '') $cat = ''.$cat.''.$_POST['cat0'].',';
			if ($_POST['cat1'] != '') $cat = ''.$cat.''.$_POST['cat1'].',';
			if ($_POST['cat2'] != '') $cat = ''.$cat.''.$_POST['cat2'].',';
			if ($_POST['cat3'] != '') $cat = ''.$cat.''.$_POST['cat3'].',';
			if ($_POST['cat4'] != '') $cat = ''.$cat.''.$_POST['cat4'].',';
			if ($_POST['cat5'] != '') $cat = ''.$cat.''.$_POST['cat5'].',';

			$short_description	= $_POST['shortd'];
				$short_description = str_replace('\"', '"', $short_description);
				$short_description = str_replace("\'", "'", $short_description);

			$taktzir			= $_POST['taktzir'];
				$taktzir = str_replace('\"', '"', $taktzir);
				$taktzir = str_replace("\'", "'", $taktzir);

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

			opensql_redpoint();

				mysql_query("INSERT INTO `redpoint_db`.`products` (`entity_id`, `sku`, `url_path`, `category_ids`, `name`, `short_description`, `price`, `special_price`, `small_image`, `thumbnail`, `url_key`, `taktzir`, `rprice`, `params`)
				VALUES (NULL, 
				'".$sku."', 
				'p".$last_id.".html', 
				'".$cat."', 
				'".$name."', 
				'".$short_description."', 
				'0', 
				'0', 
				'".$big_pic."', 
				'".$small_pic."', 
				'p".$last_id."', 
				'".$taktzir."', 
				'".$cost."', 
				'".$param."');");

					mysql_query("OPTIMIZE TABLE `products`");
						mysql_query("REPAIR TABLE `products`");
							mysql_query("ANALYZE TABLE `products`");

			closesql_redpoint();

			add_to_logs("הוספת מוצר חדש");

			echo '<h1>המוצר נוסף בהצלחה והועבר לבדיקה..<br><br>
			<a href="3_products_add.php" style="color:#000000;">>> הוסף עוד מוצר</a></h1>
			<a href="javascript:parent.$.fancybox.close();" style="color:#000000;">>> חזור אחורה</a></h1>';
	}

	// ------------------------------- //
	// -- Show form to update price -- //
	// ------------------------------- //
	else
	{

		// ----------------- //
		// -- Show select -- //
		// ----------------- //
		function show_select($i, $cat_id, $cat_name, $category_exp, $total_cats)
		{
			echo '<select name="cat'.$i.'"><option value=""></option>';
			 for ($z=0;$z<$total_cats;$z++)
			 {
			  if ($cat_id[$z] == $category_exp[$i]) echo '<option value="'.$cat_id[$z].'" SELECTED>'.$cat_name[$z].'</option>';
			  else								    echo '<option value="'.$cat_id[$z].'">'.$cat_name[$z].'</option>'; 
			  echo "\n";
			 }
			echo '</select>';
		}

?>

	<!-- CKeditor -->
	<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
	<script src="ckeditor/_samples/sample.js" type="text/javascript"></script>
	<link href="ckeditor/_samples/sample.css" rel="stylesheet" type="text/css" />

	<!-- Valid form -->
	<script>
	function checkform ( form )
	{
		if (form.sku.value == '') { alert( "sku" ); form.sku.focus(); return false ; }
		if (form.name.value == '') { alert( "חובה להזין שם למוצר" ); form.name.focus(); return false ; }
		if (form.cost.value == '') { alert( "חובה להזין את העלות שלנו." ); form.cost.focus(); return false ; }
	  return true ;
	}
	</script>

	<!-- Update form -->
	<div style="padding-top:10px;"></div>
	<center>
	 <h1>הוספת מוצר חדש לרד פוינט</h1>
	<form method="post" action="" onsubmit="return checkform(this);">
     <input type="hidden" name="update" value="1">
	
	<!-- ################### item infotmation ################### -->
	 <table cellpadding="2" cellspacing="2" width="600">
	  <tr>
	   <td valign="top" align="right">
	   <table>
	    <tr><td>מק"ט</td><td><input type="text" name="sku" style="width:200px;" value='<? echo $last_id; ?>' READONLY></td></tr>
	    <tr><td>שם המוצר</td><td><input type="text" name="name" style="width:200px;" value=''></td></tr>
	    <tr><td>עלות שלנו</td><td><input type="text" name="cost" style="width:200px;" value=''></td></tr>
		 <tr><td>קטגוריה #1</td><td><? show_select('0', $cat_id, $cat_name, $category_exp, $total_cats); ?></td></tr>
		 <tr><td>קטגוריה #2</td><td><? show_select('1', $cat_id, $cat_name, $category_exp, $total_cats); ?></td></tr>
		 <tr><td>קטגוריה #3</td><td><? show_select('2', $cat_id, $cat_name, $category_exp, $total_cats); ?></td></tr>
		 <tr><td>קטגוריה #4</td><td><? show_select('3', $cat_id, $cat_name, $category_exp, $total_cats); ?></td></tr>
		 <tr><td>קטגוריה #5</td><td><? show_select('3', $cat_id, $cat_name, $category_exp, $total_cats); ?></td></tr>
		 <tr><td>קטגוריה #6</td><td><? show_select('3', $cat_id, $cat_name, $category_exp, $total_cats); ?></td></tr>
	   </table>
	   
	   </td>
	   <td valign="top" align="left" width="300">
	    <iframe src="http://www.redpoint.co.il/upload/?pass=123&act=add&thumb=<? echo $small_pic; ?>&big_pic=<? echo $big_pic; ?>" border="0" frameborder="0" width="300" height="220"></iframe>
		</td>
	   </tr>
      </table>

	<!-- ################### Full text ################### --> 
	 <table cellpadding="2" cellspacing="2" width="600">
	  <tr><td>סקירה מהירה</td><td><textarea name="shortd" id="text1" style="width:300px;"></textarea></td></tr>
	  <tr><td>פירוט מלא</td><td><textarea name="taktzir" id="text2" style="width:300px;"></textarea></td></tr>
	</table>

	<!-- ################### item details ################### -->
	<? $p_exp = explode("<RtB>", $params); ?>
	 <table cellpadding="2" cellspacing="2" width="600">
	  <tr>
	   <td valign="top">
	    <table>
	     <tr><td>חברה</td><td><input type="text" name="p1" style="width:230px;" value=''></td></tr>
	     <tr><td>צבע</td><td><input type="text" name="p2" style="width:230px;" value=''></td></tr>
	     <tr><td>עשוי מ</td><td><input type="text" name="p3" style="width:230px;" value=''></td></tr>
	     <tr><td>אורך</td><td><input type="text" name="p4" style="width:230px;" value=''></td></tr>
		</table>
	   </td>
	   <td valign="top">
	    <table>
	     <tr><td>עובי</td><td><input type="text" name="p5" style="width:230px;" value=''></td></tr>
	     <tr><td>סוללות</td><td><input type="text" name="p6" style="width:230px;" value=''></td></tr>
	     <tr><td>שימוש</td><td><input type="text" name="p7" style="width:230px;" value=''></td></tr>
	     <tr><td>מתאים ל</td><td><input type="text" name="p8" style="width:230px;" value=''></td></tr>
		</table>
	   </td>
      </tr>
     </table>


	  <div style="text-align:left; width:600px;"><input type="submit" value="הוסף מוצר!" style="padding:5px;"></div>

	</center>
	<!-- end of Update form -->

 <script type='text/javascript'>
  CKEDITOR.replace( 'text1',
  { skin : 'v2', extraPlugins : 'uicolor', width : '550px', height: '100px', toolbar : [ [ 'Source', '-', 'Bold', 'Italic', 'Underline', 'Strike','-','Link', '-', 'MyButton' ] ], enterMode : CKEDITOR.ENTER_BR, shiftEnterMode: CKEDITOR.ENTER_P });
  CKEDITOR.replace( 'text2',
  { skin : 'v2', extraPlugins : 'uicolor', width : '550px', height: '100px', toolbar : [ [ 'Source', '-', 'Bold', 'Italic', 'Underline', 'Strike','-','Link', '-', 'MyButton' ] ], enterMode : CKEDITOR.ENTER_BR, shiftEnterMode: CKEDITOR.ENTER_P
  });
 </script>

     </div>
    </div>
   </div>
  </div>
 </div>
</div>
<div style="padding-top:20px;"></div>

<? } ?>