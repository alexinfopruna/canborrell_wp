<?php

echo json_encode(true);
die();

if (!isset($_REQUEST['client_email'])){
    echo '<form>Valida email:  <input type="text" name="client_email" placeholder="Escriu email"><input type="submit" value="Submit"></form> ';
    die();
}



//ANULAT: problema amb telefonica.net

$domains = ['@telefonica.net', '@ZZZexample.com', '@ZZZdomain.com'];
foreach ($domains as $domain) {
    if (stripos($_REQUEST['client_email'], $domain) !== false) {
        echo json_encode(true);
        die();
    }
}

include 'verifyEmail/vendor/autoload.php';
$ve = new hbattat\VerifyEmail($_REQUEST['client_email'], 'restaurant@can-borrell.com');
$result = $ve->verify() ? true : "Email address does not exist";
echo json_encode($result);
//var_dump($result);
//echo '<pre>';print_r($ve->get_debug());
