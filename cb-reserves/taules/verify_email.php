<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
include 'verifyEmail/vendor/autoload.php';
$ve = new hbattat\VerifyEmail($_REQUEST['client_email'], 'restaurant@can-borrell.com');
$result = $ve->verify()?true:"Email address does not exist";
echo json_encode($result);

//var_dump($result);
//echo '<pre>';print_r($ve->get_debug());
