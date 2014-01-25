<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! footer ! ..                                                                *
*********************************************************************************  */
?>


        </div>
       </div>

       <script>
       function checkform_news ( form )
       {
		 var x=document.forms["myForm"]["email"].value;
		 var atpos=x.indexOf("@");
		 var dotpos=x.lastIndexOf(".");
		 if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
		  {
		  alert("כתובת האימייל שהזנת אינה חוקית.");
		  return false;
		  }
       }
       </script>
       <div class="leftcont_area">

		<? if (this_is_index != 1) { ?>
		<!-- newsletter --> 
        <div class="search_area">
         <form name="myForm" method="post" style="padding:0px; margin:0px;" onsubmit="return checkform_news(this);">
	      <input type="hidden" name="subscribe" value="1">
           <div class="search_tit">הרשמו לקבלת מבצעים למייל!</div>
           <div class="search_field"><input name="email" id="semail" autocomplete="off" type="text"  class="search_input"/></div>
           <div class="search_but"><input type="submit" class="search_but01" value="שלח" style="float:right" /></div>
         </form>
        </div>
       <!-- newsletter -->

          <div class="facebook_share">
           <div class="fb_link">
            <iframe src="//www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fpages%2FBuy10%2F348885281798352&amp;width=221&amp;height=258&amp;colorscheme=light&amp;show_faces=true&amp;border_color=%23FFFFFF&amp;stream=false&amp;header=false&amp;appId=152433734874263" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:221px; height:258px;" allowTransparency="true"></iframe>
            </div>
           </div>
		<? } ?>

           <div class="deal_offercont">
            
		   <!-- more deals -->
		   <? 
			opensql();
			show_more_deals($deal_now, $area_now);
			closesql();
		   ?>
		   <!-- end of more deal -->




             <!-- <div class="socialgift_icons">
              <div class="social_icons">
               <div class="fb_icon">
                <a href="javascript:void(0)" onclick="return fbs_click()">
					<img src="images/fb_icons.png" alt="fb_icon" width="76" height="76" border="0" />
				</a>
               </div>

             <div class="tweeter_icon">
               <a href="http://twitter.com/share?url=http%3A%2F%2Fwww.buy10.co.il%2F&amp;text=%D7%A6%D7%91%D7%A2%D7%99%D7%9D+%D7%9B%D7%90%D7%9C%D7%94+%D7%A2%D7%95%D7%93+%D7%9C%D7%90+%D7%A8%D7%90%D7%99%D7%AA%D7%9D%21%21%21+%D7%A1%D7%98+%D7%9E%D7%A6%D7%A2%D7%99%D7%9D+%D7%96%D7%95%D7%92%D7%99+%D7%9E%D7%94%D7%9E%D7%9D+%D7%91%D7%99%D7%95%D7%A4%D7%99%D7%95%21+%D7%A8%D7%A7+%D7%91349+%E2%82%AA+%D7%91%D7%9E%D7%A7%D7%95%D7%9D+600+%E2%82%AA%21%21%21&amp;via=buybaby&amp;related=myaccount" target="_blank" style="outline:none;text-decoration:none;">
                <img src="images/tweeter_icon.png" alt="tweeter_icon" width="76" height="76" border="0" />
               </a>
              </div>

              <div class="google_icon">
               <a href="javascript:void(0)" onclick="return cplus_click()">
                <img src="images/google_icon.png" alt="google_icon" width="79" height="79" border="0" />
               </a>
              </div>

              <div class="gift_icon">
               <a href="http://www.buy10.co.il/Buy/product/NQ==.html?gift=yes" style="outline:none;text-decoration:none;">
                <img src="images/gift_icon.png" alt="gift_icon" width="215" height="50" border="0" />
               </a>
              </div>

              <div class="mail_icon">
               <a href="javascript:void(0)" id="referToFriend" style="outline:none;text-decoration:none;">
                <img src="images/mail_icon.png" alt="mail_icon" width="215" height="50" border="0" />
               </a>
              </div> -->

             </div>
            </div>
           </div>
          </div>
         </div>

         <div class="footer" dir="rtl">
          <div class="foot_area">
           <div class="foot_buy10wishlist">
            <div class="wishlist_logo">
             <a href="contact.php?id=2" style="color:#292929; text-decoration:none;">
              <img src="images/buy10_wishlist_logofooter.png" alt="wishlist" width="149" height="93" border="0" />
              <br><div style="padding-top:5px;"></div>
              <span style="font-size:14px;">רעיונות לדילים?<br>זה המקום שלכם!</span></a>
             </div>
            <div class="wishlistcont"></div>
           </div>

           <div class="foot_buy10wishlist">
            <div class="wishlist_logo">
             <a href="contact.php?id=3" style="color:#292929; text-decoration:none;">
              <img src="images/buy10business.png" alt="wishlist" width="149" height="93" border="0" />
              <br><div style="padding-top:5px;"></div>
              <span style="font-size:14px;">רוצים לפרסם את העסק? זה המקום שלכם</span></a>
             </div>
             <div class="wishlistcont"></div>
            </div>
           <div class="footer_menu">
            <div class="footer_menulinks">
             <ul>
              <li><a href="texts.php?id=1">אודותינו</a></li>
              <li><a href="texts.php?id=2">שאלות ותשובות</a></li>
              <li><a href="contact.php?id=1">צור קשר</a></li>
              <li><a href="previous-deals.php">מבצעים קודמים</a></li>
              <li><a href="texts.php?id=3">תנאי שימוש</a></li>
             </ul>
            </div>
           </div>

           <div class="footer_log">
            <a href="http://www.impala.co.il/" target="_blank">
             <img src="images/footer_impala.png" alt="בניית אתר" width="52" height="52" border="0" />
            </a>
            <a href="http://www.impala.co.il" target="_blank" style="text-align:center; font-size:8px; color:#000; display:block; width:52px"> בניית אתרים</a>
           </div>
          <div class="footer-text">כל הזכויות שמורות 2012 &copy; - אינטן </div>
         </div>
        </div>


</body>
</html>

