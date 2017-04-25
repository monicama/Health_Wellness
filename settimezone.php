<?php

include 'wp-load.php';
session_start();
//print_r($_REQUEST);
$_SESSION['timezone']=$_REQUEST['offset'];

?>