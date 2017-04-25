<?php

include 'wp-load.php';

	global $wpdb;
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
	@mail('elangovana@rajasri.net','IPN from Health and Wellness','IPN from Health and Wellness');	

?>