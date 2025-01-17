<?php



if (!isset($_REQUEST['client_email'])){
    echo '<form>Valida email:  <input type="text" name="client_email" placeholder="Escriu email"><input type="submit" value="Submit"></form> ';
    die();
}

// Check which indexes appear only once
$unique_indexes = array_keys(array_filter(array_count_values(array_keys($_REQUEST)), function($count) {
    return $count === 1;
}));

echo json_encode($unique_indexes);
die();

echo json_encode($result);
die();

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
