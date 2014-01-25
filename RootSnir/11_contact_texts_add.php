<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! add new contact page ! ..                                                  *
********************************************************************************  */

	include "iframe_html.php";
	include "sql.php";

	// ------------------------- //
	// -- add contact page db -- //
	// ------------------------- //
	if ($_POST['add'] == "1")
	{
		opensql();

			mysql_query("INSERT INTO `Coupons_Texts_Contact` VALUES (NULL, 
			'".$_POST['contact_name']."', 
			'".$_POST['contact_meta_title']."', 
			'".$_POST['contact_meta_description']."', 
			'".$_POST['contact_meta_keywords']."', 
			'".$_POST['contact_top_content']."',
			'".$_POST['contact_footer_content']."',
			'".$_POST['contact_email']."');");

				mysql_query("OPTIMIZE TABLE `Coupons_Texts_Contact`");
					mysql_query("REPAIR TABLE `Coupons_Texts_Contact`");
						mysql_query("ANALYZE TABLE `Coupons_Texts_Contact`");

		closesql();

		echo '<h1>נוסף בהצלחה!</h1>';
	}

	// ------------------------------- //
	// -- show form -- //
	// ------------------------------- //
	else
	{
?>

  <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
  <script src="ckeditor/_samples/sample.js" type="text/javascript"></script>
  <link href="ckeditor/_samples/sample.css" rel="stylesheet" type="text/css" />

  <!-- Update form -->
  <div style="padding-top:10px;"></div>
   <center>
    <h1>הוסף דף צור קשר חדש</h1>
	<form method="post" action="">
     <input type="hidden" name="add" value="1">
     <table cellpadding="4" cellspacing="2">
      <tr>
       <td>שם העמוד</td><td width="5"></td>
       <td><input type="text" name="contact_name"></td>
	  </tr>
      <tr>
       <td>לאן יגיע האימייל?</td><td width="5"></td>
       <td><input type="text" name="contact_email" style="width:200px; direction:ltr; text-align:left;"></td>
	  </tr>
      <tr>
       <td>meta title</td><td width="5"></td>
       <td><input type="text" name="contact_meta_title" style="width:700px;"></td>
	  </tr>
      <tr>
       <td>meta description</td><td width="5"></td>
       <td><input type="name" name="contact_meta_description" style="width:700px;"></td>
	  </tr>
      <tr>
       <td>meta keywords</td><td width="5"></td>
       <td><input type="text" name="contact_meta_keywords" style="width:700px;"></td>
	  </tr>
      <tr>
       <td>תוכן לפני הצור קשר</td><td width="5"></td>
       <td><textarea name="contact_top_content" id="content" style="width:300px;"></textarea></td>
	  </tr>
      <tr>
       <td>תוכן אחר הצור קשר</td><td width="5"></td>
       <td><textarea name="contact_footer_content" id="content2" style="width:300px;"></textarea></td>
	  </tr>
	  <tr>
	   <td></td><td></td>
       <td align="left"><input type="submit" value="הוסף!" style="padding:5px;"></td>
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

<? } ?>