<?php
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! header page ! ..                                                           *
*********************************************************************************  */

	error_reporting(0);
	include "config.php";
	include "sql.php";
	include "check_user.php";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta http-equiv="Content-Language" content="he">
   <title><?=$Company_name;?> => Coupon system V1.0 - Made by RtB</title>

		<link rel="stylesheet" href="resources/css/reset.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="resources/css/style.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="resources/css/invalid.css" type="text/css" media="screen" />	
		<link rel="stylesheet" href="resources/css/blue.css" type="text/css" media="screen" />

		<!-- Color Schemes
		<link rel="stylesheet" href="resources/css/red.css" type="text/css" media="screen" />  
		-->
		
		<!--[if lte IE 7]><link rel="stylesheet" href="resources/css/ie.css" type="text/css" media="screen" /><![endif]-->
		<script type="text/javascript" src="resources/scripts/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src="resources/scripts/simpla.jquery.configuration.js"></script>
		<script type="text/javascript" src="resources/scripts/facebox.js"></script>
		<script type="text/javascript" src="resources/scripts/jquery.wysiwyg.js"></script>
		
		<!--[if IE 6]>
			<script type="text/javascript" src="resources/scripts/DD_belatedPNG_0.0.7a.js"></script>
			<script type="text/javascript">
				DD_belatedPNG.fix('.png_bg, img, li');
			</script>
		<![endif]-->

		 <script type="text/javascript" src="fancybox/jquery.min.js"></script>
		 <script>!window.jQuery && document.write('<script src="jquery-1.4.3.min.js"><\/script>');</script>
		 <script type="text/javascript" src="fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
		 <script type="text/javascript" src="fancybox/jquery.fancybox-1.3.4.pack.js"></script>
		 <link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox-1.3.4.css" media="screen" />

		<script type="text/javascript">
			$(document).ready(function() {
				$("a.various").fancybox({
					'width'				: 1000,
					'height'			: 800,
					'autoScale'			: false,
					'transitionIn'		: 'none',
					'transitionOut'		: 'none',
					'type'				: 'iframe',
					'onClosed': function() {
					  parent.location.reload(true); ;
					}
				});

				$("a.various_medium").fancybox({
					'width'				: 550,
					'height'			: 300,
					'autoScale'			: false,
					'transitionIn'		: 'none',
					'transitionOut'		: 'none',
					'type'				: 'iframe',
					'onClosed': function() {
					  parent.location.reload(true); ;
					}
				});

				$("a.various_small").fancybox({
					'width'				: 400,
					'height'			: 300,
					'autoScale'			: false,
					'transitionIn'		: 'none',
					'transitionOut'		: 'none',
					'type'				: 'iframe',
					'onClosed': function() {
					  parent.location.reload(true); ;
					}
				});

			});
		</script>

 </head>

 <body>
  <div id="body-wrapper">


