<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! edit special text ! ..                                                     *
********************************************************************************  */

	include "iframe_html.php";
	include "sql.php";

	$add_to_text = '';

	// ---------------------------- //
	// -- select text from db    -- //
	// ---------------------------- //
	$id = $HTTP_GET_VARS['id'];
	opensql();
		$result = mysql_query("SELECT * FROM `Coupons_Special_Texts` WHERE `id`='".$id."' LIMIT 1;");

			$id					= mysql_result($result, 0, "id");
			$name				= mysql_result($result, 0, "name");
			$content			= mysql_result($result, 0, "content");

	closesql();

	// ------------------------- //
	// -- update contact page -- //
	// ------------------------- //
	if ($_POST['edit'] == "1")
	{
		opensql();

		mysql_query("UPDATE `Coupons_Special_Texts` SET 
			`content` = '".$_POST['content']."' WHERE `Coupons_Special_Texts`.`id` =".$id.";");

				mysql_query("OPTIMIZE TABLE `Coupons_Special_Texts`");
					mysql_query("REPAIR TABLE `Coupons_Special_Texts`");
						mysql_query("ANALYZE TABLE `Coupons_Special_Texts`");

		closesql();

			$content					= $_POST['content'];

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
    <h1>עדכן דף מיוחד - <?=$name;?><?=$add_to_text;?></h1>
	<form method="post" action="">
     <input type="hidden" name="edit" value="1">
     <table cellpadding="4" cellspacing="2">
	  <tr>
       <td valign="top">פרמטרים</td><td width="5"></td>
	   <td>
        <b>פרטי אשראי לא נכונים:</b><br>
		%URL% - הכתובת אליו יועבר על מנת להיכנס שוב לדיל אותו רצה לבצע.<br><br>

        <b>העיסקה בוצעה:</b><br>
		%TOTAL% - סכום העיסקה<br>
		%ORDER_ID% - מספר ההזמנה
		<br><br>

        <b>שליחת אימייל לקונה:</b><br>
		%DEAL_NAME% - שם הדיל<br>
		%DEAL_ID% - מספר הדיל<br>
		%COUNT% - כמות שנרכשה<br>
		%COUPON_LIST% - רשימת הקוד קופונים
		<br><br>

        <b>שליחת אימייל כמתנה:</b><br>
		אותם פרמטרים כמו "שילחת אימייל לקונה" +<br>
		%PRIVATE_MSG% - ההודעה מהקונה
		<br><br>

	   </td>
	  </tr>
      <tr>
       <td>תוכן</td><td width="5"></td>
       <td><textarea name="content" id="content" style="width:300px;"><?=$content;?></textarea></td>
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
	 height: '220px', 
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
