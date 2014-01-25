<?
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! edit products to index ! ..                                                *
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

	if ($admin == 1)
	{
		$products_exp = get_products_list();
		show_header();

		// ------------------- //
		// -- Update in sql -- //
		// ------------------- //
		if ($_POST['update'] == 1)
		{
				$string = '';
				for ($i=0;$i<9;$i++) $string = ''.$string.''.$_POST['product'.$i.''].',';
				$string = substr($string, 0, -1);

				opensql_redpoint();

					mysql_query("UPDATE `index` SET `products` = '".$string."' WHERE `index`.`id` =1 LIMIT 1 ;");
						mysql_query("OPTIMIZE TABLE `index`");
							mysql_query("REPAIR TABLE `index`");
								mysql_query("ANALYZE TABLE `index`");

				closesql_redpoint();

				add_to_logs("עדכון מוצרים בעמוד הראשי.");
				echo '<h1>המוצרים בעמוד הראשי עודכנו בהצלחה.<br><br>
				<a href="javascript:parent.$.fancybox.close();" style="color:#000000;">>> חזרה לטבלה</a></h1>';
		}
		else
		{ ?>

		<!-- Valid form -->
		<script>
		function checkform ( form )
		{
			if (form.product0.value == '') { alert( "חובה להזין את כל המוצרים" ); form.product0.focus(); return false ; }
			if (form.product1.value == '') { alert( "חובה להזין את כל המוצרים" ); form.product1.focus(); return false ; }
			if (form.product2.value == '') { alert( "חובה להזין את כל המוצרים" ); form.product2.focus(); return false ; }
			if (form.product3.value == '') { alert( "חובה להזין את כל המוצרים" ); form.product3.focus(); return false ; }
			if (form.product4.value == '') { alert( "חובה להזין את כל המוצרים" ); form.product4.focus(); return false ; }
			if (form.product5.value == '') { alert( "חובה להזין את כל המוצרים" ); form.product5.focus(); return false ; }
			if (form.product6.value == '') { alert( "חובה להזין את כל המוצרים" ); form.product6.focus(); return false ; }
			if (form.product7.value == '') { alert( "חובה להזין את כל המוצרים" ); form.product7.focus(); return false ; }
			if (form.product8.value == '') { alert( "חובה להזין את כל המוצרים" ); form.product8.focus(); return false ; }
		  return true ;
		}
		</script>
		<!-- end of Valid form -->

		<!-- Update form -->
		<div style="padding-top:10px;"></div><center>
		<h1 style="padding:0px; margin:0px;">מוצרים בעמוד הראשי</h1><br>
		הזן מספרי #Id<br><br>

		<!-- ################### Product form ################### -->
		<form method="post" action="" onsubmit="return checkform(this);">
		 <input type="hidden" name="update" value="1">
		   <table><tr><td valign="top">
			<table>
			 <tr><td>מוצר 1</td><td><input type="text" name="product0" style="width:200px;" value='<? echo $products_exp[0]; ?>'></td></tr>
			 <tr><td>מוצר 2</td><td><input type="text" name="product1" style="width:200px;" value='<? echo $products_exp[1]; ?>'></td></tr>
			 <tr><td>מוצר 3</td><td><input type="text" name="product2" style="width:200px;" value='<? echo $products_exp[2]; ?>'></td></tr>
			 <tr><td>מוצר 4</td><td><input type="text" name="product3" style="width:200px;" value='<? echo $products_exp[3]; ?>'></td></tr>
			 <tr><td>מוצר 5</td><td><input type="text" name="product4" style="width:200px;" value='<? echo $products_exp[4]; ?>'></td></tr>
			</table>
			</td><td valign="top">
			<table>
			 <tr><td>מוצר 6</td><td><input type="text" name="product5" style="width:200px;" value='<? echo $products_exp[5]; ?>'></td></tr>
			 <tr><td>מוצר 7</td><td><input type="text" name="product6" style="width:200px;" value='<? echo $products_exp[6]; ?>'></td></tr>
			 <tr><td>מוצר 8</td><td><input type="text" name="product7" style="width:200px;" value='<? echo $products_exp[7]; ?>'></td></tr>
			 <tr><td>מוצר 9</td><td><input type="text" name="product8" style="width:200px;" value='<? echo $products_exp[8]; ?>'></td></tr>
			</table>
		   </td></tr></table>
		   <center><input type="submit" value="עדכן מוצרים!" style="padding:5px;"></center>
		</form>
		<!-- end of Update form -->

		 </div>
		</div>
	   </div>
	  </div>
	 </div>
	</div>
	<div style="padding-top:20px;"></div>

<? } 
} ?>