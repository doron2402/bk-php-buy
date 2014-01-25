<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! search for product ! ..                                                    *
*********************************************************************************  */

	// defines
	$color = 4;
	
	// includes
	include "header.php";
	include "right_menu.php";
	include "main_menu.php";

	if ($admin == 1) {

		// String to search
		$set =		$_POST['set'];
		$string =	$_POST['string'];
		if (($set != NULL) && ($string != NULL))
		{
			if ($set == 1)	$url = 'http://www.redpoint.co.il/1_search_admin.php?string='.$string.'';	
			else			$url = 'http://www.sex-toys.co.il/1_search_admin.php?string='.$string.'';

			$parse = file_get_contents($url);
		}

?>
	 <div class="content-box column-left1">		
	  <div class="content-box-header"><h3>>> חפש מוצר</h3></div>
	   <div class="content-box-content">
	    <div class="tab-content default-tab">

     <div class="notification information png_bg">
      <a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="סגור" alt="close" /></a>
      <div>Redpoint ושאר החנויות בעלי מספרים ומקטים שונים. אנא שים לב איפה אתה שם את הפרטים.</div>
     </div> 

	<table>
	 <tr style="text-align:right; background-color:#ffffff;">
	  <td width="200"></td>
	  <td align="center" style="text-align:right;">
		 <b>Redpoint</b><div style="padding-top:5px;"></div>
         <form method="post">
		  <input type="hidden" name="set" value="1">
			הזן מספר, מק"ט או שם: 
			<input type="text" name="string"<? if (($set == "1") && ($string != NULL)) echo ' value="'.$string.'"'; ?>>
			<input class="button" type="submit" value="חפש מוצר!">
		 </form>
      </td>
	  <td align="center" style="text-align:right;">
		 <b>שאר החנויות</b><div style="padding-top:5px;"></div>
         <form method="post">
		  <input type="hidden" name="set" value="2">
			הזן מספר מוצר או מק"ט:
			<input type="text" name="string"<? if (($set == "2") && ($string != NULL)) echo ' value="'.$string.'"'; ?>>
			<input class="button" type="submit" value="חפש מוצר!">
		 </form>
      </td>
	  <td width="200"></td>
	 </tr>
	</table>

	<br><br>
	
<?

	if (($set != NULL) && ($string != NULL))
	{
		$p_exp = explode("<RtB>", $parse);
		// -------------- //
		// -- Redpoint -- //
		// -------------- //
		if ($set == 1)
		{
			if ($parse != NULL)
			{
				echo '
			 <div style="text-align:center; padding:20px 360px 0px 360px;">
			 <ul style="display:table; width:100%; padding:2px; margin:0px;">
			  <li style="float:right; text-align:right; background-image: none;">
			   המוצר נמצא בהצלחה!<br><br><br>
			   <h2>'.$p_exp[0].'</h2><br>
				   <b style="font-size:16px;">מחיר רגיל: ₪<strike>'.$p_exp[2].'</strike><br>
				   מחיר חנות: ₪'.$p_exp[3].'</b><br><br>
				   <a href="'.$p_exp[1].'" style="font-weight:bold; font-size:16px;" target="_blank">» כנס לעמוד המוצר</a>
			  </li>
			  <li style="float:left; text-align:left; background-image: none; line-height:20px;"><img src="'.$p_exp[4].'" width="200"></li>
			 </ul>
			 </div>';
			}
			else { echo '<div style="text-align:center; padding:20px 360px 20px 360px; font-weight:bold; font-size:16px;">המוצר לא נמצא..</div>'; }
		}
		// -------------- //
		// -- Our Stores -- //
		// -------------- //
		else
		{
			if ($parse != NULL)
			{
				echo '
			 <div style="text-align:center; padding:20px 260px 0px 260px;">
			 <ul style="display:table; width:100%; padding:2px; margin:0px;">
			  <li style="float:right; text-align:right; background-image: none;">
			   המוצר נמצא בהצלחה!<br><br><br>
			   <h2>'.$p_exp[0].'</h2><br>
				   <b style="font-size:16px;">מחיר רגיל: ₪<strike>'.$p_exp[2].'</strike><br>
				   מחיר חנות: ₪'.$p_exp[3].'<br>
				   מבצע? ₪'.$p_exp[4].'</b><br><br>';

					$list_exp = explode(",", $list_of_stores);

					foreach ($list_exp as $l)
					{
						echo '<a href="http://www.sticash.com/ref.php?url=http://www.'.$l.'/p.php?sku='.$p_exp[1].'" style="font-weight:bold; font-size:16px;" target="_blank">» '.$l.'</a><br>';
					}
				   
			  echo '</li>
			  <li style="float:left; text-align:left; background-image: none; line-height:20px;"><img src="'.$p_exp[5].'" width="200"></li>
			 </ul>
			 </div>';
			}
			else { echo '<div style="text-align:center; padding:20px 360px 20px 360px; font-weight:bold; font-size:16px;">המוצר לא נמצא..</div>'; }
		}
	}

?>

	  </div>
	 </div>
	</div>
<? } include "footer.php"; ?>