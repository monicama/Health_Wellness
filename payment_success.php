<?php

include 'wp-load.php';

global $wpdb;
print_r($_POST);exit;
// assign posted variables to local variables
$txn_id 			= $_POST['txn_id'];
$item_name 			= $_POST['item_name'];
$item_number 		= $_POST['item_number'];
$payment_status 	= $_POST['payment_status'];
$payment_amount 	= $_POST['mc_gross'];
$payment_currency 	= $_POST['mc_currency'];
$receiver_email 	= $_POST['receiver_email'];
$payer_email 		= $_POST['payer_email'];
$payment_fee 		= $_POST['payment_fee'];
$settle_amount 		= $_POST['settle_amount'];
$mc_fee 			= $_POST['mc_fee'];	
$business 			= $_POST['business']; 
$receiver_id 		= $_POST['receiver_id'];
$quantity	    	= $_POST['quantity'];
$payment_type 		= $_POST['payment_type']; 
$memo				= $_POST['memo']; 
$txn_type 			= $_POST['txn_type'];
$invoice 			= $_POST['invoice'];
$custom 			= $_POST['custom'];
$notify_version 	= $_POST['notify_version'];
$verify_sign 		= $_POST['verify_sign'];
$payer_id 			= $_POST['payer_id']; 
$pending_reason 	= $_POST['pending_reason'];
$reason_code 		= $_POST['reason_code'];
$date				= date("Y-m-d");


$custom = $_POST['custom'];
$expcustom = explode("@@@",$custom); 
$userid=$expcustom[0];
$book_date=$expcustom[1];
$book_time=$expcustom[2];

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

  /* for inserting into Payment table  */

  $insertquery_pay	="INSERT INTO ".$wpdb->prefix."booking_payment(
					   `user_id`,
					   `booking_date`,
					   `booking_time`,					   
					   `txn_id`,
					   `booking_item`,
					   `payment_gross`,
					   `paymentCurrency`,
					   `payer_email`,
					   `receiver_email`,
					   `payment_date`,
					   `PaypalPaymentStatus`
                        ) VALUES (
                        '".$userid."',
                        '".$book_date."',
                        '".$book_time."',                        
                        '".$txn_id."',
                        '".$item_name."',                        
                        '".$payment_amount."',
                        '".$payment_currency."',                      
                        '".$payer_email."',
                        '".$receiver_email."',
                         now(),
                        '".$payment_status."')"; 
   
      

$ExeInsQuery= mysql_query($insertquery_pay);
echo mysql_insert_id();



  global $wpdb;

	$b_user_id=$user_id;
	
	$b_name=$current_user->user_login;
	
	$b_email=$current_user->user_email;
	
	$b_date=$_POST['date_booking'];
	
	$b_time=$_POST['time_booking'];
	
	$b_type=1;
	
	$b_country=$user_country;
	
	$b_ipaddress=$myip;
		
	$q="insert into ".$wpdb->prefix."booking (b_user_id,b_name,b_email,b_date,b_time,b_type,b_added_date,b_ipaddress,b_country) 
	values('".$b_user_id."','".$b_name."','".$b_email."','".$b_date."','".$b_time."','".$b_type."',now(),'".$b_ipaddress."','".$b_country."')";
	
	$wpdb->query($q);
	
	
	//wp_redirect(get_bloginfo('url')."/appointment-booking/?booking=sucess");
	
	 $redirect=get_bloginfo('url')."/appointment-booking/?booking=sucess";
	 
	 echo '<script>window.location.href="'.$redirect.'"</script>';

	exit;



//customer order email
/*
 
	$email=$useremailid;
		$imgurl.=$config['SiteGlobalPath']."images/logo.jpg"; 
	if($paystup_type=='Enhanced Paystub')
		$paystuburl=$config['SiteGlobalPath']."/getenpaystub.php?ref=".$paystup_ref; 
	else
		$paystuburl=$config['SiteGlobalPath']."/getpaystub.php?ref=".$paystup_ref; 
	

		
		
	$mess='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<style type="text/css">
<!--
.style1 {
	font-size: 16px;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<table width="700" border="0" cellspacing="0" cellpadding="7">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            </tr>
          <tr>
            <td height="35" align="center" bgcolor="#FFFFFF" class="normal_txt7"><table width="97%"  cellspacing="4" cellpadding="4" style="font-family:Verdana; font-size:12px;">
              <tr>
                <td ><img src="'.$imgurl.'" /></td>
                </tr>
              <tr>
              <tr>
                <td height="25" colspan="2" bgcolor="#CCCCCC"><span class="style1"> Order Form </span></td>
                </tr>
              <tr>
                <td height="25" colspan="2" bgcolor="#F8F8F8">Your transaction has been completed sucessfully.<br />
                  <br />
                  Your order details: </td>
                </tr>
              
				<tr>
                <td bgcolor="#F8F8F8"><strong>Transaction ID </strong></td>
                <td height="25" align="left" valign="middle" bgcolor="#F8F8F8" ><span class="normal_blue">'.$txn_id.'</span></td>
                </tr>
				<tr>
                <td bgcolor="#F8F8F8"><strong>	Payment Status</strong></td>
                <td height="25" align="left" valign="middle" bgcolor="#F8F8F8" ><span class="normal_blue">'.$payment_status.'</span></td>
                </tr>
				<tr>
                <td bgcolor="#F8F8F8"><strong>Payment Amount </strong></td>
                <td height="25" align="left" valign="middle" bgcolor="#F8F8F8" ><span class="normal_blue">'.$payment_amount.'</span></td>
                </tr>
				
                  <td valign="top" bgcolor="#F8F8F8"><strong> 	Payment Currency</strong></td>
				  <td height="25" align="left" valign="middle" bgcolor="#F8F8F8" > USD </td>
				  </tr>
				<tr>
                  <td valign="top" bgcolor="#F8F8F8"><strong> Payment Made Date</strong></td>
				  <td height="25" align="left" valign="middle" bgcolor="#F8F8F8" >'.$date.' </td>
				  </tr>
				  
				  <tr>
                  <td valign="top" bgcolor="#F8F8F8"><strong> Download Paystub here</strong></td>
				  <td height="25" align="left" valign="middle" bgcolor="#F8F8F8" >'.$paystuburl.' </td>
				  </tr>
				  
				  
				<tr>
				  <td valign="top" bgcolor="#F8F8F8">&nbsp;</td>
				  <td height="25" align="left" valign="middle" bgcolor="#F8F8F8" >&nbsp;</td>
				  </tr>
				<tr>
				  <td valign="top" bgcolor="#F8F8F8">Regards,</td>
				  <td height="25" align="left" valign="middle" bgcolor="#F8F8F8" >&nbsp;</td>
				  </tr>
				<tr>
				  <td height="25" colspan="2" valign="top" bgcolor="#F8F8F8"><strong>Admin</strong></td>
				  </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>';
	$subject  = "Order Confirmation Mail";	
	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	$headers .= "From: ".$email."\r\n";
	
	$customermail=@mail($email,$subject,$mess,$headers);	
*/

?>