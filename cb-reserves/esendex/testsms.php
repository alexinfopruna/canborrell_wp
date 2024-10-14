<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


    include_once( "../editar/SMSphp/EsendexSendService.php" );


    $essedex_user = "restaurant@can-borrell.com";     // Your Username (normally an email address).
    $essedex_pwd = "iridioArgon:17";     // Your Password 04/3/2019.


    $accountReference = "EX0062561";    // Your Account Reference (either your virtual mobile number, or EX account number).
    $originator = "Rest.Can Borrell";   // An alias that the message appears to come from (alphanumeric characters only, and must be less than 11 characters).

    $recipients="606782798";
    $body = "HOLAAA";
    $type = "Text";

      try {
        $sendService = new EsendexSendService($essedex_user, $essedex_pwd, $accountReference);
        $result = $sendService->SendMessage($recipients, $body, $type);
        $pr = print_r($result, TRUE);
      }
      catch (Exception $e) {
        $result['Result'] = "SMS: ERROR";
	}
