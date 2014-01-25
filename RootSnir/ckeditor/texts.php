<?php 

	$color = 8;
	include "up.php";

	$id = $HTTP_GET_VARS['id'];	if ($id == NULL) $id = 1;

	$file[1] = 'pirsum.txt';
	$file[2] = 'email.txt';

?>

<table>
<tr>
	<td><a class="<? if ($id == 1) echo 'dd2'; else echo 'dd'; ?>" href="texts.php?id=1">טקסט למפרסם</a></td>
	<td><a class="<? if ($id == 4) echo 'dd2'; else echo 'dd'; ?>" href="texts.php?id=4">אימייל לאישור</a></td>
</tr>
</table>

	<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
	<script src="ckeditor/_samples/sample.js" type="text/javascript"></script>
	<link href="ckeditor/_samples/sample.css" rel="stylesheet" type="text/css" />

<div style="width:660px; background-color:#ffffff; direction:rtl; -moz-border-radius: 1em 1em 1em 1em; margin:2px; font-size:14px; font-weight:bold;">
 <div style="padding:30px; text-align:right; color:#000000;">

<textarea class="ckeditor" cols="80" id="editor1" name="editor1" rows="10">&lt;p&gt;This is some &lt;strong&gt;sample text&lt;/strong&gt;. You are using &lt;a href="http://ckeditor.com/"&gt;CKEditor&lt;/a&gt;.&lt;/p&gt;</textarea>

<? echo file_get_contents("Files/".$file[$id].""); ?>

<br><br><br><center><a href="notes-edit.php?id=<? echo $id; ?>">ערוך</a>

 </div>
</div>