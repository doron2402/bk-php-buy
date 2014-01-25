<?
/* **********************************************************************************
*   Copyright (C)2011 - by RtB                                                      *
*   All Rights Reserved.                                                            *
*   Sti only!                                                                       *
*   stisites@gmail.com                                                              *
*   .. ! edit xdeals deal ! ..                                                      *
*********************************************************************************  */

	error_reporting(0);

	// ------------ //
	// -- Config -- //
	// ------------ //
	$id = $HTTP_GET_VARS['id'];

	// -------------- //
	// -- Includes -- //
	// -------------- //
	include "sql.php";
	include "check_user.php";

	if ($admin == 1)
	{

		// -------------- //
		// -- includes -- //
		// -------------- //
		include "zxz_7_xdeals_functions.php";
		show_header();

		// --------------------- //
		// -- Get Xdeals Data -- //
		// --------------------- //
		opensql();

			$result = mysql_query("SELECT * FROM `Xdeals` WHERE id='".$id."'");
				
				// info
				$pro['deal']	= mysql_result($result,0,"id");	
				$pro['id']		= mysql_result($result,0,"product_id");
				$pro['end']		= mysql_result($result,0,"end_date");
				$pro['image']	= mysql_result($result,0,"image");
				$pro['active']	= mysql_result($result,0,"active");

				// prices
				$pro['reg']		= mysql_result($result,0,"reg_price");
				$pro['our']		= mysql_result($result,0,"our_price");
				$pro['red']		= mysql_result($result,0,"rprice");

				// texts
				$pro['name']	  = mysql_result($result,0,"deal_name");
				$pro['name_left'] = mysql_result($result,0,"deal_name_left");
				$pro['text']	  = mysql_result($result,0,"full_text");
				$pro['mifrat']	  = mysql_result($result,0,"mifrat");

		closesql();

		// ------------- //
		// -- Updates -- //
		// ------------- //
		if ($_POST != NULL)
		{
			if ($_POST['update_product'] == 1)
				update_product_in_db($_POST['product'], $id);

			if ($_POST['update_deal'] == 1)
				edit_deal($_POST, $id);
		}
		
		// ----------- //
		// -- Forms -- //
		// ----------- //
		else
		{
			if ($pro['id'] == 0)
				select_product($pro);
		
			else
				show_deal_form($pro);
		}

		echo '</div></div></div></div></div></div>
		<div style="padding-top:20px;"></div>';

	}
?>