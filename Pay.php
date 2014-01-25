<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
 <div style="width:100%"><center><img src="images/loading.gif" width="400" height="400" alt=""/></center></div> 
 <div style="visibility:hidden" > 
 <form id="form4" name="form4" action="https://gateway.pelecard.biz/" method="post">

<?php

	include "functions.php";
	include "sql.php";

	/* ----------------------------

           ---- Get Data ----

	------------------------------- */

	$total_pending = ($_POST['per_one']*$_POST['count'])+$_POST['shipping'];
	$total = "".$total_pending."00";

	$deal_id	= $_POST['deal_id'];
	$count		= $_POST['count'];
	$shipping	= $_POST['shipping'];	$shipping_exp = explode("EXP",$shipping);	$shipping = $shipping_exp[1];
	$snif		= $_POST['snif'];

	$city		= $_POST['city'];
	$address	= $_POST['address'];
	$dira		= $_POST['dira'];
	$bait		= $_POST['bait'];
	$notes		= $_POST['notes'];

	$present	= $_POST['present'];	$is_present = 0;
	if ($present == "on")
	{
		$is_present = 1;
		$present_name	= $_POST['present_name'];
		$present_email	= $_POST['present_email'];
		$present_msg	= $_POST['present_msg'];
	}


	opensql();

			mysql_query("INSERT INTO `Coupons_pending` (`pending_id`, `pending_deal_id`, `pending_total`, `pending_shipping`, `pending_count`, `pending_snif`, `pending_city`, `pending_address`, `pending_dira`, `pending_bait`, `pending_notes`, `pending_is_present`, `pending_present_name`, `pending_present_email`, `pending_present_msg`) VALUES (NULL, 
			'".$deal_id."', 
			'".$total_pending."', 
			'".$shipping."', 
			'".$count."', 
			'".$snif."', 
			'".$city."', 
			'".$address."', 
			'".$dira."', 
			'".$bait."', 
			'".$notes."', 
			'".$is_present."',
			'".$present_name."', 
			'".$present_email."', 
			'".$present_msg."');");

			$the_id = mysql_insert_id();

				mysql_query("OPTIMIZE TABLE `Coupons_pending`");
					mysql_query("REPAIR TABLE `Coupons_pending`");
						mysql_query("ANALYZE TABLE `Coupons_pending`");		

			

	closesql();

	/* --------------------------------------------

            ---- Pelecard System ----

	--------------------------------------------- */
	
	/*
		$password = str_replace("+", "`9`", $password);
		$password = str_replace("&", "`8`", $password);
		$password = str_replace("%", "`7`", $password); 
														 */

 	$data = array(
			'userName' => pele_user,        
			'password' => pele_pass,
			'termNo' => pele_numb,
			'pageName' => 'ajaxPage',
			'goodUrl' => goodUrl,
			'errorUrl' => errorUrl,
			'total' => $total,
			'currency' => '1',
			'maxPayments' => maxPayments,
			'minPaymentsNo' => minPaymentsNo,
			'creditTypeFrom' => '',
			'logo' => logo,
			'smallLogo' => smallLogo,
			'hidePciDssLogo' => '',
			'hidePelecardLogo' => '',
			'Theme' => Theme,
			'Background' => Background,
			'backgroundImage' => '',
			'topMargin' => '',
			'supportedCardTypes' => '',
			'parmx' => "tis".$the_id."ANDdis".$deal_id."",
			'hideParmx' => 'True',
			'text1' => $_POST['text1'],
			'text2' => text2,
			'text3' => text3,
			'text4' => text4,
			'text5' => text5,
			'cancelUrl' => $_POST['cancelUrl'],
			'mustConfirm' => '',
			'confirmationText' => '',
			'supportPhone' => '',
			'errorText' => '',
			'id' => '',
			'cvv2' => 'Must',
			'authNum' => '',	
			'shopNo' => '001',
			'frmAction' => '',
			'TokenForTerminal' => '',
			'J5' => '',
			'keepSSL' => '' ## NO TRAILING COMMA
			);
	
	list ($code, $result) = do_post_request($data);
	function do_post_request($data, $optional_headers = null)
	{
		$params = array('http' => array(
				'method' => 'POST',
				'content' => http_build_query($data)
				));

		$url = 'https://gateway.pelecard.biz/';

		if ($optional_headers !== null) {
			$params['http']['header'] = $optional_headers;
		}
		$ctx = stream_context_create($params);
		
		$fp = @fopen($url, 'rb', false, $ctx);
		fpassthru($fp);
		if (!$fp) {
			throw new Exception("Problem with $url, $php_errormsg");
		}
		$response = @stream_get_contents($fp);
		if ($response === false) {
			throw new Exception("Problem reading data from $url, $php_errormsg");
		}
		return array(substr(trim(strip_tags($response)),0,3), trim(strip_tags($response)));
	}

?>

 
<input type="hidden" name="noCheck" value="true" id="noCheck" />
</form>
<script type='text/javascript'>
function submitForm() { document.form4.submit();}
submitForm();
</script>
 
 </div>
</body>
</html>
