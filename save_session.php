<?php

include 'wp-load.php';
session_start();
//print_r($_REQUEST);

$_SESSION['cmd']=$_REQUEST['cmd'];
$_SESSION['business']=$_REQUEST['business'];
$_SESSION['item_name']=$_REQUEST['item_name'];
$_SESSION['item_number']=$_REQUEST['item_number'];
$_SESSION['no_shipping']=$_REQUEST['no_shipping'];
$_SESSION['return']=$_REQUEST['return'];
$_SESSION['cancel_return']=$_REQUEST['cancel_return'];
$_SESSION['no_note']=$_REQUEST['no_note'];
$_SESSION['notify_url']=$_REQUEST['notify_url'];
$_SESSION['currency_code']=$_REQUEST['currency_code'];
$_SESSION['amount']=$_REQUEST['amount'];
$_SESSION['custom']=$_REQUEST['custom'];
$_SESSION['userid']=$_REQUEST['userid'];
$_SESSION['bookingamount']=$_REQUEST['bookingamount'];
$_SESSION['paypal_login']='1';


?>