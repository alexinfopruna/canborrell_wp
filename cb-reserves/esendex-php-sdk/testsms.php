<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    //include_once( "../editar/SMSphp/EsendexSendService.php" );
    require_once 'vendor/autoload.php';


$message = new \Esendex\Model\DispatchMessage(
    "canborrell", // Send from
    "606782798", // Send to any valid number
    "can borrell ".date("Y-m-d h:i:s",time()),
    \Esendex\Model\Message::SmsType
);
$authentication = new \Esendex\Authentication\LoginAuthentication(
    "EX0062561", // Your Esendex Account Reference
    "restaurant@can-borrell.com", // Your login email address
    "iridioArgon:17" // Your password
);

try{
    $service = new \Esendex\DispatchService($authentication);
    $result = $service->send($message);

    print $result->id();
    print $result->uri();
} catch (Exception $e) {
    echo "ERROR $e";

}



