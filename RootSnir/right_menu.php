<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! right menu ! ..                                                            *
*********************************************************************************  */
?>


   <div id="sidebar">
    <div id="sidebar-wrapper">
     <a href="/admin"><img id="logo" src="resources/images/logo.png" alt="Simpla Admin logo" width="200" /></a>
     
	 <div id="profile-links">
	  ברוך הבא <b><? echo $_COOKIE['user']; ?></b>! <a href="index.php?logout=1">[התנתק]</a><br>
	 </div>        

	 <style>div.space { padding-top:10px; }</style>
	 <ul id="main-nav">
	  <li><a href="0_index.php" class="nav-top-item no-submenu				<?php if ($color == 0) echo ' current'; ?>">ראשי</a></li>
	  <li><a href="1_settings.php" class="nav-top-item no-submenu			<?php if ($color == 1) echo ' current'; ?>">הגדרות לקידום</a></li>
	  <li><a href="2_shipping.php" class="nav-top-item no-submenu			<?php if ($color == 2) echo ' current'; ?>">אפשרויות משלוח</a></li>
	  <li><a href="3_areas.php" class="nav-top-item no-submenu				<?php if ($color == 3) echo ' current'; ?>">ניהול איזורים</a></li>			<div class="space"></div>
	  <li><a href="4_deals.php" class="nav-top-item no-submenu				<?php if ($color == 4) echo ' current'; ?>">ניהול דילים</a></li>
	  <li><a href="5_pictures.php" class="nav-top-item no-submenu			<?php if ($color == 5) echo ' current'; ?>">ניהול תמונות</a></li>			<div class="space"></div>
	  <li><a href="6_orders.php" class="nav-top-item no-submenu				<?php if ($color == 6) echo ' current'; ?>">ניהול הזמנות</a></li>
	  <li><a href="7_clients.php" class="nav-top-item no-submenu			<?php if ($color == 7) echo ' current'; ?>">ניהול משתמשים</a></li>			<div class="space"></div>
	  <li><a href="8_newsletter.php" class="nav-top-item no-submenu			<?php if ($color == 8) echo ' current'; ?>">רשימת תפוצה</a></li>	
	  <li><a href="9_send_newsletter.php" class="nav-top-item no-submenu	<?php if ($color == 9) echo ' current'; ?>">שליחת אימיילים</a></li>			<div class="space"></div>
	  <li><a href="10_texts.php" class="nav-top-item no-submenu				<?php if ($color == 10) echo ' current'; ?>">ניהול תכנים</a></li>
	  <li><a href="11_contact_texts.php" class="nav-top-item no-submenu		<?php if ($color == 11) echo ' current'; ?>">דפי צור קשר</a></li>
	  <li><a href="12_special_texts.php" class="nav-top-item no-submenu		<?php if ($color == 12) echo ' current'; ?>">תכנים מיוחדים</a></li>

	 </ul>
    </div>
   </div>
