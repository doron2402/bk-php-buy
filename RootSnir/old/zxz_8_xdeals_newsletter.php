<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! xdeals.co.il newsletter ! ..                                               *
*********************************************************************************  */

	// defines
	$color = 8;
	
	// includes
	include "header.php";
	include "right_menu.php";
	include "main_menu.php";
	if ($admin == 1) {

		opensql();
		

?>

     <div class="content-box column-left1">		
      <div class="content-box-header">
	   <h3>רשימת Newsletter</h3>
	  </div>
	 <div class="content-box-content">
	

	<table>
	 <tr>
	  <td style="text-align:center;">id</td>
	  <td>mail</td>
	  <td style="text-align:center;">ip</td>
	  <td style="text-align:center;">day</td>
	  <td style="text-align:center;">hour</td>
	  <td style="text-align:center;">status</td>
	 </tr>

	 <?

			$result = mysql_query("SELECT * FROM `Xdeals_newsletter` ORDER BY `id` DESC;");
			$exsist = mysql_num_rows($result);
			for ($i=0;$i<$exsist;$i++)
			{
				$status			= mysql_result($result,$i,"status");
				if ($status == 1) $active_icon = 'tick_circle.png';
				else			  $active_icon = 'cross.png';

				$id				= mysql_result($result,$i,"id");
				$date			= mysql_result($result,$i,"date");
				$hour			= mysql_result($result,$i,"hour");
				$email			= mysql_result($result,$i,"email");
				$ip				= mysql_result($result,$i,"ip");

				echo '
				<tr>
				 <td style="text-align:center;">'.$id.'</td>
				 <td>'.$email.'</td>
				 <td style="text-align:center;">'.$ip.'</td>
				 <td style="text-align:center;">'.$date.'</td>
				 <td style="text-align:center;">'.$hour.'</td>
				 <td style="text-align:center;"><img src="resources/images/icons/'.$active_icon.'"></td>
                </tr>
				';
			}

		closesql();
	 ?>

	 </table>
	</div>
   </div>

<?
	} include "footer.php";
?>