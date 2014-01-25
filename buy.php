<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! buy function ! ..                                                          *
*********************************************************************************  */

	include "sql.php";
	include "check_user.php";

	$deal_id	= $HTTP_GET_VARS['id'];
	$deal_now	= $deal_id;

	if ($Member_login == 0)	echo '<script type="text/javascript">window.location = "login.php?back=buy.php?id='.$deal_id.'"</script>';

		/* ------------------------------
		-------- get deal info ----------
		------------------------------- */
		opensql();

			$result		= mysql_query("SELECT * FROM `Coupons_Deals` WHERE `deal_id`='".$deal_id."' AND `deal_status`='1' LIMIT 1;");
			$deal_ex	= mysql_num_rows($result);
			$deal_image				= mysql_result($result,0,"deal_image");
			$deal_name				= mysql_result($result,0,"deal_name");
			$deal_bill_price		= mysql_result($result,0,"deal_bill_price");
			$deal_shipping			= mysql_result($result,0,"deal_shipping");
			$deal_snifim			= mysql_result($result,0,"deal_snifim");
			$deal_must_shipping		= mysql_result($result,0,"deal_must_shipping");

		closesql();

		/* -------------------------------
		-------- deal not exsist ---------
		------------------------------- */
		if ($deal_ex == 0)	echo '<script type="text/javascript">window.location = "/"</script>';
		
		/* -------------------------------
		---------- active deal -----------
		------------------------------- */
		else
		{

			$meta_title			= $buy_page_meta_title;
			$meta_description	= $buy_page_meta_description;
			$meta_keywords		= $buy_page_meta_keywords;
			include "header.php";
		?>

<script src="buy_js.js"></script>

 <? if (($deal_shipping != NULL) && ($deal_shipping != ",")) { ?>
  <script>
   function calcTotal()
   { 
		var the_total=0; 
		var theForm = document.forms["buy"]; 
		var ship_me = theForm.shipping.value;
		var ship_me_exp = ship_me.split("EXP");
		var ship_price = ship_me_exp[0];
		the_total = <?=$deal_bill_price;?>*theForm.count.value; 
		the_total = the_total+'+₪'+ship_price; 
		return the_total;
   }
   function calculateTotal() { var totalPrice = calcTotal(); var divobj = document.getElementById('totalPrice'); divobj.style.display='block'; divobj.innerHTML = "סך הכל לתשלום: ₪"+totalPrice; }
  </script>
 <? } else { ?>
  <script>
   function calcTotal() { var the_total=0; var theForm = document.forms["buy"]; the_total = <?=$deal_bill_price;?>*theForm.count.value; the_total = the_total; return the_total; }
   function calculateTotal() { var totalPrice = calcTotal(); var divobj = document.getElementById('totalPrice'); divobj.style.display='block'; divobj.innerHTML = "סך הכל לתשלום: ₪"+totalPrice; }
  </script>
 <? } ?>

<script>
function checkform ( form )
{

	if ((form.deal_must_shipping.value == '1') || (form.shipping.value != '0'))
	{
		if (form.city.value == '')		{	alert( "חובה להזין עיר למשלוח" );			form.city.focus(); return false ; }
		if (form.address.value == '')	{	alert( "חובה להזין כתובת למשלוח" );			form.address.focus(); return false ; }
		if (form.dira.value == '')		{	alert( "חובה להזין דירה למשלוח" );			form.dira.focus(); return false ; }
		if (form.bait.value == '')		{	alert( "חובה להזין בית למשלוח" );			form.bait.focus(); return false ; }
	}

	if (form.present.checked == true)
	{
		if (form.present_name.value == '')	{	alert( "חובה להזין את שם מקבל המתנה" );			form.present_name.focus(); return false ; }
		if (form.present_email.value == '') {	alert( "חובה להזין את אימייל מקבל המתנה" );		form.present_email.focus(); return false ; }

		 var x=form.present_email.value;
		 var atpos=x.indexOf("@");
		 var dotpos=x.lastIndexOf(".");
		 if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
		 {
		  alert("כתובת האימייל שהזנת אינה חוקית.");
		  form.present_email.focus(); return false ;
		  return false;
		 }

		if (form.present_msg.value == '')	{	alert( "חובה להזין הודעה למקבל המתנה" );		form.present_msg.focus(); return false ; }
	}

  return true ;
}
</script>

<form method="post" action="Pay.php" id="buy" onsubmit="return checkform(this);">
 <!-- pelecard -->
 <input type="hidden" name="cancelUrl"	value="http://www.<?=$Company_name;?>/buy.php?id=<?=$deal_id;?>">
 <input type="hidden" name="per_one"	value="<?=$deal_bill_price;?>">
 <input type="hidden" name="text1"		value="<?=$deal_name;?>">

 <!-- my system -->
 <input type="hidden" name="deal_id"	value="<?=$deal_id;?>">
 <input type="hidden" name="deal_must_shipping" value="<?=$deal_must_shipping;?>">
 <? if ($deal_shipping == ",") { ?>
 <input type="hidden" name="shipping" value="0">
 <? } ?>

<div style="padding-right:60px;"><h2 style="padding-bottom:0px; margin-bottom:0px;">הזמנת קופון</h2></div>
<div class="buy_innerdet" style="font-size:14px;">
<table width="100%" cellpadding="0" cellspacing="0"><tr>
 <td align="right" valign="top">
  
  <!-- description -->
  <b>תיאור</b><br><br><?=$deal_name;?><br><br>
 
  <table cellpadding="4">
   <!-- reg price -->
   <tr><td><b>מחיר ליחידה:</b></td><td>₪<?=$deal_bill_price;?></td></tr>
   
   <!-- select count -->
   <tr><td><b>בחר כמות:</b></td><td>
   <select id="count" name="count" onchange="calculateTotal()">
   <? for ($i=1;$i<11;$i++) { echo '<option value="'.$i.'">'.$i.'</option>'; echo "\n   "; } ?>
  </select></td>
 </tr>
 <? if (($deal_shipping != NULL) && ($deal_shipping != ",")) { ?>
 <tr>
  <!-- select shipping -->
  <td><b>סוג משלוח:</b></td><td>
   <select name="shipping" id="shipping" onchange="calculateTotal(); <? if ($deal_must_shipping == 0) echo 'ch();';?>">
	<?
	  $t = "'";
      $s_count = 0;
	   opensql();
	   $deal_shipping_exp = explode(",", $deal_shipping);
       foreach ($deal_shipping_exp as $shipping_option)
	   {
		   if ($shipping_option != NULL)
		   {
				$result = mysql_query("SELECT * FROM `Coupons_Shipping` WHERE `shipping_id`='".$shipping_option."' LIMIT 1;");
		   		$shipping_name		= mysql_result($result, 0, "shipping_name");
				$shipping_price		= mysql_result($result, 0, "shipping_price");
				echo '<option value="'.$shipping_price.'EXP'.$shipping_name.'">'.$shipping_name.' - ₪'.$shipping_price.'</option>';
				echo "\n	";
		   }
	   }
	   closesql();
	?>
   </select>
  </td>
 </tr>
 <? } if ($deal_snifim != NULL) { ?>
 <tr>
  <!-- select snif -->
  <td><b>בחר סניף:</b></td><td>
   <select name="snif">
	<? opensql();
		 $deal_snifim_exp = explode("\r\n", $deal_snifim);
		 foreach ($deal_snifim_exp as $deal_snif) { if ($deal_snif != NULL) { echo '<option value="'.$deal_snif.'">'.$deal_snif.'</option>'; echo "\n	"; } }
	closesql(); ?>
   </select>
  </td>
 </tr><? } ?>
</table>

<span id=contentm0 style="DISPLAY: block"></span>
<span id=content0 style="DISPLAY: none"></span>
<span id=cccm0 style="DISPLAY: block"></span>
<span id=ccc0 style="DISPLAY: none"></span>

<!-- shipping -->
<? if ($deal_must_shipping == 0) { ?>   <span id=cccm1 style="DISPLAY: block"></span><span id=ccc1 style="DISPLAY: none">
<? } else { ?>							<span id=cccm1 style="DISPLAY: block"></span><span id=ccc1 style="DISPLAY: block"> <? } ?>
<div style="padding-top:10px;"></div>
<h3 style="margin:3px;">לאן לשלוח?</h3><table>
  <tr><td><b>עיר:</b></td><td>																<input type="text" name="city" style="width:200px;"		value="<?=$client_city;?>"></td></tr>
  <tr><td><b>רחוב:</b></td><td>																<input type="text" name="address" style="width:200px;"	value="<?=$client_address;?>"></td></tr>
  <tr><td><b>מספר דירה:</b></td><td>														<input type="text" name="dira" style="width:200px;"		value="<?=$client_dira;?>"></td></tr>
  <tr><td><b>מספר בית:</b></td><td>															<input type="text" name="bait" style="width:200px;"		value="<?=$client_bait;?>"></td></tr>
 </table>
</span><div style="padding-top:15px;"></div>
<!-- end of shipping -->

<input id="present" name="present" type="checkbox" onchange="javascript:is_present();"><b>קנה כמתנה</b>
<!-- present -->
<span id=contentm1 style="DISPLAY: block"></span><span id=content1 style="DISPLAY: none">
<div style="padding-top:15px;"></div>
<b>שם מקבל המתנה:</b><div style="padding-top:3px;"></div>									<input type="text" name="present_name"><br><br>
<b>אימייל מקבל המתנה:</b><div style="padding-top:3px;"></div>								<input type="text" name="present_email"><br><br>
<b>הודעה אישית למקבל המתנה:</b><div style="padding-top:3px;"></div>							<textarea name="present_msg" style="width:300px; height:100px;"></textarea>
</span>
<!-- end of present -->

 </td>
 <td width="10"></td>
 <td align="left" valign="top">
  <img src="/products/<?=$deal_image;?>" width="300" height="150" style="">
  <div style="direction:rtl; text-align:right; padding-top:10px;">
  <b>הערות לגבי ההזמנה:</b></div>															<textarea name="notes" style="width:300px; height:100px;"></textarea>
 </td></tr></table>
</div>

<div class="buy_innerdet" style="font-size:14px;">
 <table width="100%"><tr>
   <td align="center" valign="top" style="font-size:25px;"><br>
   <div id="totalPrice"></div>
   <td align="left" valign="top" width="200">
   <input type="image" value="submit" src="images/visa_card.png"></td>
 </tr></table>
</div>

</form>


<? include "footer.php"; } ?>