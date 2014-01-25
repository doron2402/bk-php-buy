<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! contact ! ..                                                               *
*********************************************************************************  */

	include "sql.php";
	include "functions_contact.php";

?>

<script>
function checkform ( form )
{
	if (form.name.value == '') { alert( "חובה להזין שם מלא" ); form.name.focus(); return false ; }
	if (form.phone.value == '') { alert( "חובה להזין טלפון או פלאפון" ); form.phone.focus(); return false ; }
  return true ;
}
</script>

 <div class="contact_button"><div class="conttxt">צור קשר</div></div>
 <div class="split_big"></div>
 <div class="contact_box">
  <strong><?=$contact_top_content;?></strong>


<form method="post" onsubmit="return checkform(this);" style="padding:0px; margin:0px;">
 <input type="hidden" name="set" value="1" />

  <div class="contact-inner">
   <div class="contact_lable">שם מלא</div>
   <input class="contact_input" name="name" id="_c_full_name" value="" type="text" />
  </div>

  <div class="contact-inner">
   <div class="contact_lable">טלפון</div>
   <input class="contact_input" name="phone" id="_c_phone" value="" type="text" />
  </div>

  <div class="contact-inner">
   <div class="contact_lable">אימייל</div>
   <input class="contact_input" name="email" id="_c_email" value="" type="text" />
  </div>

  <div class="contact-inner">
   <div class="contact_lable">הודעה</div>
   <textarea class="contact_input" name="msg" id="_c_message" style="height:150px;"></textarea>
  </div>
		
  <div class="contact-inner">
   <input type="submit" style="display:none;" />
   <div style="text-align:left;"><input type="submit" class="button" value="שלח!" /></div>
 </div>
</form>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<div style="margin-right:60px;"><?=$contact_footer_content;?></div>
</div>


<? include "footer.php"; ?>