<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! edit contact page ! ..                                                     *
********************************************************************************  */

	include "iframe_html.php";
	include "sql.php";

	$add_to_text = '';

	// ---------------------------- //
	// -- select text from db    -- //
	// ---------------------------- //
	$id = $HTTP_GET_VARS['id'];
	opensql();
		$result = mysql_query("SELECT * FROM `Coupons_Texts_Contact` WHERE `contact_id`='".$id."' LIMIT 1;");

			$contact_id					= mysql_result($result, 0, "contact_id");
			$contact_name				= mysql_result($result, 0, "contact_name");
			$contact_meta_title			= mysql_result($result, 0, "contact_meta_title");
			$contact_meta_description 	= mysql_result($result, 0, "contact_meta_description");
			$contact_meta_keywords		= mysql_result($result, 0, "contact_meta_keywords");
			$contact_top_content		= mysql_result($result, 0, "contact_top_content");
			$contact_footer_content		= mysql_result($result, 0, "contact_footer_content");
			$contact_email				= mysql_result($result, 0, "contact_email");

	closesql();

	// ------------------------- //
	// -- update contact page -- //
	// ------------------------- //
	if ($_POST['edit'] == "1")
	{
		opensql();

		mysql_query("UPDATE `Coupons_Texts_Contact` SET 
			`contact_name` = '".$_POST['contact_name']."',
			`contact_meta_title` = '".$_POST['contact_meta_title']."',
			`contact_meta_description` = '".$_POST['contact_meta_description']."',
			`contact_meta_keywords` = '".$_POST['contact_meta_keywords']."',
			`contact_top_content` = '".$_POST['contact_top_content']."',
			`contact_footer_content` = '".$_POST['contact_footer_content']."',
			`contact_email` = '".$_POST['contact_email']."'
			WHERE `Coupons_Texts_Contact`.`contact_id` =".$id.";");

				mysql_query("OPTIMIZE TABLE `Coupons_Texts_Contact`");
					mysql_query("REPAIR TABLE `Coupons_Texts_Contact`");
						mysql_query("ANALYZE TABLE `Coupons_Texts_Contact`");

		closesql();

			$contact_id					= $_POST['contact_id'];
			$contact_name				= $_POST['contact_name'];
			$contact_meta_title			= $_POST['contact_meta_title'];
			$contact_meta_description 	= $_POST['contact_meta_description'];
			$contact_meta_keywords		= $_POST['contact_meta_keywords'];
			$contact_email				= $_POST['contact_email'];


			opensql();

				$result = mysql_query("SELECT * FROM `Coupons_Texts_Contact` WHERE `contact_id`='".$id."' LIMIT 1;");
					$contact_top_content		= mysql_result($result, 0, "contact_top_content");
					$contact_footer_content		= mysql_result($result, 0, "contact_footer_content");

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
    <h1>עדכן דף צור קשר<?=$add_to_text;?></h1>
	<form method="post" action="">
     <input type="hidden" name="edit" value="1">
     <table cellpadding="4" cellspacing="2">
      <tr>
       <td>שם העמוד</td><td width="5"></td>
       <td><input type="text" name="contact_name" value="<?=$contact_name;?>"></td>
	  </tr>
      <tr>
       <td>לאן יגיע האימייל?</td><td width="5"></td>
       <td><input type="text" name="contact_email" style="width:200px; direction:ltr; text-align:left;" value="<?=$contact_email;?>"></td>
	  </tr>
      <tr>
       <td>meta title</td><td width="5"></td>
       <td><input type="text" name="contact_meta_title" style="width:700px;" value="<?=$contact_meta_title;?>"></td>
	  </tr>
      <tr>
       <td>meta description</td><td width="5"></td>
       <td><input type="name" name="contact_meta_description" style="width:700px;" value="<?=$contact_meta_description;?>"></td>
	  </tr>
      <tr>
       <td>meta keywords</td><td width="5"></td>
       <td><input type="text" name="contact_meta_keywords" style="width:700px;" value="<?=$contact_meta_keywords;?>"></td>
	  </tr>
      <tr>
       <td>תוכן לפני הצור קשר</td><td width="5"></td>
       <td><textarea name="contact_top_content" id="content" style="width:300px;"><?=$contact_top_content;?></textarea></td>
	  </tr>
      <tr>
       <td>תוכן אחר הצור קשר</td><td width="5"></td>
       <td><textarea name="contact_footer_content" id="content2" style="width:300px;"><?=$contact_footer_content;?></textarea></td>
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
	 height: '120px', 
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
  CKEDITOR.replace( 'content2', { 
	 skin : 'v2', 
	 extraPlugins : 'uicolor', 
	 width : '700px', 
	 height: '120px', 
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
