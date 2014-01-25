<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! upload & view pictures ! ..                                                *
*********************************************************************************  */

	// ------------- // 
	// -- defines -- //
	// ------------- // 
	$color = 5;
	
	// -------------- // 
	// -- includes -- //
	// -------------- // 
	include "header.php";
	include "right_menu.php";
	include "main_menu.php";

		
	$upload = $_POST['upload'];
	
		if ($upload == 1)
		{

			$target_path = "../products/";
			$added = 1;

			$target_path1 = $target_path . basename( $_FILES['uploadedfile1']['name']); 
			$target_path2 = $target_path . basename( $_FILES['uploadedfile2']['name']); 
			$target_path3 = $target_path . basename( $_FILES['uploadedfile3']['name']); 
			$target_path4 = $target_path . basename( $_FILES['uploadedfile4']['name']); 
			$target_path5 = $target_path . basename( $_FILES['uploadedfile5']['name']); 
			$target_path6 = $target_path . basename( $_FILES['uploadedfile6']['name']); 
			$target_path7 = $target_path . basename( $_FILES['uploadedfile7']['name']); 
			$target_path8 = $target_path . basename( $_FILES['uploadedfile8']['name']); 
			$target_path9 = $target_path . basename( $_FILES['uploadedfile9']['name']); 
			$target_path10 = $target_path . basename( $_FILES['uploadedfile10']['name']); 

			$target_path11 = $target_path . basename( $_FILES['uploadedfile11']['name']); 
			$target_path12 = $target_path . basename( $_FILES['uploadedfile12']['name']); 
			$target_path13 = $target_path . basename( $_FILES['uploadedfile13']['name']); 
			$target_path14 = $target_path . basename( $_FILES['uploadedfile14']['name']); 
			$target_path15 = $target_path . basename( $_FILES['uploadedfile15']['name']); 
			$target_path16 = $target_path . basename( $_FILES['uploadedfile16']['name']); 
			$target_path17 = $target_path . basename( $_FILES['uploadedfile17']['name']); 
			$target_path18 = $target_path . basename( $_FILES['uploadedfile18']['name']); 
			$target_path19 = $target_path . basename( $_FILES['uploadedfile19']['name']); 
			$target_path20 = $target_path . basename( $_FILES['uploadedfile20']['name']); 

			$target_path21 = $target_path . basename( $_FILES['uploadedfile21']['name']); 
			$target_path22 = $target_path . basename( $_FILES['uploadedfile22']['name']); 
			$target_path23 = $target_path . basename( $_FILES['uploadedfile23']['name']); 
			$target_path24 = $target_path . basename( $_FILES['uploadedfile24']['name']); 
			$target_path25 = $target_path . basename( $_FILES['uploadedfile25']['name']); 
			$target_path26 = $target_path . basename( $_FILES['uploadedfile26']['name']); 
			$target_path27 = $target_path . basename( $_FILES['uploadedfile27']['name']); 
			$target_path28 = $target_path . basename( $_FILES['uploadedfile28']['name']); 
			$target_path29 = $target_path . basename( $_FILES['uploadedfile29']['name']); 
			$target_path30 = $target_path . basename( $_FILES['uploadedfile30']['name']); 

			move_uploaded_file($_FILES['uploadedfile1']['tmp_name'], $target_path1);
			move_uploaded_file($_FILES['uploadedfile2']['tmp_name'], $target_path2);
			move_uploaded_file($_FILES['uploadedfile3']['tmp_name'], $target_path3);
			move_uploaded_file($_FILES['uploadedfile4']['tmp_name'], $target_path4);
			move_uploaded_file($_FILES['uploadedfile5']['tmp_name'], $target_path5);
			move_uploaded_file($_FILES['uploadedfile6']['tmp_name'], $target_path6);
			move_uploaded_file($_FILES['uploadedfile7']['tmp_name'], $target_path7);
			move_uploaded_file($_FILES['uploadedfile8']['tmp_name'], $target_path8);
			move_uploaded_file($_FILES['uploadedfile9']['tmp_name'], $target_path9);
			move_uploaded_file($_FILES['uploadedfile10']['tmp_name'], $target_path10);

			move_uploaded_file($_FILES['uploadedfile11']['tmp_name'], $target_path11);
			move_uploaded_file($_FILES['uploadedfile12']['tmp_name'], $target_path12);
			move_uploaded_file($_FILES['uploadedfile13']['tmp_name'], $target_path13);
			move_uploaded_file($_FILES['uploadedfile14']['tmp_name'], $target_path14);
			move_uploaded_file($_FILES['uploadedfile15']['tmp_name'], $target_path15);
			move_uploaded_file($_FILES['uploadedfile16']['tmp_name'], $target_path16);
			move_uploaded_file($_FILES['uploadedfile17']['tmp_name'], $target_path17);
			move_uploaded_file($_FILES['uploadedfile18']['tmp_name'], $target_path18);
			move_uploaded_file($_FILES['uploadedfile19']['tmp_name'], $target_path19);
			move_uploaded_file($_FILES['uploadedfile20']['tmp_name'], $target_path20);

			move_uploaded_file($_FILES['uploadedfile21']['tmp_name'], $target_path21);
			move_uploaded_file($_FILES['uploadedfile22']['tmp_name'], $target_path22);
			move_uploaded_file($_FILES['uploadedfile23']['tmp_name'], $target_path23);
			move_uploaded_file($_FILES['uploadedfile24']['tmp_name'], $target_path24);
			move_uploaded_file($_FILES['uploadedfile25']['tmp_name'], $target_path25);
			move_uploaded_file($_FILES['uploadedfile26']['tmp_name'], $target_path26);
			move_uploaded_file($_FILES['uploadedfile27']['tmp_name'], $target_path27);
			move_uploaded_file($_FILES['uploadedfile28']['tmp_name'], $target_path28);
			move_uploaded_file($_FILES['uploadedfile29']['tmp_name'], $target_path29);
			move_uploaded_file($_FILES['uploadedfile30']['tmp_name'], $target_path30);
		}

	if ($HTTP_GET_VARS['act'] != "view")
	{

?>

<div class="content-box column-left1">		
 <!-- top menu -->
 <div class="content-box-header">
  <h3>הוסף תמונות למאגר</h3>
  <ul class="content-box-tabs">
   <li><a href="?act=view">צפייה בקבצים הקיימים</a></li>
  </ul>
 </div><!-- end of top menu -->

<form enctype="multipart/form-data" method="POST">
 <input type="hidden" name="upload" value="1">
  <div style="padding:20px;">
	<? if ($added == 1) echo '<b style="font-color:red;">הקבצים נוספו בהצלחה!</b><br><br>'; ?>
   <input name="uploadedfile1" type="file">
   <input name="uploadedfile2" type="file">
   <input name="uploadedfile3" type="file"><br>
   <input name="uploadedfile4" type="file">
   <input name="uploadedfile5" type="file">
   <input name="uploadedfile6" type="file"><br>
   <input name="uploadedfile7" type="file">
   <input name="uploadedfile8" type="file">
   <input name="uploadedfile9" type="file"><br>
   <input name="uploadedfile10" type="file">
   <input name="uploadedfile11" type="file">
   <input name="uploadedfile12" type="file"><br>
   <input name="uploadedfile13" type="file">
   <input name="uploadedfile14" type="file">
   <input name="uploadedfile15" type="file"><br>
   <input name="uploadedfile16" type="file">
   <input name="uploadedfile17" type="file">
   <input name="uploadedfile18" type="file"><br>
   <input name="uploadedfile19" type="file">
   <input name="uploadedfile20" type="file">
   <input name="uploadedfile21" type="file"><br>
   <input name="uploadedfile22" type="file">
   <input name="uploadedfile23" type="file">
   <input name="uploadedfile24" type="file"><br>
   <input name="uploadedfile25" type="file">
   <input name="uploadedfile26" type="file">
   <input name="uploadedfile27" type="file"><br>
   <input name="uploadedfile28" type="file">
   <input name="uploadedfile29" type="file">
   <input name="uploadedfile30" type="file"><br>
  </div>
 <div style="padding:10px 20px 20px 0px;"><input type="submit" value="הוסף קבצים למאגר!" style="padding:5px; width:660px;"></div>
</form>
</div>
<? } else { ?>

<div class="content-box column-left1">		
 <!-- top menu -->
 <div class="content-box-header">
  <h3>צפייה בקבצים קיימים</h3>
  <ul class="content-box-tabs">
   <li><a href="?id=1">העלאת קבצים</a></li>
  </ul>
 </div><!-- end of top menu -->
 <div style="padding:20px;">


<div style="height:550px; overflow:auto; scrollbar-face-color:black; scrollbar-shadow-color:black; scrollbar-highlight-color:black;">
 <table style="background-color:#fff;"><tr style="background-color:#fff;">
<?
	// ------------
	// find files 
	// ------------
	$up_directory = '../products/';
	if($HTTP_GET_VARS['dir'] != NULL) {	$up_directory = ".".$HTTP_GET_VARS['dir'].""; $up_directory = str_replace("//", "/", $up_directory); }

		$myDirectory = opendir($up_directory);
		while($entryName = readdir($myDirectory)) {	$dirArray[] = $entryName; } closedir($myDirectory);

		$indexCount	= count($dirArray); sort($dirArray);

		$files = ''; $dirs = '';
		for($index=0; $index < $indexCount; $index++) {
		 if (substr($dirArray[$index], 0, 1) != ".")
		  {

			$type = filetype("".$up_directory."/".$dirArray[$index]."");
			$name = $dirArray[$index];

			if ($name != "edit.php")
			{
				if ($type == "file") $files[] = $name;
				else $dirs[] = $name;
			}
		  }
		}
	$count = 0;
	foreach ($files as $f)
	{
		echo '
		 <td style="background-color:#fff; text-align:right;" align="right" width="100"><center><a href="../products/'.$f.'"><img src="../products/'.$f.'" height="100" width="100" border="0"></a><br>'.$f.'</td>';
		$count++;
		if($count%8 == 0)
			echo '</tr><tr>';
	}
?>
   </tr>
  </table>
  </div>

 </div>
</div>

<? } include "footer.php"; ?>