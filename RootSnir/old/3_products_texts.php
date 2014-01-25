<?
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! edit content in redpoint ! ..                                              *
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
		show_header();

		// ------------------------ //
		// -- Show list of pages -- //
		// ------------------------ //
		if ($id == NULL)
		{
			echo '<h1>בחר עמוד לעדכן</h1><br><table>';
			opensql_redpoint();
				$result = mysql_query("SELECT * FROM `cms_page` ORDER BY `page_id` ASC;");
				$exsist = mysql_num_rows($result);
				for ($i=0;$i<$exsist;$i++)
				{
					$cms_id = mysql_result($result,$i,"page_id");
					$title = mysql_result($result,$i,"title");
					echo '<tr><td>'.$cms_id.'</td><td><a href="?id='.$cms_id.'" style="font-size:14px;">'.$title.'</a></td></tr>';
				}
			closesql_redpoint();
			echo '</table>';
		}
		// ---------------------------- //
		// -- Show content to update -- //
		// ---------------------------- //
		else
		{
			// ---------------------------- //
			// -- Update CMS in the SQL  -- //
			// ---------------------------- //
			if ($_POST['update'] == 1)
			{

				$title				= $_POST['title'];
				$meta_keywords		= $_POST['meta_keywords'];
				$meta_description	= $_POST['meta_description'];
				$identifier			= $_POST['identifier'];
				$text1				= $_POST['text1'];
					$text1 = str_replace('\"', '"', $text1);
					$text1 = str_replace("\'", "'", $text1);

				opensql_redpoint();

					mysql_query("UPDATE `cms_page` SET 
					`title` = '".$title."',
					`meta_keywords` = '".$meta_keywords."',
					`meta_description` = '".$meta_description."',
					`identifier` = '".$identifier."',
					`content` = '".$text1."'
					WHERE `cms_page`.`page_id` =".$id." LIMIT 1 ;");

						mysql_query("OPTIMIZE TABLE `cms_page`");
							mysql_query("REPAIR TABLE `cms_page`");
								mysql_query("ANALYZE TABLE `cms_page`");

				closesql_redpoint();

				add_to_logs("עדכון עמוד - ".$title."");
				echo '<h1>העמוד עודכן בהצלחה!<br><br>
				<a href="javascript:history.go(-1)" style="color:#000000;">>> חזור לעמוד הקודם</a><br>
				<a href="javascript:parent.$.fancybox.close();" style="color:#000000;">>> חזרה לטבלה</a></h1>';

			}
			// ---------------- //
			// -- Show Form  -- //
			// ---------------- //
			else
			{
				echo '
				<!-- CKeditor -->
				<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
				<script src="ckeditor/_samples/sample.js" type="text/javascript"></script>
				<link href="ckeditor/_samples/sample.css" rel="stylesheet" type="text/css" />
				<h1>עדכן עמוד</h1>
				<a href="javascript:history.go(-1)" style="font-weight:bold; font-size:14px;">חזור אחורה</a>
				<br><br>';

				opensql_redpoint();
					$result = mysql_query("SELECT * FROM `cms_page` WHERE `page_id`='".$id."';");
						$title					= mysql_result($result,0,"title");
						$meta_keywords			= mysql_result($result,0,"meta_keywords");
						$meta_description		= mysql_result($result,0,"meta_description");
						$identifier				= mysql_result($result,0,"identifier");
						$content				= mysql_result($result,0,"content");

						echo '
						<form method="post" action="">
						 <input type="hidden" name="update" value="1">
						   <table>
							 <tr><td>שם</td>			<td><input type="text" name="title" style="width:600px;" value="'.$title.'"></td></tr>
							 <tr><td>keywords</td>		<td><input type="text" name="meta_keywords" style="width:600px;" value="'.$meta_keywords.'"></td></tr>
							 <tr><td>description</td>	<td><input type="text" name="meta_description" style="width:600px;" value="'.$meta_description.'"></td></tr>
							 <tr><td>url</td>			<td><input type="text" name="identifier" style="width:600px;" value="'.$identifier.'"></td></tr>
							 <tr><td>תוכן</td>			<td><textarea name="text1" id="text1" style="width:600px;">'.$content.'</textarea></td></tr>
							 <tr><td></td>				<td align="left"><input type="submit" value="עדכן עמוד!"></td></tr>
						   </table>
						</form> ';
				closesql_redpoint();

				echo "
				<script type='text/javascript'>
				CKEDITOR.replace( 'text1',
				{ skin : 'v2', extraPlugins : 'uicolor', width : '600px', height: '400px', toolbar : [ [ 'Source', '-', 'Bold', 'Italic', 'Underline', 'Strike','-','Link', '-', 'MyButton' ] ], enterMode : CKEDITOR.ENTER_BR, shiftEnterMode: CKEDITOR.ENTER_P });
				</script>
				";
			}
		}
?>
		 </div>
		</div>
	   </div>
	  </div>
	 </div>
	</div>
	<div style="padding-top:20px;"></div>
<? } ?>