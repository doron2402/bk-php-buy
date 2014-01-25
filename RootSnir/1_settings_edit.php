<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! edit seo page ! ..                                                         *
********************************************************************************  */

	include "iframe_html.php";
	include "sql.php";

	$add_to_text = '';

	// ---------------------------- //
	// -- select text from db    -- //
	// ---------------------------- //
	$id = $HTTP_GET_VARS['id'];
	opensql();
		$result = mysql_query("SELECT * FROM `Coupons_Titles` WHERE `text_id`='".$id."' LIMIT 1;");

			$text_id				= mysql_result($result, 0, "text_id");
			$text_name				= mysql_result($result, 0, "text_name");
			$text_meta_title		= mysql_result($result, 0, "text_meta_title");
			$text_meta_description 	= mysql_result($result, 0, "text_meta_description");
			$text_meta_keywords		= mysql_result($result, 0, "text_meta_keywords");
			$text_content			= mysql_result($result, 0, "text_content");

	closesql();

	// --------------------- //
	// -- edit text in db -- //
	// --------------------- //
	if ($_POST['edit'] == "1")
	{
		opensql();

		mysql_query("UPDATE `Coupons_Titles` SET 
			`text_name` = '".$_POST['text_name']."',
			`text_meta_title` = '".$_POST['text_meta_title']."',
			`text_meta_description` = '".$_POST['text_meta_description']."',
			`text_meta_keywords` = '".$_POST['text_meta_keywords']."',
			`text_content` = '".$_POST['text_content']."'
			WHERE `Coupons_Titles`.`text_id` =".$id.";");
				
				mysql_query("OPTIMIZE TABLE `Coupons_Titles`");
					mysql_query("REPAIR TABLE `Coupons_Titles`");
						mysql_query("ANALYZE TABLE `Coupons_Titles`");

		closesql();

			$text_id				= $_POST['text_id'];
			$text_name				= $_POST['text_name'];
			$text_meta_title		= $_POST['text_meta_title'];
			$text_meta_description 	= $_POST['text_meta_description'];
			$text_meta_keywords		= $_POST['text_meta_keywords'];

			opensql();

				$result = mysql_query("SELECT * FROM `Coupons_Titles` WHERE `text_id`='".$id."' LIMIT 1;");
					$text_content		= mysql_result($result, 0, "text_content");

			closesql();


		$add_to_text = '<font color="red"> - עודכן בהצלחה!</font>';
	}

	// ------------------------------- //
	// -- show form -- //
	// ------------------------------- //

?>

  <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
  <script src="ckeditor/_samples/sample.js" type="text/javascript"></script>
  <link href="ckeditor/_samples/sample.css" rel="stylesheet" type="text/css" />

 <!-- Update form -->
  <div style="padding-top:10px;"></div>
   <center>
    <h1>הוסף עמוד חדש באתר<?=$add_to_text;?></h1>
	<form method="post" action="">
     <input type="hidden" name="edit" value="1">
     <table cellpadding="4" cellspacing="2">
      <tr>
       <td>שם העמוד</td><td width="5"></td>
       <td><input type="text" name="text_name" value="<?=$text_name;?>"></td>
	  </tr>
      <tr>
       <td>meta title</td><td width="5"></td>
       <td><input type="text" name="text_meta_title" style="width:700px;" value="<?=$text_meta_title;?>"></td>
	  </tr>
      <tr>
       <td>meta description</td><td width="5"></td>
       <td><input type="name" name="text_meta_description" style="width:700px;" value="<?=$text_meta_description;?>"></td>
	  </tr>
      <tr>
       <td>meta keywords</td><td width="5"></td>
       <td><input type="text" name="text_meta_keywords" style="width:700px;" value="<?=$text_meta_keywords;?>"></td>
	  </tr>
      <tr>
       <td>תוכן הדף</td><td width="5"></td>
       <td><textarea name="text_content" id="content" style="width:300px;"><?=$text_content;?></textarea></td>
	  </tr>
	  <tr>
	   <td></td><td></td>
       <td align="left"><input type="submit" value="עדכן!" style="padding:5px;"></td>
      </tr>
     </table>
    </center>
   <!-- end of Update form -->

 <script type='text/javascript'>
  CKEDITOR.replace( 'content', { 
	 skin : 'v2', 
	 extraPlugins : 'uicolor', 
	 width : '700px', 
	 height: '300px', 
	 toolbar : 
		[ 
		 [ 'Source', '-', 'Bold', 'Italic', 'Underline', 'Strike','-','Link', '-', 'MyButton', 'Color', 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo', 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ],
		 [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv', '-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl', 'Link','Unlink','Anchor' ],
		 [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe' ],
		 [ 'Styles','Format','Font','FontSize', 'TextColor','BGColor', 'Maximize', 'ShowBlocks','-','About' ]
	    ], 
	 enterMode : CKEDITOR.ENTER_BR, 
	 shiftEnterMode: CKEDITOR.ENTER_P 
  });
 </script>
