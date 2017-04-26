<?php 
include 'wp-load.php';
print_r($_SESSION);exit;
$user_id = get_current_user_id();

$_SESSION["cmd"] = "";
$_SESSION["business"] = "";
$_SESSION["item_name"] = "";
$_SESSION["item_number"] = "";
$_SESSION["no_shipping"] = "";
$_SESSION["return"] = "";
$_SESSION["cancel_return"] = "";
$_SESSION["no_note"] = "";
$_SESSION["notify_url"] = "";
$_SESSION["currency_code"] = "";
$_SESSION["amount"] = "";
$_SESSION["custom"] = "";

$_SESSION["userid"] = "";

$_SESSION["bookingamount"] = "";

$_SESSION["paypal_login"] = "";



/*
	unset($_SESSION['cmd']);
	unset($_SESSION['business']);
	unset($_SESSION['item_name']);
	unset($_SESSION['item_number']);
	unset($_SESSION['no_shipping']);
	unset($_SESSION['return']);
	unset($_SESSION['cancel_return']);
	unset($_SESSION['no_note']);
	unset($_SESSION['notify_url']);
	unset($_SESSION['currency_code']);
	unset($_SESSION['amount']);
	unset($_SESSION['custom']);
	unset($_SESSION['userid']);
	unset($_SESSION['bookingamount']);
	unset($_SESSION['paypal_login']);
	*/
	if($user_id=='')	
	{
	header("Location:".get_bloginfo('url'));
	exit;
	}
	
	
	echo 'Failure';
?>