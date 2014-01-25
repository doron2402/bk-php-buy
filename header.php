<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! header ! ..                                                                *
*********************************************************************************  */

	//error_reporting(0);
	include "functions.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <link rel="shortcut icon" href="http://www.buy10.co.il/images/default/favicon.png" type="image/x-icon"/>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <title><?=$meta_title;?></title>
 <meta name="Description" CONTENT="<?=$meta_description;?>">
 <meta name="Keywords" CONTENT="<?=$meta_keywords;?>"><link href='http://www.buy10.co.il/rss' rel='alternate' title='RSS' type='application/rss+xml' />
 <link href="css/buy10.css" rel="stylesheet" type="text/css" />
 <script type="text/javascript" src="js/jquery.min.js"></script>
 <script type="text/javascript" src="js/jquery-ui.min.js"></script>
 <link rel="stylesheet" type="text/css" href="libs/default/jquery.ui.css/jquery-ui.css">
</head>
<body onload="calculateTotal();">

	<!-- facebook script -->
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/he_IL/all.js#xfbml=1";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<!-- end of facebook script -->

 <div class="contianer" dir="rtl">
  <div class="topbar_link">
   
   <!-- top menu -->
   <div class="topbar_menu">
    <ul>
     <li><a href="texts.php?id=1" style="text-decoration:none; color:#000;">אודותינו</a></li>
     <li><a href="contact.php?id=1" style="text-decoration:none; color:#000;">צור קשר</a></li>
    </ul>
   </div>

   <!-- facebook & twitter -->
   <div class="social_links" style="direction:ltr;">
    <span class='st_facebook_hcount shareButton' displayText='Facebook'></span>
    <span class='st_twitter_hcount shareButton' displayText='Tweet'></span>
   </div>

   <!-- time now -->
   <div class="time_date">
    <div class="time"></div>
    <div class="date"></div>
   </div>

  </div>

  <div class="top_area">
   <div class="top_cont">
    <div class="acc_area">
     <div class="user_login"><a href="user.php"><img src="images/user_login.png" alt="user_login" width="82" height="22" border="0" /></a></div>
    </div>

    <span style="float:right; clear:right; margin-right:40px; margin-top:15px;"><a href="texts.php?id=6"><img src="images/secure.png" alt="secure" width="204" height="96" border="0" /></a></span>
    
	<div class="logo"><a href="/"><img src="images/logo.png" alt="logo" width="282" height="144" border="0" /></a></div>
	
	<div class="topinner_link">

	 <div class="button2">
	  <ul>
	   <li><a href="area.php?id=1"><img src="images/toptxt01.png" alt="txt01" width="99" height="17" border="0" /></a></li>
	   <li><a href="area.php?id=2"><img src="images/toptxt02.png" alt="txt01" width="99" height="17" border="0" /></a></li>
	  </ul>
	 </div>
	 <div class="button3">
	  <ul>
	   <li><a href="area.php?id=3"><img src="images/toptxt03.png" alt="txt01" width="99" height="17" border="0" /></a></li>
	   <li><a href="area.php?id=4"><img src="images/toptxt04.png" alt="txt01" width="99" height="17" border="0" /></a></li>
	   <li><a href="area.php?id=5"><img src="images/toptxt05.png" alt="txt01" width="99" height="17" border="0" /></a></li>
	  </ul>
	 </div>
	</div>
   </div>

   <div class="manu_area">
    <div class="manu_links">
     <ul>
      <li><a href="contact.php?id=1"><img src="images/manu_link05.png" alt="link01" width="129" height="20" border="0" /></a></li>
      <li><a href="special-deals.php"><img src="images/manu_link04.png" alt="link01" width="129" height="20" border="0" /></a></li>
      <li><a href="texts.php?id=5"><img src="images/manu_link03.png" alt="link01" width="129" height="20" border="0" /></a></li>
      <li><a href="previous-deals.php"><img src="images/manu_link02.png" alt="link01" width="129" height="20" border="0" /></a></li>
      <li><a href="/"><img src="images/manu_link01.png" alt="link01" width="129" height="20" border="0" /></a></li>
     </ul>
    </div>
   </div>

   <div id="fb-root"></div>

   <div class="cont_area">
    <style>
     .cont_rightarea {
      float: right;
      width: 740px;
      border:none;
      border-radius:3px 3px 3px 3px;
      box-shadow:none;
      margin-bottom: 15px;
     }
    </style>

    <div class="cont_rightarea">
     <div class="main_conttxt" style="">